# 🚀 Início Rápido - Sistema de Propagandas

## ✅ Status: Tudo Configurado!

Seu site está rodando em: **http://localhost:8080**

---

## 📍 Como Adicionar/Editar Propagandas

### 1️⃣ Abra o arquivo `ads.php`

### 2️⃣ Localize a posição que deseja editar

```php
'banner_topo' => [
    'tipo' => 'banner',
    'codigo' => 'SEU CÓDIGO AQUI',
],
```

### 3️⃣ Escolha o tipo de anúncio

#### Opção A: Banner Simples (Imagem + Link)
```php
'banner_topo' => [
    'tipo' => 'banner',
    'codigo' => '<a href="https://seulink.com" target="_blank">
                    <img src="/uploads/banners/seu-banner.jpg" 
                         alt="Banner" 
                         style="max-width:100%; height:auto;">
                </a>',
],
```

#### Opção B: Google AdSense
```php
'banner_topo' => [
    'tipo' => 'adsense',
    'adsense_client' => 'ca-pub-1234567890', // Seu ID
    'adsense_slot' => '9876543210',          // Slot do anúncio
    'adsense_format' => 'auto',
],
```

#### Opção C: Código HTML/JavaScript Personalizado
```php
'banner_topo' => [
    'tipo' => 'script',
    'codigo' => '<script>
                    // Código do anunciante
                </script>
                <div id="meu-anuncio"></div>',
],
```

### 4️⃣ Salve e pronto! 

O anúncio já está no ar. Sem necessidade de reiniciar containers.

---

## 📂 Upload de Imagens de Banners

### Via Terminal:
```bash
# Copiar banner para o projeto
cp seu-banner.jpg uploads/banners/

# Ajustar permissões
chmod 644 uploads/banners/seu-banner.jpg
```

### Via phpMyAdmin:
Acesse: http://localhost:8080/phpmyadmin

---

## 🎨 Tamanhos Recomendados de Banners

| Posição | Tamanho | Nome |
|---------|---------|------|
| Topo | 728x90 | Leaderboard |
| Sidebar | 300x250 | Medium Rectangle |
| Sidebar Alto | 300x600 | Skyscraper |
| Meio | 970x250 | Billboard |
| Rodapé | 728x90 | Leaderboard |

---

## 💰 Monetização Rápida

### Passo 1: Google AdSense (Mais Fácil)
1. Acesse: https://www.google.com/adsense
2. Cadastre seu site
3. Aguarde aprovação (1-2 semanas)
4. Copie o código e cole em `ads.php`

### Passo 2: Venda Direta
1. Entre em contato com empresas/políticos locais
2. Negocie valor mensal (ex: R$ 500/mês)
3. Receba o banner
4. Adicione em `ads.php`

### Passo 3: Afiliados
1. Cadastre-se: Hotmart, Monetizze, Amazon
2. Escolha produtos relacionados
3. Gere link de afiliado
4. Crie banner e adicione em `ads.php`

---

## 🔧 Comandos Docker Úteis

```bash
# Ver logs
docker compose logs -f nginx
docker compose logs -f php

# Reiniciar containers
docker compose restart

# Parar tudo
docker compose down

# Subir novamente
docker compose up -d

# Acessar container PHP
docker compose exec php bash
```

---

## 📊 Posições dos Anúncios no Site

```
┌─────────────────────────────────────┐
│      BANNER TOPO (728x90)           │
└─────────────────────────────────────┘

┌──────────────────┬──────────────────┐
│                  │  SIDEBAR 1       │
│   HERO           │  (300x250)       │
│                  │                  │
└──────────────────┴──────────────────┘

┌──────────────────┬──────────────────┐
│                  │  SIDEBAR 3       │
│   SOBRE          │  (300x600)       │
│                  │                  │
│                  │                  │
└──────────────────┴──────────────────┘

┌─────────────────────────────────────┐
│    BANNER MIDDLE (970x250)          │
└─────────────────────────────────────┘

┌──────────────────┬──────────────────┐
│                  │  SIDEBAR 2       │
│   FORMULÁRIO     │  (300x250)       │
│                  ├──────────────────┤
│                  │  SIDEBAR 2       │
│                  │  (300x250)       │
└──────────────────┴──────────────────┘

┌─────────────────────────────────────┐
│    BANNER FOOTER (728x90)           │
└─────────────────────────────────────┘
```

---

## 🎯 Exemplo Prático

Vamos adicionar um banner do Google AdSense no topo:

### 1. Pegue seu código do AdSense:
```
ID do Publisher: ca-pub-1234567890
ID do Slot: 9876543210
```

### 2. Edite `ads.php`:
```php
'banner_topo' => [
    'tipo' => 'adsense',
    'adsense_client' => 'ca-pub-1234567890',
    'adsense_slot' => '9876543210',
    'adsense_format' => 'auto',
],
```

### 3. Salve e acesse: http://localhost:8080

✅ Pronto! Seu anúncio do AdSense está funcionando!

---

## ❓ Dúvidas?

Consulte o arquivo **GUIA_PROPAGANDAS.md** para instruções detalhadas.

---

## 🎉 Resumo

✅ Site funcionando: http://localhost:8080  
✅ phpMyAdmin: http://localhost:8080/phpmyadmin  
✅ 6 posições de anúncios prontas  
✅ Sistema centralizado em `ads.php`  
✅ Suporte para AdSense, banners e scripts  
✅ Fácil de atualizar  

**Comece agora a monetizar!** 💰
