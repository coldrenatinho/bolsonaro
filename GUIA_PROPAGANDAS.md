# 📢 Guia Completo de Integração de Propagandas

Este guia mostra como integrar diferentes tipos de anúncios no seu site de petição.

## 🎯 Sistema de Anúncios Implementado

O arquivo `ads.php` centraliza todos os anúncios. Para adicionar ou modificar propagandas, edite apenas esse arquivo.

## 📍 Posições Disponíveis

### 1️⃣ Banner Topo (728x90 - Leaderboard)
- **Posição**: Topo da página
- **Tamanho**: 728x90 pixels
- **Código**: `banner_topo`

### 2️⃣ Banner Sidebar 1 (300x250 - Medium Rectangle)
- **Posição**: Hero section, lado direito
- **Tamanho**: 300x250 pixels
- **Código**: `banner_sidebar_1`

### 3️⃣ Banner Sidebar 2 (300x250 - Medium Rectangle)
- **Posição**: Ao lado do formulário (2 espaços)
- **Tamanho**: 300x250 pixels
- **Código**: `banner_sidebar_2`

### 4️⃣ Banner Sidebar 3 (300x600 - Skyscraper)
- **Posição**: Seção "Sobre"
- **Tamanho**: 300x600 pixels
- **Código**: `banner_sidebar_3`

### 5️⃣ Banner Middle (970x250 - Billboard)
- **Posição**: Entre seções
- **Tamanho**: 970x250 pixels
- **Código**: `banner_middle`

### 6️⃣ Banner Footer (728x90 - Leaderboard)
- **Posição**: Antes do rodapé
- **Tamanho**: 728x90 pixels
- **Código**: `banner_footer`

---

## 🔧 Como Configurar Diferentes Tipos de Anúncios

### Opção 1: Google AdSense (RECOMENDADO) 💰

