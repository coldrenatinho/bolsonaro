#!/bin/bash

# Script de Deploy LOCAL
# Execute este script DENTRO do servidor (177.155.222.159)

set -e  # Parar em caso de erro

echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                                                                      ║"
echo "║   🚀 DEPLOY LOCAL - bolsonarolivre.publicvm.com                     ║"
echo "║                                                                      ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

log_info() {
    echo -e "${GREEN}✓${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}⚠${NC} $1"
}

log_error() {
    echo -e "${RED}✗${NC} $1"
}

log_step() {
    echo ""
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
}

# Verificar se está rodando como root
if [ "$EUID" -ne 0 ]; then 
    log_error "Execute como root: sudo ./deploy-local.sh"
    exit 1
fi

# Detectar diretório atual
CURRENT_DIR=$(pwd)
log_info "Diretório atual: $CURRENT_DIR"

# Perguntar onde copiar os arquivos
echo ""
read -p "Copiar arquivos para /var/www/bolsonaro? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    DEPLOY_DIR="/var/www/bolsonaro"
    
    log_step "1. Copiando arquivos para $DEPLOY_DIR"
    
    # Criar diretório
    mkdir -p $DEPLOY_DIR
    
    # Copiar arquivos (excluindo git, logs, etc)
    rsync -av --progress \
        --exclude='logs/*' \
        --exclude='uploads/galeria/*' \
        --exclude='.git' \
        --exclude='node_modules' \
        --exclude='deploy*.sh' \
        $CURRENT_DIR/ $DEPLOY_DIR/
    
    cd $DEPLOY_DIR
    log_info "Arquivos copiados para $DEPLOY_DIR"
else
    DEPLOY_DIR=$CURRENT_DIR
    log_info "Usando diretório atual: $DEPLOY_DIR"
fi

# Criar diretórios necessários
log_step "2. Criando diretórios necessários"

mkdir -p $DEPLOY_DIR/logs
mkdir -p $DEPLOY_DIR/uploads/galeria
chmod 777 $DEPLOY_DIR/logs
chmod 777 $DEPLOY_DIR/uploads/galeria

log_info "Diretórios criados com permissões corretas"

# Verificar/Instalar Docker
log_step "3. Verificando Docker"

if command -v docker &> /dev/null; then
    log_info "Docker já instalado: $(docker --version)"
else
    log_warn "Docker não encontrado. Instalando..."
    curl -fsSL https://get.docker.com | sh
    log_info "Docker instalado"
fi

if command -v docker-compose &> /dev/null; then
    log_info "Docker Compose já instalado: $(docker-compose --version)"
else
    log_warn "Docker Compose não encontrado. Instalando..."
    apt-get update
    apt-get install -y docker-compose
    log_info "Docker Compose instalado"
fi

# Parar containers antigos (se existirem)
log_step "4. Parando containers antigos"

cd $DEPLOY_DIR

if docker ps -a | grep -q "peticao"; then
    log_warn "Parando containers existentes..."
    docker-compose down 2>/dev/null || true
    log_info "Containers parados"
else
    log_info "Nenhum container anterior encontrado"
fi

# Subir containers
log_step "5. Iniciando containers Docker"

docker-compose up -d --build

log_info "Aguardando containers ficarem prontos..."
sleep 8

# Verificar containers
RUNNING_CONTAINERS=$(docker ps --filter "name=peticao" --format "{{.Names}}")

if [ -z "$RUNNING_CONTAINERS" ]; then
    log_error "Nenhum container rodando! Verificando logs..."
    docker-compose logs --tail=50
    exit 1
else
    log_info "Containers rodando:"
    echo "$RUNNING_CONTAINERS" | while read container; do
        echo "  • $container"
    done
fi

# Verificar Nginx
log_step "6. Verificando Nginx no servidor"

if command -v nginx &> /dev/null; then
    log_info "Nginx já instalado: $(nginx -v 2>&1)"
else
    log_warn "Nginx não encontrado. Instalando..."
    apt-get update
    apt-get install -y nginx
    systemctl enable nginx
    systemctl start nginx
    log_info "Nginx instalado e iniciado"
fi

# Criar configuração do site
log_step "7. Configurando Nginx como Proxy Reverso"

NGINX_CONFIG="/etc/nginx/sites-available/bolsonarolivre"

