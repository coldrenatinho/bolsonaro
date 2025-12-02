# Sistema de Petição Política com Monetização Completa

Sistema completo para criação de petições online com recursos de doação via PIX, galeria de imagens e **sistema avançado de monetização** com rastreamento de visitantes, cookies e integração com plataformas de anúncios.

## 🚀 Características

### Funcionalidades Principais
- ✅ Formulário completo de petição com validação
- 💰 Sistema de doação via PIX com QR Code
- 🖼️ Galeria de imagens com upload
- 📊 Contadores animados de assinaturas
- 📱 Design responsivo com Bootstrap 5
- 💾 Sistema de banco de dados MySQL

### 💎 Sistema de Monetização (NOVO!)
- 🎯 **8 espaços para anúncios Google AdSense**
- 🍪 **Rastreamento completo com cookies** (LGPD compliant)
- 📈 **Google Analytics 4 integrado**
- 📊 **Facebook Pixel para retargeting**
- 📉 **Dashboard de estatísticas** (visitantes, cliques, CTR, receita)
- 🔐 **Banner de consentimento LGPD/GDPR**
- 📝 **Logs detalhados** (JSON) de visitantes e anúncios

## 📁 Estrutura de Arquivos

```
/
├── index.php                  # Página principal (com 8 anúncios)
├── processar_peticao.php      # Processa assinaturas
├── upload.php                 # Upload de imagens
├── config.php                 # Configurações do banco
│
├── ad-manager.php             # Sistema de rastreamento
├── cookie-consent.php         # Banner LGPD
├── ads-config.php             # IDs do AdSense/Analytics/Facebook
├── stats.php                  # Dashboard de estatísticas
│
├── database.sql               # Schema do banco
├── MONETIZACAO.md             # Guia completo de monetização
├── test-monetization.sh       # Script de testes
├── README.md                  # Este arquivo
│
├── logs/                      # Logs de rastreamento
│   ├── visitors.json
│   ├── returning_visitors.json
│   ├── ad_clicks.json
│   └── ad_impressions.json
│
└── uploads/
    └── galeria/               # Imagens enviadas
```

## 💰 Monetização - Guia Rápido

### 1. Cadastrar nas Plataformas

**Google AdSense** (principal fonte de receita)
1. Acesse: https://www.google.com/adsense
2. Cadastre seu site: `bolsonarolivre.publicvm.com`
3. Aguarde aprovação (1-7 dias)

**Google Analytics** (análise de visitantes)
1. Acesse: https://analytics.google.com
2. Crie propriedade GA4
3. Copie o Measurement ID (G-XXXXXXXXXX)

**Facebook Pixel** (retargeting)
1. Acesse: https://business.facebook.com/events_manager
2. Crie um pixel
3. Copie o Pixel ID (16 dígitos)

### 2. Configurar IDs

Edite `ads-config.php`:

```php
'adsense' => [
    'client_id' => 'ca-pub-1234567890123456', // ⬅️ SEU ID AQUI
    'slots' => [
        'banner_top' => '9876543210',         // ⬅️ Criar no AdSense
        'banner_sidebar_1' => '1234567890',
        // ... etc
    ],
],

'analytics' => [
    'measurement_id' => 'G-ABC123XYZ',        // ⬅️ SEU ID AQUI
],

'facebook_pixel' => [
    'pixel_id' => '1234567890123456',         // ⬅️ SEU ID AQUI
],
```

### 3. Verificar Funcionamento

```bash
# Executar testes
./test-monetization.sh

# Acessar estatísticas
http://localhost:8080/stats.php
```

### 📊 Projeção de Receita

| Visitantes/dia | CTR | Receita/mês (estimada) |
|----------------|-----|------------------------|
| 5.000 | 1.5% | $3.600 |
| 15.000 | 2.5% | $36.000 |
| 50.000 | 3.5% | $252.000 |

**Leia o guia completo**: [`MONETIZACAO.md`](MONETIZACAO.md)

## 🛠️ Instalação Rápida (Docker)

```bash
# 1. Clonar/baixar projeto
cd /home/renatoas/www/bolsonaro

# 2. Subir containers
docker-compose up -d

# 3. Acessar
http://localhost:8080
http://localhost:8080/stats.php       # Estatísticas
http://localhost:8080/phpmyadmin       # Banco de dados
```

### Credenciais Padrão
- **MySQL**: user / userpassword
- **phpMyAdmin**: user / userpassword

## 📊 Dashboard de Estatísticas

Acesse `stats.php` para visualizar:

- 📈 **Total de visitantes** (únicos e recorrentes)
- 💰 **Impressões e cliques** em anúncios
- 🎯 **CTR por posição** de banner
- 🌍 **Países de origem** dos visitantes
- ⏰ **Horários de pico** de visitas
- 📅 **Gráfico dos últimos 7 dias**
- 💵 **Projeção de receita** (AdSense)

