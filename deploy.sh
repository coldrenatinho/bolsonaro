#!/bin/bash

# Script de Deploy Automatizado
# Para: bolsonarolivre.publicvm.com (177.155.222.159)

set -e  # Parar em caso de erro

echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                                                                      ║"
echo "║   🚀 DEPLOY - bolsonarolivre.publicvm.com                           ║"
echo "║                                                                      ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""

# Configurações
SERVER_IP="177.155.222.159"
SERVER_USER="root"
REMOTE_DIR="/var/www/bolsonaro"
LOCAL_DIR="."

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função de log
log_info() {
    echo -e "${GREEN}✓${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}⚠${NC} $1"
}

log_error() {
    echo -e "${RED}✗${NC} $1"
}

# Verificar conexão SSH
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "1. Verificando conexão com servidor..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if ssh -o ConnectTimeout=5 $SERVER_USER@$SERVER_IP "exit" 2>/dev/null; then
    log_info "Conexão SSH estabelecida com $SERVER_IP"
else
    log_error "Falha ao conectar via SSH"
    echo ""
    echo "Configure o SSH primeiro:"
    echo "  ssh-copy-id $SERVER_USER@$SERVER_IP"
    exit 1
fi

# Confirmar deploy
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "2. Confirmação de Deploy"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "Servidor: $SERVER_USER@$SERVER_IP"
echo "Destino: $REMOTE_DIR"
echo ""
read -p "Continuar com o deploy? (y/n): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    log_warn "Deploy cancelado pelo usuário"
    exit 0
fi

# Criar diretório remoto
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "3. Criando diretórios no servidor..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

ssh $SERVER_USER@$SERVER_IP "mkdir -p $REMOTE_DIR/logs $REMOTE_DIR/uploads/galeria"
log_info "Diretórios criados"

# Sincronizar arquivos
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "4. Sincronizando arquivos (rsync)..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

rsync -avz --progress \
    --exclude='logs/*' \
    --exclude='uploads/galeria/*' \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='*.md' \
    --exclude='deploy.sh' \
    $LOCAL_DIR/ $SERVER_USER@$SERVER_IP:$REMOTE_DIR/

log_info "Arquivos sincronizados"

# Configurar permissões
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "5. Configurando permissões..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

ssh $SERVER_USER@$SERVER_IP "chmod -R 755 $REMOTE_DIR && chmod -R 777 $REMOTE_DIR/logs $REMOTE_DIR/uploads"
log_info "Permissões configuradas"

# Verificar/Instalar Docker
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "6. Verificando Docker..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if ssh $SERVER_USER@$SERVER_IP "command -v docker" > /dev/null 2>&1; then
    log_info "Docker já instalado"
else
    log_warn "Docker não encontrado. Instalando..."
    ssh $SERVER_USER@$SERVER_IP "curl -fsSL https://get.docker.com | sh && apt install docker-compose -y"
    log_info "Docker instalado"
fi

# Subir containers
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "7. Iniciando containers Docker..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

ssh $SERVER_USER@$SERVER_IP "cd $REMOTE_DIR && docker-compose down && docker-compose up -d"
log_info "Containers iniciados"

# Aguardar containers
echo ""
log_info "Aguardando containers ficarem prontos..."
sleep 5

# Verificar status
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "8. Verificando status dos containers..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

CONTAINERS=$(ssh $SERVER_USER@$SERVER_IP "docker ps --format '{{.Names}}' | grep peticao")

if [ -z "$CONTAINERS" ]; then
    log_error "Nenhum container rodando!"
    exit 1
else
    echo "$CONTAINERS" | while read container; do
        log_info "Container rodando: $container"
    done
fi

# Configurar Nginx (se não existir)
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "9. Configurando Nginx..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if ssh $SERVER_USER@$SERVER_IP "test -f /etc/nginx/sites-available/bolsonarolivre"; then
    log_info "Configuração Nginx já existe"
else
    log_warn "Criando configuração Nginx..."
    
    ssh $SERVER_USER@$SERVER_IP "cat > /etc/nginx/sites-available/bolsonarolivre << 'EOF'
server {
    listen 80;
    server_name bolsonarolivre.publicvm.com www.bolsonarolivre.publicvm.com;
    
    access_log /var/log/nginx/bolsonaro-access.log;
    error_log /var/log/nginx/bolsonaro-error.log;
    
    client_max_body_size 10M;
    
    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host \$host;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_buffering off;
    }
}
EOF"
    
    ssh $SERVER_USER@$SERVER_IP "ln -sf /etc/nginx/sites-available/bolsonarolivre /etc/nginx/sites-enabled/"
    log_info "Configuração Nginx criada"
fi

# Testar e recarregar Nginx
ssh $SERVER_USER@$SERVER_IP "nginx -t && systemctl reload nginx"
log_info "Nginx recarregado"

# Teste final
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "10. Testando deploy..."
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

HTTP_CODE=$(ssh $SERVER_USER@$SERVER_IP "curl -s -o /dev/null -w '%{http_code}' http://localhost:8080")

if [ "$HTTP_CODE" = "200" ]; then
    log_info "Site respondendo corretamente (HTTP $HTTP_CODE)"
else
    log_error "Site retornou HTTP $HTTP_CODE"
fi

# Resumo final
echo ""
echo "╔══════════════════════════════════════════════════════════════════════╗"
echo "║                                                                      ║"
echo "║   ✅ DEPLOY CONCLUÍDO COM SUCESSO!                                  ║"
echo "║                                                                      ║"
echo "╚══════════════════════════════════════════════════════════════════════╝"
echo ""
echo "🌐 URLs:"
echo "   HTTP:  http://bolsonarolivre.publicvm.com"
echo "   IP:    http://$SERVER_IP"
echo ""
echo "📊 Próximos passos:"
echo "   1. Testar o site no navegador"
echo "   2. Configurar SSL/HTTPS:"
echo "      ssh $SERVER_USER@$SERVER_IP"
echo "      certbot --nginx -d bolsonarolivre.publicvm.com"
echo "   3. Monitorar logs:"
echo "      ssh $SERVER_USER@$SERVER_IP 'docker-compose -f $REMOTE_DIR/compose.yml logs -f'"
echo ""
echo "🔧 Comandos úteis:"
echo "   Ver logs:      ssh $SERVER_USER@$SERVER_IP 'tail -f /var/log/nginx/bolsonaro-*.log'"
echo "   Reiniciar:     ssh $SERVER_USER@$SERVER_IP 'cd $REMOTE_DIR && docker-compose restart'"
echo "   Status:        ssh $SERVER_USER@$SERVER_IP 'docker ps'"
echo ""
