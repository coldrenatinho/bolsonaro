# 🚀 Guia Completo de Deploy - bolsonarolivre.publicvm.com

## 📋 Informações do Servidor

- **IP**: 177.155.222.159
- **Domínio**: bolsonarolivre.publicvm.com
- **Servidor Web**: Nginx (já instalado)
- **Estratégia**: Proxy Reverso → Docker Containers

---

## 🎯 Arquitetura de Deploy

```
Internet
    ↓
bolsonarolivre.publicvm.com (177.155.222.159)
    ↓
Nginx (Servidor - Porta 80/443) ← SSL/HTTPS
    ↓
Proxy Reverso → localhost:8080
    ↓
Docker Nginx (Container) ← HTTP
    ↓
PHP-FPM (Container)
    ↓
MySQL (Container)
```

---

## 📝 PASSO 1: Preparar Arquivos no Servidor

### 1.1 Fazer Upload dos Arquivos

```bash
# No seu computador local
cd /home/renatoas/www/bolsonaro

# Comprimir projeto (excluir node_modules, logs, etc)
tar -czf bolsonaro-deploy.tar.gz \
    --exclude='logs/*' \
    --exclude='uploads/galeria/*' \
    --exclude='.git' \
    *.php *.sql *.yml *.conf Dockerfile .dockerignore

# Upload via SCP
scp bolsonaro-deploy.tar.gz root@177.155.222.159:/var/www/

# OU usar rsync (mais eficiente)
rsync -avz --progress \
    --exclude='logs/*' \
    --exclude='uploads/galeria/*' \
    --exclude='.git' \
    ./ root@177.155.222.159:/var/www/bolsonaro/
```

### 1.2 No Servidor - Extrair e Configurar

```bash
# SSH no servidor
ssh root@177.155.222.159

# Criar diretório
mkdir -p /var/www/bolsonaro
cd /var/www/bolsonaro

# Se usou tar.gz
tar -xzf ../bolsonaro-deploy.tar.gz

# Criar diretórios necessários
mkdir -p logs uploads/galeria
chmod 777 logs uploads/galeria

# Verificar arquivos
ls -la
```

---

## 🐳 PASSO 2: Configurar Docker no Servidor

### 2.1 Instalar Docker (se não estiver instalado)

```bash
# Atualizar sistema
apt update && apt upgrade -y

# Instalar Docker
curl -fsSL https://get.docker.com | sh

# Instalar Docker Compose
apt install docker-compose -y

# Verificar instalação
docker --version
docker-compose --version
```

### 2.2 Subir Containers

```bash
cd /var/www/bolsonaro

# Subir containers
docker-compose up -d

# Verificar status
docker ps

# Deve mostrar:
# - php_peticao
# - nginx_peticao (porta 8080:80)
# - mysql_peticao
# - phpmyadmin_login_php

# Testar localmente
curl http://localhost:8080
```

---

## 🌐 PASSO 3: Configurar Nginx como Proxy Reverso

### 3.1 Criar Configuração do Site

```bash
# Criar arquivo de configuração
nano /etc/nginx/sites-available/bolsonarolivre
```

Cole o seguinte conteúdo:

```nginx
server {
    listen 80;
    server_name bolsonarolivre.publicvm.com www.bolsonarolivre.publicvm.com;
    
    # Logs
    access_log /var/log/nginx/bolsonaro-access.log;
    error_log /var/log/nginx/bolsonaro-error.log;
    
    # Tamanho máximo de upload
    client_max_body_size 10M;
    
    # Proxy para container Docker
    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_buffering off;
        
        # Timeouts
        proxy_connect_timeout 60s;
        proxy_send_timeout 60s;
        proxy_read_timeout 60s;
    }
    
    # WebSocket support (se necessário no futuro)
    location /ws {
        proxy_pass http://localhost:8080;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }
}
```

### 3.2 Ativar Site

```bash
# Criar link simbólico
ln -s /etc/nginx/sites-available/bolsonarolivre /etc/nginx/sites-enabled/

# Remover default (opcional)
rm /etc/nginx/sites-enabled/default

# Testar configuração
nginx -t

# Se OK, recarregar Nginx
systemctl reload nginx

# Verificar status
systemctl status nginx
```

### 3.3 Testar