## 🍪 Sistema LGPD/GDPR

O banner de consentimento (`cookie-consent.php`) é:
- ✅ **Automático**: aparece na primeira visita
- ✅ **Personalizável**: 3 níveis de consentimento
- ✅ **Compliant**: segue LGPD e GDPR
- ✅ **Inteligente**: só carrega scripts após aceite

### Cookies Rastreados
1. **Essenciais** (obrigatórios): funcionamento do site
2. **Analytics** (opcional): Google Analytics
3. **Publicidade** (opcional): AdSense + Facebook Pixel

## 🎯 Espaços para Anúncios

O site possui **8 posições estratégicas**:

| Posição | Tamanho | Formato | Local |
|---------|---------|---------|-------|
| Banner Topo | 728x90 | Leaderboard | Acima do hero |
| Sidebar 1 | 300x250 | Rectangle | Ao lado do hero |
| Sidebar 2 | 300x600 | Skyscraper | Formulário |
| Banner Meio 1 | 728x90 | Leaderboard | Após estatísticas |
| Banner Meio 2 | 970x250 | Billboard | Antes da galeria |
| Sidebar 3 | 300x250 | Rectangle | Galeria |
| Sidebar 4 | 300x250 | Rectangle | Galeria |
| Banner Rodapé | 728x90 | Leaderboard | Antes do footer |

Todos já integrados com Google AdSense!

## 📈 Rastreamento Avançado

O `ad-manager.php` coleta automaticamente:

```php
✅ Visitante único (cookie 30 dias)
✅ IP do visitante
✅ User-Agent (dispositivo/navegador)
✅ País/região (API geolocalização)
✅ Página de referência
✅ Impressões de anúncios
✅ Cliques em anúncios
✅ Timestamps de todas ações
```

Dados salvos em `logs/*.json` (formato JSON)

## 🔧 Configuração do Banco de Dados

```bash
# Via Docker (automático)
docker-compose up -d

# Manual
mysql -u root -p < database.sql
```

Edite `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'peticao_db');
define('DB_USER', 'user');
define('DB_PASS', 'userpassword');
```

## 🚀 Deploy em Produção

### Para `bolsonarolivre.publicvm.com`:

1. **Configurar HTTPS** (obrigatório para AdSense)
```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d bolsonarolivre.publicvm.com
```

2. **Atualizar ads-config.php** com IDs reais

3. **Ajustar nginx.conf** para produção

4. **Testar**
```bash
./test-monetization.sh
```

## 📱 Responsividade

Testado em:
- ✅ Desktop (1920px+)
- ✅ Tablet (768px - 1024px)  
- ✅ Mobile (320px - 767px)

Anúncios adaptam automaticamente (`data-full-width-responsive="true"`)

## 🐛 Troubleshooting

### Anúncios não aparecem
- ✅ Verificar IDs em `ads-config.php`
- ✅ AdSense leva 10-30min após aprovação
- ✅ Aceitar cookies no banner

### Logs vazios
```bash
# Verificar permissões
chmod 777 logs
ls -la logs/
```

### Estatísticas zeradas
- Aguardar primeiras visitas
- Verificar se `ad-manager.php` está incluído no `index.php`

## 🎓 Recursos de Aprendizado

