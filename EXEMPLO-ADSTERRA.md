# 📝 Exemplo de Integração Adsterra no index.php

## Passo 1: Adicionar includes no topo

```php
<?php
// Sistema de rastreamento e anúncios
require_once 'ad-manager.php';
require_once 'adsterra-helper.php';

// Rastrear visitante automaticamente
global $adManager;
?>
```

## Passo 2: Adicionar meta tag de verificação no <head>

```php
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Verificação Adsterra - SUBSTITUIR COM SEU CÓDIGO -->
    <meta name="adsterra-site-verification" content="SEU_CODIGO_AQUI" />
    
    <title>Petição Política - Faça sua voz ser ouvida</title>
    ...
</head>
```

## Passo 3: Substituir banners placeholder por Adsterra

### Banner Topo (antes do hero)

**ANTES:**
```php
<div class="banner-top">
    <ins class="adsbygoogle"...></ins>
</div>
```

**DEPOIS:**
```php
<!-- Banner Topo - Adsterra -->
<div class="banner-top">
    <?php renderAdsterraAd('banner_top'); ?>
</div>
```

### Banner Sidebar 1 (ao lado do hero)

**ANTES:**
```php
<div class="banner-sidebar bg-white">
    <ins class="adsbygoogle"...></ins>
</div>
```

**DEPOIS:**
```php
<!-- Banner Lateral 1 - Adsterra -->
<div class="banner-sidebar bg-white">
    <?php renderAdsterraAd('banner_sidebar_1'); ?>
</div>
```

### Banner Sidebar 2 (formulário)

**ANTES:**
```php
<div class="banner-sidebar">
    <ins class="adsbygoogle"...></ins>
</div>
```

**DEPOIS:**
```php
<!-- Banner Lateral 2 - Adsterra -->
<div class="banner-sidebar">
    <?php renderAdsterraAd('banner_sidebar_2'); ?>
</div>
```

### Banner Meio 1 (após estatísticas)

**ANTES:**
```php
<div class="banner-middle">
    <ins class="adsbygoogle"...></ins>
</div>
```

**DEPOIS:**
```php
<!-- Banner Meio 1 - Adsterra -->
<div class="banner-middle">
    <?php renderAdsterraAd('banner_middle_1'); ?>
</div>
```

### Banners Footer (galeria)

**ANTES:**
```php
<div class="banner-sidebar">
    <ins class="adsbygoogle"...></ins>
</div>
```

**DEPOIS:**
```php
<!-- Banner Footer 1 - Adsterra -->
<div class="banner-sidebar">
    <?php renderAdsterraAd('banner_footer_1'); ?>
</div>

<!-- Banner Footer 2 - Adsterra -->
<div class="banner-sidebar">
    <?php renderAdsterraAd('banner_footer_2'); ?>
</div>
```

## Passo 4: Adicionar Popunder (uma vez, no final do body)

**Adicionar ANTES do fechamento </body>:**

```php
    <?php
    // Incluir banner de consentimento de cookies (LGPD)
    include_once 'cookie-consent.php';
    
    // Popunder - Adsterra (ALTO CPM!)
    renderAdsterraPopunder();
    
    // Social Bar - Adsterra (OPCIONAL)
    // renderAdsterraSocialBar();
    ?>
</body>
</html>
```

## Layout Final Recomendado

```
┌────────────────────────────────────────┐
│   Banner Topo 728x90                   │ ← renderAdsterraAd('banner_top')
└────────────────────────────────────────┘

┌──────────────────────┬─────────────────┐
│                      │                 │
│   Hero Section       │  Sidebar 300x250│ ← renderAdsterraAd('banner_sidebar_1')
│                      │                 │
└──────────────────────┴─────────────────┘

┌────────────────────────────────────────┐
│   Estatísticas                         │
└────────────────────────────────────────┘

┌──────────────────────┬─────────────────┐
│                      │                 │
│   Formulário         │  Sidebar 300x250│ ← renderAdsterraAd('banner_sidebar_2')
│                      │                 │
└──────────────────────┴─────────────────┘

┌────────────────────────────────────────┐
│   Banner Meio 1 - 728x90               │ ← renderAdsterraAd('banner_middle_1')
└────────────────────────────────────────┘

┌────────────────────────────────────────┐
│   Galeria de Imagens                   │
└────────────────────────────────────────┘

┌──────────────────────┬─────────────────┐
│   Footer 1 300x250   │  Footer 2       │ ← renderAdsterraAd('banner_footer_1/2')
└──────────────────────┴─────────────────┘

[Popunder - abre ao clicar em qualquer lugar] ← renderAdsterraPopunder()
```

## Código Completo de Exemplo

```php
<?php
require_once 'ad-manager.php';
require_once 'adsterra-helper.php';
global $adManager;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Verificação Adsterra -->
    <meta name="adsterra-site-verification" content="SEU_CODIGO_AQUI" />
    
    <title>Petição Política</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ... resto do head ... -->
</head>
<body>
    
    <!-- Banner Topo -->
    <div class="banner-top">
        <?php renderAdsterraAd('banner_top'); ?>
    </div>
    
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Faça sua voz ser ouvida!</h1>
                    <!-- conteúdo -->
                </div>
                <div class="col-lg-4">
                    <div class="banner-sidebar bg-white">
                        <?php renderAdsterraAd('banner_sidebar_1'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Formulário -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- formulário -->
            </div>
            <div class="col-lg-4">
                <div class="banner-sidebar">
                    <?php renderAdsterraAd('banner_sidebar_2'); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Banner Meio -->
    <div class="banner-middle">
        <?php renderAdsterraAd('banner_middle_1'); ?>
    </div>
    
    <!-- Galeria -->
    <div class="container">
        <!-- galeria content -->
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="banner-sidebar">
                    <?php renderAdsterraAd('banner_footer_1'); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="banner-sidebar">
                    <?php renderAdsterraAd('banner_footer_2'); ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    // Banner de consentimento LGPD
    include_once 'cookie-consent.php';
    
    // Popunder Adsterra (ALTO CPM!)
    renderAdsterraPopunder();
    ?>
    
</body>
</html>
```

## Checklist de Implementação

- [ ] Adicionar `require_once 'adsterra-helper.php';` no topo do index.php
- [ ] Adicionar meta tag de verificação no <head>
- [ ] Substituir banner_top por `renderAdsterraAd('banner_top')`
- [ ] Substituir banner_sidebar_1 por `renderAdsterraAd('banner_sidebar_1')`
- [ ] Substituir banner_sidebar_2 por `renderAdsterraAd('banner_sidebar_2')`
- [ ] Substituir banner_middle_1 por `renderAdsterraAd('banner_middle_1')`
- [ ] Substituir banner_footer_1 e footer_2
- [ ] Adicionar `renderAdsterraPopunder()` antes de </body>
- [ ] Testar se anúncios aparecem (após aprovação)
- [ ] Configurar keys no ads-config.php

---

**Assim que você tiver os códigos do Adsterra, me envie e eu farei todas as alterações automaticamente! 🚀**
