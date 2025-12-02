# 💰 Guia Completo de Monetização - Bolsonaro Livre

## 🎯 Visão Geral

Sistema completo de monetização para **https://bolsonarolivre.publicvm.com/** com:
- ✅ Google AdSense (anúncios contextuais)
- ✅ Rastreamento completo com cookies
- ✅ Google Analytics
- ✅ Facebook Pixel
- ✅ Sistema próprio de tracking
- ✅ LGPD/GDPR compliance

---

## 📋 Configuração Rápida

### 1. Google AdSense

**Cadastro:**
1. Acesse https://www.google.com/adsense
2. Adicione o site: `bolsonarolivre.publicvm.com`
3. Copie seu Publisher ID (formato: `ca-pub-XXXXXXXXXXXXXXXX`)

**Após aprovação (1-7 dias):**
1. Crie 8 unidades de anúncio:
   - 4x Banner 728x90 (Leaderboard)
   - 4x Rectangle 300x250

2. Edite `ads-config.php` com seus IDs:

```php
'adsense' => [
    'client_id' => 'ca-pub-1234567890123456', // ⬅️ SEU ID
    'slots' => [
        'banner_top' => '9876543210',         // ⬅️ Seus slots
        // ...
    ],
],
```

### 2. Google Analytics

1. Crie propriedade em https://analytics.google.com
2. Copie o Measurement ID (formato: `G-XXXXXXXXXX`)
3. Edite `ads-config.php`:

```php
'analytics' => [
    'measurement_id' => 'G-ABC123XYZ', // ⬅️ SEU ID
],
```

### 3. Facebook Pixel

1. Crie pixel em https://business.facebook.com/events_manager
2. Copie o Pixel ID (16 dígitos)
3. Edite `ads-config.php`:

```php
'facebook_pixel' => [
    'pixel_id' => '1234567890123456', // ⬅️ SEU ID
],
```

---

## 📊 Projeção de Receita (AdSense)

| Visitantes/dia | Pageviews | CTR | Receita/mês |
|----------------|-----------|-----|-------------|
| 5.000 | 40.000 | 1.5% | $3.600 |
| 15.000 | 120.000 | 2.5% | $36.000 |
| 50.000 | 400.000 | 3.5% | $252.000 |

**Fórmula:**
```
Pageviews × CTR × CPC médio ($0.20-$0.60) × 30 dias
```

---

## 🛠️ Arquivos do Sistema

```
├── index.php            # 8 espaços para anúncios
├── ad-manager.php       # Rastreamento de visitantes
├── cookie-consent.php   # Banner LGPD
├── ads-config.php       # Configuração de IDs
└── logs/                # Estatísticas locais
    ├── visitors.json
    ├── ad_clicks.json
    └── ad_impressions.json
```

---

## ✅ Checklist

### Hoje:
- [ ] Cadastrar no AdSense
- [ ] Criar Analytics
- [ ] Criar Facebook Pixel
- [ ] Copiar IDs para `ads-config.php`

### Pós-aprovação AdSense:
- [ ] Criar unidades de anúncio
- [ ] Atualizar slots em `ads-config.php`
- [ ] Deploy em produção
- [ ] Verificar anúncios carregando

### Otimização (Semana 1):
- [ ] Analisar CTR por posição
- [ ] Ajustar banners de baixo desempenho
- [ ] Criar mais conteúdo
- [ ] Configurar eventos Analytics

---

## 🚀 Dicas para Maximizar Receita

✅ **Conteúdo:**
- Publique diariamente
- Use palavras-chave de alto CPC: "eleições", "política"
- Títulos chamativos: "URGENTE:", "EXCLUSIVO:"

✅ **Anúncios:**
- Teste diferentes posições (A/B testing)
- Use formatos responsivos
- Mantenha 6-8 anúncios por página

✅ **Tráfego:**
- SEO: títulos otimizados, meta descriptions
- Compartilhamento social
- Newsletter
- Push notifications

✅ **Métricas:**
- CTR ideal: 2-5%
- Tempo na página: > 3 min
- Taxa de rejeição: < 40%

---

## ⚠️ Regras Importantes (AdSense)

❌ **NÃO FAÇA:**
- Clicar nos próprios anúncios
- Pedir cliques
- Tráfego falso/bots
- Conteúdo ilegal

✅ **FAÇA:**
- Conteúdo original
- Tráfego legítimo
- Seguir políticas Google
- HTTPS obrigatório

---

## 📞 Suporte

- **AdSense:** https://support.google.com/adsense
- **Analytics:** https://support.google.com/analytics  
- **Facebook:** https://www.facebook.com/business/help
- **LGPD:** http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm

---

## 🎓 Funcionalidades Já Implementadas

✅ **Banner de consentimento LGPD** (automático)
✅ **Rastreamento de visitantes** (IP, país, device)
✅ **Tracking de cliques em anúncios**
✅ **8 posições estratégicas** de banners
✅ **Logs em JSON** (visitors, clicks, impressions)
✅ **Integração Google/Facebook** (aguarda IDs)

---

**Após configurar os IDs, seu site estará 100% monetizado! 🚀💰**