cat > $NGINX_CONFIG << 'EOF'
server {
    listen 80;
    server_name bolsonarolivre.publicvm.com www.bolsonarolivre.publicvm.com 177.155.222.159;
    
    access_log /var/log/nginx/bolsonaro-access.log;
    error_log /var/log/nginx/bolsonaro-error.log;
    
    client_max_body_size 10M;
    
    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_buffering off;
        
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
    
    # Cache para arquivos estáticos
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|webp|woff|woff2)$ {
        proxy_pass http://localhost:8080;
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
EOF

log_info "Configuração Nginx criada: $NGINX_CONFIG"

# Ativar site
if [ -f "/etc/nginx/sites-enabled/bolsonarolivre" ]; then
    log_info "Site já está ativado"
else
    ln -s $NGINX_CONFIG /etc/nginx/sites-enabled/bolsonarolivre
    log_info "Site ativado"
fi

# Remover site default (opcional)
if [ -f "/etc/nginx/sites-enabled/default" ]; then
    log_warn "Removendo site default..."
    rm /etc/nginx/sites-enabled/default
fi

# Testar configuração Nginx
log_step "8. Testando configuração Nginx"

if nginx -t; then
    log_info "Configuração Nginx OK"
    systemctl reload nginx
    log_info "Nginx recarregado"
else
    log_error "Erro na configuração Nginx!"
    exit 1
fi

# Configurar Firewall
log_step "9. Configurando Firewall (UFW)"

if command -v ufw &> /dev/null; then
    # Permitir SSH (CRÍTICO!)
    ufw allow 22/tcp > /dev/null 2>&1 || true
    
    # Permitir HTTP e HTTPS
    ufw allow 80/tcp > /dev/null 2>&1 || true
    ufw allow 443/tcp > /dev/null 2>&1 || true
    
    # Ativar firewall (se não estiver)
    ufw --force enable > /dev/null 2>&1 || true
    
    log_info "Firewall configurado (portas 22, 80, 443)"
else
    log_warn "UFW não instalado. Instalando..."
    apt-get install -y ufw
    ufw allow 22/tcp
    ufw allow 80/tcp
    ufw allow 443/tcp
    ufw --force enable
    log_info "Firewall instalado e configurado"
fi

# Testar site
log_step "10. Testando deploy"

sleep 2

HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8080)

if [ "$HTTP_CODE" = "200" ]; then
    log_info "Site respondendo corretamente (HTTP $HTTP_CODE)"
else
    log_warn "Site retornou HTTP $HTTP_CODE"
    log_warn "Verificando logs do container..."
    docker-compose logs --tail=20 nginx
fi

# Obter IP público
PUBLIC_IP=$(curl -s ifconfig.me || echo "177.155.222.159")

# Resumo final
echo ""
echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                                                                      ║"
echo "║   ✅ DEPLOY CONCLUÍDO COM SUCESSO!                                  ║"
echo "║                                                                      ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""
echo "🌐 URLs de Acesso:"
echo "   • http://bolsonarolivre.publicvm.com"
echo "   • http://$PUBLIC_IP"
echo "   • http://localhost:8080 (direto no container)"
echo ""
echo "📊 Status dos Containers:"
docker ps --filter "name=peticao" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
echo ""
echo "📁 Arquivos do Projeto:"
echo "   • Código: $DEPLOY_DIR"
echo "   • Logs Nginx: /var/log/nginx/bolsonaro-*.log"
echo "   • Logs Docker: docker-compose logs -f"
echo ""
echo "🔒 Próximos Passos:"
echo ""
echo "   1️⃣  Configurar HTTPS (SSL/TLS):"
echo "       apt install certbot python3-certbot-nginx -y"
echo "       certbot --nginx -d bolsonarolivre.publicvm.com"
echo ""
echo "   2️⃣  Verificar site no navegador:"
echo "       http://bolsonarolivre.publicvm.com"
echo ""
echo "   3️⃣  Monitorar logs:"
echo "       tail -f /var/log/nginx/bolsonaro-access.log"
echo "       docker-compose -f $DEPLOY_DIR/compose.yml logs -f"
echo ""
echo "   4️⃣  Verificar anúncios Adsterra:"
echo "       https://beta.publishers.adsterra.com/"
echo ""
echo "🔧 Comandos Úteis:"
echo "   • Reiniciar containers:  cd $DEPLOY_DIR && docker-compose restart"
echo "   • Ver logs:              docker-compose -f $DEPLOY_DIR/compose.yml logs -f"
echo "   • Parar containers:      docker-compose -f $DEPLOY_DIR/compose.yml down"
echo "   • Status:                docker ps"
echo "   • Recarregar Nginx:      systemctl reload nginx"
echo ""
echo "✨ Site pronto para receber tráfego e gerar receita! ✨"
echo ""
