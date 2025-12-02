# 🚀 Guia de Configuração - Adsterra

## 📋 Passo a Passo Completo

### 1. Cadastro no Adsterra

✅ **Você já tem acesso:** https://beta.publishers.adsterra.com/websites

### 2. Adicionar Seu Site

1. Acesse: https://beta.publishers.adsterra.com/websites
2. Clique em **"Add Website"** ou **"Adicionar Site"**
3. Preencha:
   - **URL:** `https://bolsonarolivre.publicvm.com`
   - **Categoria:** Politics / News
   - **Descrição:** Site de petições políticas e engajamento cívico
   - **Tráfego estimado:** (informe o número atual de visitantes/dia)
   - **País principal:** Brazil (BR)

4. Clique em **"Submit"** ou **"Enviar"**

### 3. Verificar Propriedade do Site

Após submeter, o Adsterra fornecerá um dos métodos:

**Opção A: Meta Tag** (mais fácil)
```html
<meta name="adsterra-site-verification" content="SEU_CODIGO_AQUI" />
```

**Opção B: Arquivo HTML**
```
Fazer upload de adsterra-XXXXX.html na raiz do site
```

**Opção C: DNS TXT Record**
```
Adicionar TXT record no DNS
```

#### Como adicionar Meta Tag (recomendado):

1. Copie o código fornecido pelo Adsterra
2. Edite o arquivo `/home/renatoas/www/bolsonaro/index.php`
3. Adicione a meta tag dentro da seção `<head>`:

```php
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Verificação Adsterra -->
    <meta name="adsterra-site-verification" content="SEU_CODIGO_AQUI" />
    
    <title>Petição Política - Faça sua voz ser ouvida</title>
    ...
</head>
```

4. Faça commit e deploy:
```bash
git add index.php
git commit -m "Add Adsterra verification"
git push
```

5. Volte ao painel Adsterra e clique em **"Verify"**

### 4. Aguardar Aprovação

⏱️ **Tempo:** Normalmente 24-48 horas
📧 **Email:** Você receberá confirmação quando aprovado

### 5. Criar Zonas de Anúncios (Após Aprovação)

Quando aprovado, você verá opções para criar **Ad Spots** (Zonas):

#### Tipos de Anúncios Adsterra:

**A. Popunder** (Alto CPM)
- Melhor performance de receita
- Abre em nova aba quando usuário clica
- CPM: $1-$5 USD

**B. Banner (Display)**
- Tamanhos: 728x90, 300x250, 160x600, 970x90
- CPM: $0.50-$2 USD
- Visíveis na página

**C. Native Banner**
- Integra com design do site
- CPM: $0.80-$3 USD

**D. Social Bar**
- Barra flutuante na tela
- CPM: $1-$4 USD

**E. In-Page Push**
- Notificações dentro da página
- CPM: $2-$6 USD

#### Criar Zonas de Banner (exemplo):

1. No painel Adsterra, vá em **"Ad Spots"** → **"Add Spot"**
2. Selecione **"Banner"**
3. Configure:
   - **Name:** Banner Topo
   - **Size:** 728x90 (Leaderboard)
   - **Website:** bolsonarolivre.publicvm.com
   
4. Repita para criar 8 zonas:
   - ✅ Banner Topo (728x90)
   - ✅ Sidebar 1 (300x250)
   - ✅ Sidebar 2 (300x250)
   - ✅ Banner Meio 1 (728x90)
   - ✅ Banner Meio 2 (728x90)
   - ✅ Footer 1 (300x250)
   - ✅ Footer 2 (300x250)
   - ✅ Popunder (página inteira)

5. Para cada zona, copie o **código JavaScript** fornecido

### 6. Implementar Códigos no Site

Após criar cada zona, você receberá um código assim:

```html
<script type="text/javascript">
    atOptions = {
        'key' : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        'format' : 'iframe',
        'height' : 90,
        'width' : 728,
        'params' : {}
    };
    document.write('<scr' + 'ipt type="text/javascript" src="//www.topcreativeformat.com/xxxxx/invoke.js"></scr' + 'ipt>');
</script>
```

#### Atualizar ads-config.php:

Edite `/home/renatoas/www/bolsonaro/ads-config.php`:

```php
return [
    // Adsterra Configuration
    'adsterra' => [
        'enabled' => true,
        'spots' => [
            'banner_top' => [
                'key' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                'format' => 'iframe',
                'width' => 728,
                'height' => 90,
            ],
            'banner_sidebar_1' => [
                'key' => 'yyyyyyyyyyyyyyyyyyyyyyyyyyyyy',
                'format' => 'iframe',
                'width' => 300,
                'height' => 250,
            ],
            // ... adicionar outras zonas
            
            'popunder' => [
                'key' => 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
                'format' => 'popunder',
            ],
        ],
    ],
    
    // ... resto da config
];
```

### 7. Integrar com index.php

Vou criar um helper para facilitar:

