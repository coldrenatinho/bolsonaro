# 🚀 Adsterra Configurado com Sucesso!

## ✅ O que foi configurado:

### Anúncios Criados no Adsterra:

1. **Banner Topo** (728x90)
   - Key: `979a9f3418ef96fd72188961f9c4be21`
   - Posição: Acima do hero section

2. **Sidebar 1** (300x250)
   - Key: `5fe3835d572ff7dfd0a84494e19632e4`
   - Posição: Ao lado do hero

3. **Sidebar 2** (160x600)
   - Key: `6f07d81924848fc9726f55f8e33d7274`
   - Posição: Formulário de petição

4. **Banner Meio 1** (468x60)
   - Key: `f7383e4e4aa8793f3102447b8d64b34e`
   - Posição: Após seção "Sobre"

5. **Banner Meio 2** (728x90)
   - Key: `979a9f3418ef96fd72188961f9c4be21`
   - Posição: Antes da galeria

6. **Sidebar 3** (160x300)
   - Key: `884e1eb1f0260fbe5aa1229c6f409791`
   - Posição: Galeria (esquerda)

7. **Sidebar 4** (300x250)
   - Key: `5fe3835d572ff7dfd0a84494e19632e4`
   - Posição: Galeria (direita)

8. **Popunder** 💰 (ALTO CPM!)
   - Script: `//pl28173009.effectivegatecpm.com/56/84/db/5684dbbe76b18d4a5eb0ec1d550a314d.js`
   - Carrega automaticamente após consentimento de cookies

---

## 📁 Arquivos Modificados:

✅ `ads-config.php` - Todas as keys do Adsterra configuradas
✅ `adsterra-helper.php` - Funções para renderizar anúncios
✅ `index.php` - 8 anúncios Adsterra integrados + popunder

---

## 🌐 Como Testar:

### 1. Acessar o site:
```bash
http://localhost:8080
```

### 2. Aceitar cookies:
- Banner LGPD aparecerá automaticamente
- Clique em "Aceitar Todos"
- Os anúncios Adsterra carregarão

### 3. Verificar anúncios:
- Abra o DevTools (F12)
- Veja requisições para `highperformanceformat.com`
- Anúncios devem aparecer em ~10 segundos

---

## 💰 Projeção de Receita (Adsterra)

### CPM Adsterra (médio):
- Banner Display: $1 - $5 CPM
- Popunder: $3 - $10 CPM 💰
- CPM varia por país (Brasil: $1.50 - $3.00)

### Estimativa com 10.000 visitantes/dia:

```
Pageviews: 80.000/dia (8 banners)
CTR: 1.5% (mais baixo que AdSense, mas CPM maior)
Popunder: 10.000 impressões/dia

Banner Revenue: 80.000 × $2 CPM = $160/dia
Popunder Revenue: 10.000 × $5 CPM = $50/dia

Total/dia: $210
Total/mês: $6.300
Total/ano: $75.600
```

---

## 📊 Monitorar Desempenho:

### No Painel Adsterra:
1. Acesse: https://beta.publishers.adsterra.com/
2. Vá em "Statistics"
3. Monitore:
   - Impressions (impressões)
   - Clicks (cliques)
   - Revenue (receita)
   - CPM (ganho por 1000 impressões)
   - Fill Rate (taxa de preenchimento)

### No seu próprio sistema:
```bash
# Ver estatísticas locais
http://localhost:8080/stats.php
```

---

## 🔧 Próximos Passos:

### 1. Deploy em Produção
```bash
# Fazer upload dos arquivos para:
https://bolsonarolivre.publicvm.com/

# Arquivos obrigatórios:
- ads-config.php
- adsterra-helper.php
- index.php (atualizado)
- ad-manager.php
- cookie-consent.php
```

### 2. Configurar HTTPS
Adsterra funciona melhor com HTTPS (maior CPM)

```bash
# Instalar certificado SSL
sudo certbot --nginx -d bolsonarolivre.publicvm.com
```

### 3. Adicionar Mais Formatos (Opcional)

No painel Adsterra, você pode criar:
- **Native Ads** (anúncios nativos dentro do conteúdo)
- **Social Bar** (barra flutuante)
- **Direct Links** (links patrocinados)
- **Push Notifications** (notificações)

---

## ⚠️ Regras Importantes:

### ✅ PODE:
- Usar Adsterra em sites de política
- Combinar banners + popunder
- Usar múltiplos tamanhos
- Tráfego de qualquer país

### ❌ NÃO PODE:
- Clicar nos próprios anúncios
- Forçar cliques
- Tráfego de bots
- Conteúdo adulto/ilegal

---

## 💡 Dicas para Aumentar Receita:

### 1. Otimizar Posições
- Monitore CTR de cada posição
- Remova posições com CTR < 0.5%
- Teste diferentes tamanhos

### 2. Popunder
- É o formato que mais gera receita
- Não abuse (máx 1 por sessão)
- Já está configurado!

### 3. Geo-Targeting
- Tráfego dos EUA/Europa paga mais
- Brasil: $1.50 - $3.00 CPM
- EUA: $5 - $15 CPM

### 4. Aumentar Tráfego
- SEO: otimize títulos
- Redes sociais: compartilhe conteúdo
- Conteúdo viral: notícias polêmicas

---

## 🐛 Troubleshooting:

### Anúncios não aparecem?
1. Aguarde 10-30 minutos após criar spots
2. Limpe cache do navegador
3. Verifique console (F12) por erros
4. Confirme que aceitou cookies

### Receita muito baixa?
1. Verifique Fill Rate no painel Adsterra
2. Se Fill Rate < 50%, adicione mais redes (PropellerAds, Adcash)
3. Teste diferentes tamanhos de banner

### Popunder não funciona?
1. Verifique se aceitou cookies de publicidade
2. Alguns navegadores bloqueiam popunders
3. Teste em modo anônimo

---

## 📞 Suporte:

### Adsterra:
- Painel: https://beta.publishers.adsterra.com/
- Suporte: support@adsterra.com
- Chat: disponível no painel

### Sistema:
- Logs: `/logs/*.json`
- Stats: `http://localhost:8080/stats.php`
- Testes: `./test-monetization.sh`

---

## ✨ Resumo:

✅ **8 anúncios Adsterra** configurados
✅ **Popunder** ativo (maior receita)
✅ **Sistema de tracking** funcionando
✅ **LGPD compliant** (banner de cookies)
✅ **Pronto para deploy** em produção

**💰 Comece a ganhar agora!**

Próximo passo: Deploy em https://bolsonarolivre.publicvm.com/