```bash
# Do servidor
curl http://bolsonarolivre.publicvm.com

# Do seu computador
curl http://177.155.222.159
```

---

## 🔒 PASSO 4: Configurar HTTPS (SSL/TLS)

### 4.1 Instalar Certbot

```bash
# Instalar Certbot
apt install certbot python3-certbot-nginx -y
```

### 4.2 Obter Certificado SSL

```bash
# Obter certificado (automático)
certbot --nginx -d bolsonarolivre.publicvm.com -d www.bolsonarolivre.publicvm.com

# Durante o processo:
# 1. Digite seu email
# 2. Aceite os termos
# 3. Escolha se quer compartilhar email (opcional)
# 4. Escolha opção 2: Redirect HTTP to HTTPS

# Certificado será renovado automaticamente!
```

### 4.3 Verificar Configuração HTTPS

O Certbot modificará automaticamente `/etc/nginx/sites-available/bolsonarolivre`:

```nginx
server {
    listen 80;
    server_name bolsonarolivre.publicvm.com www.bolsonarolivre.publicvm.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name bolsonarolivre.publicvm.com www.bolsonarolivre.publicvm.com;
    
    # Certificados SSL
    ssl_certificate /etc/letsencrypt/live/bolsonarolivre.publicvm.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/bolsonarolivre.publicvm.com/privkey.pem;
    
    # Configurações SSL otimizadas
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;
    
    # HSTS
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    
    # Logs
    access_log /var/log/nginx/bolsonaro-ssl-access.log;
    error_log /var/log/nginx/bolsonaro-ssl-error.log;
    
    # Tamanho máximo de upload
    client_max_body_size 10M;
    
    # Proxy para container Docker
    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto https;
        proxy_buffering off;
    }
}
```

### 4.4 Testar HTTPS

```bash
# Recarregar Nginx
systemctl reload nginx

# Testar
curl https://bolsonarolivre.publicvm.com
```

---

## 🔥 PASSO 5: Configurar Firewall

```bash
# Instalar UFW (se não estiver instalado)
apt install ufw -y

# Permitir SSH (IMPORTANTE!)
ufw allow 22/tcp

# Permitir HTTP e HTTPS
ufw allow 80/tcp
ufw allow 443/tcp

# Permitir MySQL (opcional, apenas se necessário externamente)
# ufw allow 3306/tcp

# Ativar firewall
ufw enable

# Verificar status
ufw status
```

---

## 📊 PASSO 6: Monitoramento e Logs

### 6.1 Ver Logs em Tempo Real

```bash
# Logs Nginx
tail -f /var/log/nginx/bolsonaro-access.log
tail -f /var/log/nginx/bolsonaro-error.log

# Logs Docker
docker logs -f nginx_peticao
docker logs -f php_peticao
docker logs -f mysql_peticao

# Logs combinados
docker-compose logs -f
```

### 6.2 Monitorar Performance

```bash
# Status dos containers
docker stats

# Uso de disco
df -h

# Memória
free -h

# Processos
htop
```

---

## 🔄 PASSO 7: Automatizar Backups

### 7.1 Criar Script de Backup

```bash
nano /root/backup-bolsonaro.sh
```

Cole:

```bash
#!/bin/bash

# Configurações
BACKUP_DIR="/root/backups/bolsonaro"
DATE=$(date +%Y%m%d_%H%M%S)
MYSQL_CONTAINER="mysql_peticao"

# Criar diretório
mkdir -p $BACKUP_DIR

# Backup do banco de dados
docker exec $MYSQL_CONTAINER mysqldump \
    -u user -puserpassword peticao_db \
    > $BACKUP_DIR/database_$DATE.sql

# Backup dos arquivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz \
    /var/www/bolsonaro/uploads \
    /var/www/bolsonaro/logs

# Manter apenas últimos 7 backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup concluído: $DATE"
```

```bash
# Dar permissão
chmod +x /root/backup-bolsonaro.sh

# Testar
/root/backup-bolsonaro.sh
```

### 7.2 Agendar Backup Diário

```bash
# Editar crontab
crontab -e

# Adicionar linha (backup diário às 3h da manhã)
0 3 * * * /root/backup-bolsonaro.sh >> /var/log/backup-bolsonaro.log 2>&1
```