```php
<?php
// Carregar config
$adsConfig = require 'ads-config.php';

function renderAdsterraAd($spot_name) {
    global $adsConfig;
    
    if (!isset($adsConfig['adsterra']['spots'][$spot_name])) {
        return '';
    }
    
    $spot = $adsConfig['adsterra']['spots'][$spot_name];
    
    if ($spot['format'] === 'popunder') {
        // Popunder code
        echo '<script type="text/javascript">';
        echo 'atOptions = ' . json_encode($spot) . ';';
        echo 'document.write(\'<scr\' + \'ipt type="text/javascript" src="//www.topcreativeformat.com/' . $spot['key'] . '/invoke.js"></scr\' + \'ipt>\');';
        echo '</script>';
    } else {
        // Banner code
        echo '<script type="text/javascript">';
        echo 'atOptions = ' . json_encode($spot) . ';';
        echo 'document.write(\'<scr\' + \'ipt type="text/javascript" src="//www.topcreativeformat.com/' . $spot['key'] . '/invoke.js"></scr\' + \'ipt>\');';
        echo '</script>';
    }
}
?>
```

Então no index.php, substitua os anúncios por:

```php
<!-- Banner Topo - Adsterra -->
<div class="banner-top">
    <?php renderAdsterraAd('banner_top'); ?>
</div>
```

### 8. Métricas e Pagamentos

#### Painel de Controle:
- **Estatísticas:** https://beta.publishers.adsterra.com/statistics
- **Receita:** Veja CPM, impressões, cliques em tempo real
- **Relatórios:** Diários, semanais, mensais

#### Pagamentos:
- **Mínimo:** $5 USD (WebMoney) ou $100 USD (PayPal, Wire)
- **Frequência:** Net-15 (15 dias após fim do mês)
- **Métodos:** PayPal, WebMoney, Paxum, Bitcoin, Wire Transfer

#### CPM Estimado (Brasil):
| Tipo de Anúncio | CPM Médio |
|-----------------|-----------|
| Popunder | $2-$5 |
| Banner Display | $0.50-$2 |
| Native Banner | $1-$3 |
| In-Page Push | $3-$6 |
| Social Bar | $2-$4 |

### 9. Otimização

✅ **Melhores práticas:**
- Use Popunder (maior CPM)
- Combine com banners (impressões extras)
- Evite muitos anúncios na mesma tela
- Teste diferentes posições
- Monitore taxa de rejeição (não afaste usuários)

✅ **Layout recomendado:**
```
Página:
├── 1x Popunder (por sessão)
├── 1x Banner Topo (728x90)
├── 2x Banner Sidebar (300x250)
├── 2x Banner Meio (728x90)
└── 1x Social Bar (flutuante)
```

### 10. Checklist de Implementação

- [ ] Cadastrar site no Adsterra
- [ ] Adicionar meta tag de verificação
- [ ] Aguardar aprovação (24-48h)
- [ ] Criar 8 zonas de anúncios
- [ ] Copiar códigos JavaScript
- [ ] Atualizar ads-config.php com as keys
- [ ] Criar função renderAdsterraAd()
- [ ] Substituir placeholders no index.php
- [ ] Fazer deploy em produção
- [ ] Testar anúncios carregando
- [ ] Monitorar receita no painel
- [ ] Configurar método de pagamento

---

## 💰 Projeção de Receita (Adsterra)

### Cenário Conservador
```
Visitantes/dia: 5.000
Popunder CPM: $3
Banner impressões: 40.000
Banner CPM: $1

Receita Popunder: $15/dia
Receita Banners: $40/dia
Total/dia: $55
Total/mês: $1.650
```

### Cenário Moderado
```
Visitantes/dia: 15.000
Popunder CPM: $4
Banner impressões: 120.000
Banner CPM: $1.50

Receita Popunder: $60/dia
Receita Banners: $180/dia
Total/dia: $240
Total/mês: $7.200
```

### Cenário Otimista
```
Visitantes/dia: 50.000
Popunder CPM: $5
Banner impressões: 400.000
Banner CPM: $2

Receita Popunder: $250/dia
Receita Banners: $800/dia
Total/dia: $1.050
Total/mês: $31.500
```

---

## 🔧 Suporte Técnico

**Adsterra Support:**
- Email: publishers@adsterra.com
- Skype: live:adsterra_publisher
- Telegram: @Adsterra_Publisher_Bot

**Horário:** 24/7 (suporte em inglês)

---

## ⚠️ Regras Importantes

❌ **Proibido:**
- Clicar nos próprios anúncios
- Tráfego falso/bots
- Conteúdo adulto/ilegal
- Forçar cliques

✅ **Permitido:**
- Tráfego orgânico
- SEO natural
- Redes sociais
- Email marketing (opt-in)

---

## 🎯 Próximos Passos AGORA

1. **Acesse:** https://beta.publishers.adsterra.com/websites
2. **Clique:** "Add Website"
3. **URL:** `https://bolsonarolivre.publicvm.com`
4. **Copie** a meta tag de verificação
5. **Me envie** o código para eu adicionar no index.php
6. **Aguarde** aprovação
7. **Quando aprovado**, copie as keys dos Ad Spots
8. **Me envie** as keys para eu configurar

---

**Estou pronto para atualizar os arquivos assim que você tiver as informações do Adsterra! 🚀**