- 📚 [MONETIZACAO.md](MONETIZACAO.md) - Guia completo
- 📚 [AdSense Help](https://support.google.com/adsense)
- 📚 [Analytics Academy](https://analytics.google.com/analytics/academy/)
- 📚 [LGPD - Lei 13.709/2018](http://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm)

## ⚙️ Testes Automatizados

```bash
# Executar suite de testes
./test-monetization.sh
```

Verifica:
- ✅ Arquivos instalados
- ✅ Sintaxe PHP
- ✅ Containers Docker
- ✅ Conectividade APIs
- ✅ Configuração de IDs

## 📊 Métricas de Sucesso

| Métrica | Meta | Como Medir |
|---------|------|-----------|
| **CTR** | 2-5% | stats.php |
| **Tempo na página** | > 3min | Google Analytics |
| **Taxa de rejeição** | < 40% | Google Analytics |
| **RPM** | > $5 | AdSense Dashboard |

## 🔐 Segurança

- ✅ HTTPS obrigatório em produção
- ✅ Cookies com flags Secure/SameSite
- ✅ Sanitização de dados (PDO)
- ✅ Validação CPF
- ✅ Proteção contra SQL Injection
- ✅ Rate limiting recomendado

## 📄 Licença

Este projeto é fornecido como está, sem garantias.

## 🤝 Próximos Passos

1. ✅ **Sistema instalado** - você está aqui!
2. ⏳ Cadastrar no AdSense/Analytics/Facebook
3. ⏳ Configurar IDs em `ads-config.php`
4. ⏳ Deploy em `bolsonarolivre.publicvm.com`
5. ⏳ Monitorar receita no AdSense
6. ⏳ Otimizar baseado em stats.php

---

**💰 Comece a monetizar agora!**  
Leia: [`MONETIZACAO.md`](MONETIZACAO.md) para instruções detalhadas.

Desenvolvido com ❤️ para promover participação democrática **e gerar receita sustentável**.


## 💻 Uso

### Personalizando o Conteúdo

1. **Editar texto da petição**: Abra `index.php` e modifique a seção "Sobre Nossa Causa"

2. **Alterar chave PIX**: Edite `config.php`:
```php
define('PIX_KEY', 'sua-chave@email.com');
```

3. **Adicionar banners**: Substitua os placeholders nas divs `.banner-top`, `.banner-sidebar`, etc.

### Inserindo Banners Reais

Exemplo de substituição de banner:
```html
<!-- Substituir isto: -->
<div class="banner-top">
    <h3>ESPAÇO PUBLICITÁRIO</h3>
</div>

<!-- Por isto: -->
<div class="banner-top">
    <img src="seu-banner-728x90.jpg" alt="Banner">
</div>
```

### Tamanhos de Banners Disponíveis

- **Topo**: 728x90 (Leaderboard)
- **Sidebar**: 300x250 (Medium Rectangle) ou 300x600 (Skyscraper)
- **Meio**: 970x250 (Billboard) ou 728x90 (Leaderboard)

## 🔧 Configurações Avançadas

### Email de Confirmação

Para ativar emails automáticos, descomente em `processar_peticao.php`:

```php
mail($email, $assunto, $corpo, $headers);
```

Configure SMTP em `config.php` se necessário.

### Moderação de Imagens

Por padrão, imagens ficam pendentes de aprovação. Adicione um painel admin para aprovar:

```sql
UPDATE galeria SET aprovado = 1 WHERE id = ?;
```

## 📊 Relatórios

### Consultar Assinaturas

```sql
-- Total de assinaturas
SELECT COUNT(*) as total FROM assinaturas;

-- Assinaturas por estado
SELECT estado, COUNT(*) as total 
FROM assinaturas 
GROUP BY estado 
ORDER BY total DESC;

-- Assinaturas por dia
SELECT DATE(data_assinatura) as data, COUNT(*) as total 
FROM assinaturas 
GROUP BY DATE(data_assinatura);
```

## 🔒 Segurança

- ✅ Validação de CPF
- ✅ Proteção contra SQL Injection (PDO prepared statements)
- ✅ Sanitização de dados
- ✅ Validação de tipos de arquivo
- ✅ Limite de tamanho de upload
- ✅ Proteção contra duplicatas (CPF único)
- ✅ Registro de IP

### Recomendações Adicionais

1. Use HTTPS em produção
2. Implemente CAPTCHA (reCAPTCHA)
3. Configure rate limiting
4. Faça backups regulares do banco
5. Monitore logs de erro

## 🎨 Personalização Visual

### Cores Principais

Edite as variáveis CSS em `index.php`:

```css
:root {
    --primary-color: #0d6efd;
    --secondary-color: #6c757d;
}
```

### Gradientes

- Hero: `#667eea` → `#764ba2`
- PIX: `#11998e` → `#38ef7d`

## 📱 Responsividade

O site é totalmente responsivo e testado em:
- Desktop (1920px+)
- Tablet (768px - 1024px)
- Mobile (320px - 767px)

## 🐛 Troubleshooting

### Erro: "Erro ao conectar ao banco de dados"
- Verifique credenciais em `config.php`
- Confirme que o MySQL está rodando
- Verifique se o banco `peticao_db` existe

### Upload não funciona
```bash
# Verificar permissões
ls -la uploads/
chmod 755 uploads/galeria
```

### QR Code não aparece
- Verifique conexão com internet (usa API externa)
- Confirme que a chave PIX está correta em `config.php`

## 📈 Monetização

### Espaços Publicitários

O template inclui múltiplos espaços para banners:
- 1x Topo (728x90)
- 4x Sidebar (300x250)
- 2x Billboard (970x250)

### Integração Google AdSense

```html
<div class="banner-top">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-XXXXXXXX"
         data-ad-slot="XXXXXXXXX"
         data-ad-format="auto"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
```

## 📄 Licença

Este projeto é fornecido como está, sem garantias. Use por sua conta e risco.

## 🤝 Suporte

Para questões e suporte:
- Verifique a documentação
- Consulte os comentários no código
- Revise os logs de erro do PHP

## 📝 TODO

- [ ] Painel administrativo
- [ ] Sistema de comentários
- [ ] Integração com redes sociais
- [ ] Exportação de dados (CSV/PDF)
- [ ] Sistema de compartilhamento
- [ ] Multi-idioma
- [ ] API REST

---

Desenvolvido com ❤️ para promover a participação democrática.
