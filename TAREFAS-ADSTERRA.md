# ✅ TAREFAS PARA MONETIZAÇÃO - Adsterra

## 🎯 O QUE VOCÊ PRECISA FAZER AGORA

### Tarefa 1: Cadastrar Site no Adsterra (⏱️ 5 minutos)

1. **Acesse:** https://beta.publishers.adsterra.com/websites
2. **Clique:** "Add Website" ou "Adicionar Site"
3. **Preencha:**
   - URL: `https://bolsonarolivre.publicvm.com`
   - Category: `Politics` ou `News`
   - Description: `Political petition website with high engagement`
   - Monthly Traffic: `Informar estimativa`
   - Main GEO: `Brazil (BR)`

4. **Submit/Enviar**

### Tarefa 2: Copiar Código de Verificação (⏱️ 1 minuto)

Após submeter, você verá uma tela com código de verificação.

**Exemplo:**
```html
<meta name="adsterra-site-verification" content="abc123xyz789" />
```

**✉️ ME ENVIE ESTE CÓDIGO!**

Colar aqui:
```
MEU CÓDIGO: _________________________________
```

### Tarefa 3: Aguardar Email de Aprovação (⏱️ 24-48h)

📧 Você receberá email com assunto:
```
"Your website has been approved!"
```

⏸️ **PARE AQUI até receber aprovação**

---

## 🎉 APÓS APROVAÇÃO

### Tarefa 4: Criar Ad Spots (⏱️ 15 minutos)

No painel Adsterra (https://beta.publishers.adsterra.com/):

1. Clique em **"Ad Spots"** ou **"Criar Anúncio"**
2. Crie **8 spots** (um por vez):

#### Spot 1: Banner Topo
- **Name:** Banner Topo
- **Format:** Banner Display
- **Size:** 728x90 (Leaderboard)
- **Website:** bolsonarolivre.publicvm.com
- ✅ Copiar **KEY** fornecida

#### Spot 2: Sidebar 1
- **Name:** Sidebar 1
- **Format:** Banner Display
- **Size:** 300x250 (Medium Rectangle)
- ✅ Copiar **KEY**

#### Spot 3: Sidebar 2
- **Name:** Sidebar 2
- **Format:** Banner Display
- **Size:** 300x250 (Medium Rectangle)
- ✅ Copiar **KEY**

#### Spot 4: Banner Meio 1
- **Name:** Banner Meio 1
- **Format:** Banner Display
- **Size:** 728x90 (Leaderboard)
- ✅ Copiar **KEY**

#### Spot 5: Banner Meio 2
- **Name:** Banner Meio 2
- **Format:** Banner Display
- **Size:** 728x90 (Leaderboard)
- ✅ Copiar **KEY**

#### Spot 6: Footer 1
- **Name:** Footer 1
- **Format:** Banner Display
- **Size:** 300x250 (Medium Rectangle)
- ✅ Copiar **KEY**

#### Spot 7: Footer 2
- **Name:** Footer 2
- **Format:** Banner Display
- **Size:** 300x250 (Medium Rectangle)
- ✅ Copiar **KEY**

#### Spot 8: Popunder (IMPORTANTE!)
- **Name:** Popunder Principal
- **Format:** Popunder
- **Frequency:** Once per session
- ✅ Copiar **KEY**

### Tarefa 5: Anotar as 8 Keys (⏱️ 5 minutos)

**✉️ ME ENVIE ESTAS INFORMAÇÕES:**

```
CÓDIGO DE VERIFICAÇÃO:
_____________________________________

KEYS DOS AD SPOTS:

1. Banner Topo (728x90):
   Key: _____________________________________

2. Sidebar 1 (300x250):
   Key: _____________________________________

3. Sidebar 2 (300x250):
   Key: _____________________________________

4. Banner Meio 1 (728x90):
   Key: _____________________________________

5. Banner Meio 2 (728x90):
   Key: _____________________________________

6. Footer 1 (300x250):
   Key: _____________________________________

7. Footer 2 (300x250):
   Key: _____________________________________

8. Popunder:
   Key: _____________________________________
```

---

## 🤖 O QUE EU VOU FAZER (AUTOMATICAMENTE)

Quando você me enviar as keys, eu vou:

### Passo 1: Adicionar verificação no index.php
```php
<meta name="adsterra-site-verification" content="SEU_CODIGO" />
```

### Passo 2: Configurar ads-config.php
```php
'adsterra' => [
    'enabled' => true,
    'spots' => [
        'banner_top' => [
            'key' => 'SUA_KEY_1',
            ...
        ],
        // ... todas as 8 keys
    ],
],
```

### Passo 3: Atualizar index.php
Substituir todos os placeholders por:
```php
<?php renderAdsterraAd('banner_top'); ?>
```

### Passo 4: Git commit e push
```bash
git add .
git commit -m "Integrate Adsterra ads"
git push
```

### Passo 5: Verificar funcionamento
- Acessar https://bolsonarolivre.publicvm.com
- Verificar se anúncios aparecem
- Testar banner de cookies

---

## 📝 Template para me enviar

**Copie e preencha:**

```
Olá! Seguem as informações do Adsterra:

CÓDIGO DE VERIFICAÇÃO:
abc123xyz789def456

KEYS:
1. Banner Topo: key1234567890
2. Sidebar 1: key0987654321
3. Sidebar 2: key1122334455
4. Banner Meio 1: key2233445566
5. Banner Meio 2: key3344556677
6. Footer 1: key4455667788
7. Footer 2: key5566778899
8. Popunder: key6677889900

Status: Site aprovado ✅
```

---

## ⏱️ Timeline Completa

| Quando | O quê | Quem |
|--------|-------|------|
| **Agora** | Cadastrar site | VOCÊ |
| **Agora** | Enviar código verificação | VOCÊ |
| **5 min** | Adicionar meta tag | EU |
| **24-48h** | Aguardar aprovação | Adsterra |
| **Após aprovação** | Criar 8 Ad Spots | VOCÊ |
| **Após criar spots** | Enviar 8 keys | VOCÊ |
| **10 min** | Configurar tudo | EU |
| **Imediato** | Deploy em produção | EU |
| **✅ PRONTO!** | Site monetizado! | 💰 |

---

## 🆘 Dúvidas Comuns

**P: E se meu site não for aprovado?**
R: Improvável para sites de política. Mas se acontecer, podemos tentar AdSense.

**P: Quanto tempo até começar a ganhar?**
R: Assim que os anúncios aparecerem (mesmo dia após configurar).

**P: Quando recebo o primeiro pagamento?**
R: Net-15. Se ganhar $5+ em Janeiro, recebe em 15 de Fevereiro.

**P: Posso mudar os anúncios depois?**
R: Sim! Pode criar/editar/deletar spots quando quiser.

**P: E se quiser testar AdSense depois?**
R: Pode! Basta desabilitar Adsterra no config e habilitar AdSense.

---

## 🚀 COMECE AGORA!

👉 **Passo 1:** Acesse https://beta.publishers.adsterra.com/websites

👉 **Passo 2:** Clique "Add Website"

👉 **Passo 3:** Me envie o código de verificação

**Simples assim! 🎯**
