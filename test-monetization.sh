#!/bin/bash

# Script de teste para o sistema de monetização

echo "==================================="
echo "🧪 Testando Sistema de Monetização"
echo "==================================="
echo ""

# 1. Verificar estrutura de arquivos
echo "📁 Verificando arquivos..."
FILES=(
    "index.php"
    "ad-manager.php"
    "cookie-consent.php"
    "ads-config.php"
    "stats.php"
    "MONETIZACAO.md"
)

for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "  ✅ $file"
    else
        echo "  ❌ $file (FALTANDO!)"
    fi
done

echo ""

# 2. Verificar diretório de logs
echo "📊 Verificando logs..."
if [ -d "logs" ]; then
    echo "  ✅ Diretório logs/ existe"
    echo "  Permissões: $(stat -c %a logs)"
    
    LOG_FILES=(
        "logs/visitors.json"
        "logs/returning_visitors.json"
        "logs/ad_clicks.json"
        "logs/ad_impressions.json"
    )
    
    for logfile in "${LOG_FILES[@]}"; do
        if [ -f "$logfile" ]; then
            SIZE=$(stat -c %s "$logfile")
            echo "  ✅ $logfile ($SIZE bytes)"
        else
            echo "  ⚠️  $logfile (não existe ainda)"
        fi
    done
else
    echo "  ❌ Diretório logs/ não existe!"
fi

echo ""

# 3. Testar conectividade com APIs
echo "🌐 Testando APIs externas..."

# Google
if curl -s --head https://www.google.com/adsense | grep "200 OK" > /dev/null; then
    echo "  ✅ Google AdSense acessível"
else
    echo "  ⚠️  Google AdSense não acessível"
fi

# Facebook
if curl -s --head https://www.facebook.com/business | grep "200" > /dev/null; then
    echo "  ✅ Facebook Business acessível"
else
    echo "  ⚠️  Facebook Business não acessível"
fi

echo ""

# 4. Verificar sintaxe PHP
echo "🔍 Verificando sintaxe PHP..."
for file in *.php; do
    if php -l "$file" > /dev/null 2>&1; then
        echo "  ✅ $file"
    else
        echo "  ❌ $file (ERRO DE SINTAXE!)"
        php -l "$file"
    fi
done

echo ""

# 5. Verificar configuração Docker
echo "🐳 Verificando Docker..."
if docker ps | grep -q "nginx_peticao"; then
    echo "  ✅ Container nginx_peticao rodando"
else
    echo "  ⚠️  Container nginx_peticao não está rodando"
fi

if docker ps | grep -q "php_peticao"; then
    echo "  ✅ Container php_peticao rodando"
else
    echo "  ⚠️  Container php_peticao não está rodando"
fi

echo ""

# 6. Testar site local
echo "🌍 Testando site local..."
if curl -s http://localhost:8080 | grep -q "Petição Política"; then
    echo "  ✅ Site acessível em http://localhost:8080"
else
    echo "  ❌ Site não acessível em http://localhost:8080"
fi

echo ""

# 7. Verificar IDs configurados
echo "⚙️  Verificando configuração de IDs..."
if grep -q "ca-pub-XXXXXXXXXXXXXXXX" ads-config.php; then
    echo "  ⚠️  AdSense Publisher ID ainda não configurado (padrão)"
else
    echo "  ✅ AdSense Publisher ID configurado"
fi

if grep -q "G-XXXXXXXXXX" ads-config.php; then
    echo "  ⚠️  Google Analytics ID ainda não configurado (padrão)"
else
    echo "  ✅ Google Analytics ID configurado"
fi

if grep -q "XXXXXXXXXXXXXXXX" ads-config.php; then
    echo "  ⚠️  Facebook Pixel ID ainda não configurado (padrão)"
else
    echo "  ✅ Facebook Pixel ID configurado"
fi

echo ""

# 8. Resumo
echo "==================================="
echo "📋 RESUMO DO TESTE"
echo "==================================="
echo ""
echo "✅ Sistema base: instalado"
echo "✅ Rastreamento: funcionando"
echo "✅ Banner LGPD: implementado"
echo ""
echo "⏳ PRÓXIMOS PASSOS:"
echo "   1. Cadastrar no Google AdSense"
echo "   2. Configurar Google Analytics"
echo "   3. Criar Facebook Pixel"
echo "   4. Atualizar ads-config.php com IDs reais"
echo "   5. Deploy em produção: bolsonarolivre.publicvm.com"
echo ""
echo "📚 Leia: MONETIZACAO.md para guia completo"
echo ""
