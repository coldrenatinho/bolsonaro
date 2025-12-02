#!/bin/bash

# Script de Deploy para Rocky Linux / CentOS com Nginx existente
# Execute no servidor: sudo ./deploy-rocky.sh

set -e

echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                                                                      ║"
echo "║   🚀 DEPLOY - bolsonarolivre.publicvm.com (Rocky Linux)             ║"
echo "║                                                                      ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log_info() { echo -e "${GREEN}✓${NC} $1"; }
log_warn() { echo -e "${YELLOW}⚠${NC} $1"; }
log_error() { echo -e "${RED}✗${NC} $1"; }
log_step() {
    echo ""
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
}

# Verificar root
if [ "$EUID" -ne 0 ]; then 
    log_error "Execute como root: sudo ./deploy-rocky.sh"
    exit 1
fi

CURRENT_DIR=$(pwd)
DEPLOY_DIR="/var/www/bolsonaro"

# PASSO 1: Copiar arquivos
log_step "1. Copiando arquivos para $DEPLOY_DIR"

mkdir -p $DEPLOY_DIR
rsync -av --progress \
    --exclude='logs/*' \
    --exclude='uploads/galeria/*' \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='deploy*.sh' \
    --exclude='*.md' \
    $CURRENT_DIR/ $DEPLOY_DIR/

cd $DEPLOY_DIR
log_info "Arquivos copiados"

# PASSO 2: Criar diretórios
log_step "2. Criando diretórios necessários"

mkdir -p logs uploads/galeria
chmod 777 logs uploads/galeria
log_info "Diretórios criados"

# PASSO 3: Instalar Docker
log_step "3. Verificando Docker"

if command -v docker &> /dev/null; then
    log_info "Docker instalado: $(docker --version)"
else
    log_warn "Instalando Docker..."
    dnf config-manager --add-repo=https://download.docker.com/linux/centos/docker-ce.repo
    dnf install -y docker-ce docker-ce-cli containerd.io
    systemctl enable --now docker
    log_info "Docker instalado"
fi

if command -v docker-compose &> /dev/null; then
    log_info "Docker Compose instalado"
else
    log_warn "Instalando Docker Compose..."
    curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
    ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
    log_info "Docker Compose instalado"
fi

# PASSO 4: Configurar SELinux (Rocky Linux específico)
log_step "4. Configurando SELinux"

if command -v setenforce &> /dev/null; then
    # Permitir Docker se conectar
    setsebool -P httpd_can_network_connect 1
    # Permitir Nginx fazer proxy
    setsebool -P httpd_can_network_relay 1
    log_info "SELinux configurado"
else
    log_warn "SELinux não detectado"
fi

# PASSO 5: Parar containers antigos
log_step "5. Gerenciando containers Docker"

if docker ps -a | grep -q "peticao"; then
    log_warn "Parando containers existentes..."
    docker-compose down 2>/dev/null || true
fi

docker-compose up -d --build
log_info "Containers iniciados"

sleep 8

# Verificar containers
if docker ps | grep -q "peticao"; then
    log_info "Containers rodando:"
    docker ps --filter "name=peticao" --format "  • {{.Names}}"
else
    log_error "Erro ao iniciar containers!"
    docker-compose logs --tail=30
    exit 1
fi

# PASSO 6: Configurar Nginx
log_step "6. Configurando Nginx"

# Copiar configuração
cp $DEPLOY_DIR/bolsonarolivre.conf /etc/nginx/conf.d/

log_info "Configuração copiada para /etc/nginx/conf.d/bolsonarolivre.conf"

# Testar configuração
if nginx -t; then
    systemctl reload nginx
    log_info "Nginx recarregado"
else
    log_error "Erro na configuração Nginx!"
    exit 1
fi

# PASSO 7: Configurar Firewall
log_step "7. Configurando Firewall"

if command -v firewall-cmd &> /dev/null; then
    # Rocky Linux usa firewalld
    firewall-cmd --permanent --add-service=http
    firewall-cmd --permanent --add-service=https
    firewall-cmd --reload
    log_info "Firewall configurado (firewalld)"
else
    log_warn "Firewalld não encontrado"
fi

# PASSO 8: Testar
log_step "8. Testando deploy"

sleep 2
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8080)

if [ "$HTTP_CODE" = "200" ]; then
    log_info "Site respondendo (HTTP $HTTP_CODE)"
else
    log_warn "Site retornou HTTP $HTTP_CODE"
fi

# Obter IP
PUBLIC_IP=$(curl -s ifconfig.me 2>/dev/null || echo "177.155.222.159")

# RESUMO
echo ""
echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                                                                      ║"
echo "║   ✅ DEPLOY CONCLUÍDO!                                              ║"
echo "║                                                                      ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""
echo "🌐 URLs de Acesso:"
echo "   • http://bolsonarolivre.publicvm.com"
echo "   • http://$PUBLIC_IP"
echo ""
echo "📊 Containers:"
docker ps --filter "name=peticao" --format "table {{.Names}}\t{{.Status}}"
echo ""
echo "🔒 PRÓXIMO PASSO - Configurar HTTPS:"
echo ""
echo "   1. Instalar Certbot:"
echo "      dnf install -y certbot python3-certbot-nginx"
echo ""
echo "   2. Obter certificado SSL:"
echo "      certbot --nginx -d bolsonarolivre.publicvm.com -d www.bolsonarolivre.publicvm.com"
echo ""
echo "   3. Testar renovação automática:"
echo "      certbot renew --dry-run"
echo ""
echo "📋 Arquivos Importantes:"
echo "   • Código: $DEPLOY_DIR"
echo "   • Nginx config: /etc/nginx/conf.d/bolsonarolivre.conf"
echo "   • Logs: /var/log/nginx/bolsonaro-*.log"
echo ""
echo "🔧 Comandos Úteis:"
echo "   • Ver logs:      docker-compose -f $DEPLOY_DIR/compose.yml logs -f"
echo "   • Reiniciar:     docker-compose -f $DEPLOY_DIR/compose.yml restart"
echo "   • Reload Nginx:  systemctl reload nginx"
echo "   • Status:        docker ps"
echo ""