---

## 🚀 PASSO 8: Otimizações de Performance

### 8.1 Configurar Cache no Nginx

Editar `/etc/nginx/sites-available/bolsonarolivre`:

```nginx
# Adicionar dentro do bloco server {}

# Cache de arquivos estáticos
location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|webp|woff|woff2)$ {
    proxy_pass http://localhost:8080;
    proxy_set_header Host $host;
    expires 30d;
    add_header Cache-Control "public, immutable";
}

# Gzip compression
gzip on;
gzip_vary on;
gzip_min_length 1024;
gzip_types text/plain text/css text/xml text/javascript application/json application/javascript application/xml+rss;
```

### 8.2 Otimizar PHP (opcional)

Editar `Dockerfile` e reconstruir:

```dockerfile
FROM php:8.2-fpm

# Instalar extensões
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Otimizações PHP
RUN echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "max_execution_time = 60" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize = 10M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html
```

Reconstruir:
```bash
cd /var/www/bolsonaro
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

---

## ✅ CHECKLIST FINAL

### Pré-Deploy
- [ ] Arquivos copiados para servidor
- [ ] Docker e Docker Compose instalados
- [ ] Containers rodando (docker ps)

### Nginx
- [ ] Configuração criada em `/etc/nginx/sites-available/`
- [ ] Link simbólico criado em `/etc/nginx/sites-enabled/`
- [ ] `nginx -t` sem erros
- [ ] Nginx recarregado

### SSL/HTTPS
- [ ] Certbot instalado
- [ ] Certificado SSL obtido
- [ ] HTTPS funcionando
- [ ] HTTP redireciona para HTTPS

### Segurança
- [ ] Firewall configurado (UFW)
- [ ] Portas corretas abertas (22, 80, 443)
- [ ] Senha forte no MySQL
- [ ] Arquivos sensíveis protegidos

### Funcionalidades
- [ ] Site acessível: https://bolsonarolivre.publicvm.com
- [ ] Formulário de petição funcionando
- [ ] Upload de imagens funcionando
- [ ] Anúncios Adsterra carregando
- [ ] Banner LGPD aparecendo

### Monitoramento
- [ ] Backup automático configurado
- [ ] Logs acessíveis
- [ ] Dashboard Adsterra monitorado

---

## 🆘 Resolução de Problemas

### Problema: Site não acessível

```bash
# Verificar DNS
nslookup bolsonarolivre.publicvm.com

# Verificar Nginx
systemctl status nginx
nginx -t

# Verificar containers
docker ps
curl http://localhost:8080

# Ver logs
tail -f /var/log/nginx/bolsonaro-error.log
```

### Problema: Erro 502 Bad Gateway

```bash
# Container Docker não está rodando
docker-compose up -d

# Verificar porta 8080
netstat -tlnp | grep 8080

# Reiniciar containers
docker-compose restart
```

### Problema: Certificado SSL não funciona

```bash
# Verificar certificado
certbot certificates

# Renovar manualmente
certbot renew --dry-run

# Verificar configuração Nginx
nginx -t
systemctl reload nginx
```

---

## 📞 Comandos Úteis

```bash
# Reiniciar tudo
docker-compose restart && systemctl reload nginx

# Ver uso de recursos
docker stats

# Limpar logs antigos
truncate -s 0 /var/log/nginx/*.log
docker-compose logs --tail=100

# Atualizar código
cd /var/www/bolsonaro
git pull  # se usar git
docker-compose restart

# Backup manual
/root/backup-bolsonaro.sh
```

---

## 🎯 Resumo da Arquitetura Final

```
Internet (HTTPS) 
    ↓
Nginx Servidor (177.155.222.159:443) 
    ↓ SSL Termination
Proxy Reverso (HTTP)
    ↓
Docker Nginx (localhost:8080)
    ↓
PHP-FPM (Container)
    ↓
MySQL (Container)
```

**Vantagens:**
- ✅ HTTPS gerenciado pelo Nginx principal
- ✅ Containers isolados e fáceis de atualizar
- ✅ Backup simples (apenas /var/www/bolsonaro)
- ✅ Escalabilidade futura (load balancer)
- ✅ Logs centralizados

---

**🚀 Pronto para deploy!**