**Passo 1**: Cadastre-se no [Google AdSense](https://www.google.com/adsense)

**Passo 2**: Crie uma unidade de anúncio e copie o código

**Passo 3**: Edite `ads.php` e configure:

```php
'banner_topo' => [
    'tipo' => 'adsense',
    'adsense_client' => 'ca-pub-1234567890123456', // Seu ID do AdSense
    'adsense_slot' => '9876543210', // Slot do anúncio
    'adsense_format' => 'auto', // Responsivo
],
```

**Vantagens**:
- ✅ Pagamento automático
- ✅ Anúncios relevantes
- ✅ Otimização automática
- ✅ Suporte do Google

---

### Opção 2: Banners Próprios (Venda Direta) 💼

**Passo 1**: Crie ou receba o banner do anunciante

**Passo 2**: Salve a imagem em `uploads/banners/`

**Passo 3**: Configure em `ads.php`:

```php
'banner_topo' => [
    'tipo' => 'banner',
    'codigo' => '<a href="https://siteexemplo.com" target="_blank" rel="noopener">
                    <img src="/uploads/banners/banner-728x90.jpg" 
                         alt="Anúncio" 
                         style="max-width:100%; height:auto;">
                </a>',
],
```

**Vantagens**:
- ✅ Controle total do conteúdo
- ✅ Negociação direta com anunciantes
- ✅ Maior margem de lucro

---

### Opção 3: Redes de Afiliados 🤝

#### 3.1 Amazon Associates

**Código de exemplo**:
```php
'banner_sidebar_1' => [
    'tipo' => 'script',
    'codigo' => '<iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=15&p=12&l=ur1&category=kindle&banner=1234567890&f=ifr&linkID=abcdef" 
                        width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0">
                </iframe>',
],
```

#### 3.2 Hotmart / Monetizze (Produtos Digitais)

**Código de exemplo**:
```php
'banner_middle' => [
    'tipo' => 'script',
    'codigo' => '<script src="https://static.hotmart.com/checkout/widget.min.js"></script>
                <div data-hotmart-product-id="SEU-PRODUTO-ID"></div>',
],
```

#### 3.3 Lomadee / Awin (Várias Lojas)

**Código de exemplo**:
```php
'banner_footer' => [
    'tipo' => 'banner',
    'codigo' => '<a href="https://lomadee.com/tracking-link" target="_blank">
                    <img src="https://lomadee.com/banner.jpg" alt="Banner">
                </a>',
],
```

**Vantagens**:
- ✅ Sem necessidade de vendas diretas
- ✅ Comissão por conversão
- ✅ Variedade de produtos

---

### Opção 4: PropellerAds / Ad.Plus (Alternativas ao AdSense) 🚀

**Passo 1**: Cadastre-se em [PropellerAds](https://propellerads.com) ou similar

**Passo 2**: Copie o código JavaScript fornecido

**Passo 3**: Configure em `ads.php`:

```php
'banner_topo' => [
    'tipo' => 'script',
    'codigo' => '<script type="text/javascript">
                    var propeller_id = 123456;
                    var propeller_site = 789012;
                </script>
                <script src="//nativebanners.com/script.js"></script>',
],
```

**Vantagens**:
- ✅ Aceita tráfego de qualquer país
- ✅ Aprovação mais fácil que AdSense
- ✅ Múltiplos formatos de anúncio

---

### Opção 5: Anúncios Nativos (Taboola / Outbrain) 📰

**Código de exemplo**:
```php
'banner_middle' => [
    'tipo' => 'script',
    'codigo' => '<div id="taboola-widget"></div>
                <script type="text/javascript">
                    window._taboola = window._taboola || [];
                    _taboola.push({
                        mode: "thumbnails-a",
                        container: "taboola-widget",
                        placement: "Placement Name",
                        target_type: "mix"
                    });
                </script>',
],
```

---

## 💡 Exemplos Práticos

### Exemplo 1: Misturando AdSense + Banners Próprios

```php
// Em ads.php
$ads_config = [
    // Google AdSense no topo (melhor posição)
    'banner_topo' => [
        'tipo' => 'adsense',
        'adsense_client' => 'ca-pub-SEU-ID',
        'adsense_slot' => 'SEU-SLOT',
    ],
    
    // Banner próprio vendido para empresa local
    'banner_sidebar_1' => [
        'tipo' => 'banner',
        'codigo' => '<a href="https://empresalocal.com.br">
                        <img src="/uploads/banners/empresa-300x250.jpg">
                    </a>',
    ],
    
    // Produto de afiliado (Hotmart)
    'banner_middle' => [
        'tipo' => 'banner',
        'codigo' => '<a href="https://pay.hotmart.com/SEU-LINK-AFILIADO">
                        <img src="/uploads/banners/produto-970x250.jpg">
                    </a>',
    ],
];
```

### Exemplo 2: Rotação de Banners (PHP Simples)

```php
// Rotacionar entre 3 anunciantes
'banner_topo' => [
    'tipo' => 'banner',
    'codigo' => function() {
        $banners = [
            '<img src="/uploads/banners/anuncio1.jpg">',
            '<img src="/uploads/banners/anuncio2.jpg">',
            '<img src="/uploads/banners/anuncio3.jpg">',
        ];
        return $banners[array_rand($banners)];
    }(),
],
```

---

## 📊 Estratégias de Monetização

### 🥇 Estratégia Iniciante
1. Google AdSense no topo e sidebars
2. Banner próprio no footer (para testes)

**Potencial**: R$ 500-2.000/mês com 10.000 visitantes

### 🥈 Estratégia Intermediária
1. AdSense nas melhores posições (topo, sidebar principal)
2. Banners vendidos diretamente (negociados)
3. Links de afiliados em produtos relacionados

**Potencial**: R$ 2.000-8.000/mês com 30.000 visitantes

### 🥉 Estratégia Avançada
1. Venda direta de banners para políticos/empresas
2. AdSense em posições secundárias
3. Programa de afiliados premium
4. Conteúdo patrocinado

**Potencial**: R$ 10.000+/mês com 50.000+ visitantes

---

## 🛡️ Boas Práticas

### ✅ FAÇA:
- Use anúncios relevantes ao público
- Mantenha o site rápido (não sobrecarregue)
- Teste diferentes posições
- Monitore taxa de cliques (CTR)
- Respeite as políticas do Google AdSense

### ❌ NÃO FAÇA:
- Cliques próprios em anúncios
- Anúncios enganosos
- Poluir demais a página
- Anúncios de conteúdo adulto/ilegal
- Esconder anúncios como conteúdo

---

## 📈 Como Rastrear Resultados

### Google Analytics
Adicione no `<head>` do `index.php`:

```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_TRACKING_ID');
</script>
```

### Rastreamento de Cliques em Banners

```php
// Em ads.php, adicione onclick tracking
'banner_sidebar_1' => [
    'tipo' => 'banner',
    'codigo' => '<a href="https://exemplo.com" 
                    onclick="gtag(\'event\', \'click\', {\'event_category\': \'Banner\', \'event_label\': \'Sidebar 1\'});">
                    <img src="/uploads/banners/banner.jpg">
                </a>',
],
```

---

## 💰 Precificação de Banners (Referência)

### Modelo CPM (Custo por Mil Impressões)
- **Banner Topo**: R$ 10-30 por mil visualizações
- **Sidebar**: R$ 5-15 por mil visualizações
- **Footer**: R$ 3-8 por mil visualizações

### Modelo Fixo Mensal
- **Banner Topo**: R$ 500-2.000/mês
- **Sidebar**: R$ 300-1.000/mês
- **Footer**: R$ 200-500/mês

### Modelo CPC (Custo por Clique)
- **Médio**: R$ 0,50 - R$ 3,00 por clique

---

## 🔄 Atualização Rápida de Banners

Para trocar um banner rapidamente:

1. Abra `ads.php`
2. Localize a posição (ex: `banner_topo`)
3. Substitua o código
4. Salve o arquivo
5. Atualizar no navegador (Ctrl+F5)

**Pronto!** O novo anúncio já está no ar.

---

## ❓ FAQ

**P: Quanto tempo leva para ser aprovado no AdSense?**
R: Geralmente 1-2 semanas. Seu site precisa ter conteúdo original e tráfego.

**P: Posso usar AdSense + outras redes?**
R: Sim! Você pode combinar AdSense com banners próprios e afiliados.

**P: Como receber pagamento do AdSense?**
R: Via transferência bancária quando atingir US$ 100.

**P: Quantos anúncios posso colocar?**
R: Não há limite no AdSense, mas não exagere. Recomendamos 3-5 anúncios por página.

---

## 📞 Próximos Passos

1. ✅ Cadastre-se no Google AdSense
2. ✅ Configure seus primeiros banners em `ads.php`
3. ✅ Instale Google Analytics
4. ✅ Promova seu site para aumentar tráfego
5. ✅ Monitore resultados e otimize

Boa sorte com sua monetização! 💰🚀
