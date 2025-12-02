# Sistema de Petição Política com PHP e Bootstrap

Sistema completo para criação de petições online com recursos de doação via PIX, galeria de imagens e múltiplos espaços para banners publicitários.

## 🚀 Características

- ✅ Formulário completo de petição com validação
- 💰 Sistema de doação via PIX com QR Code
- 🖼️ Galeria de imagens com upload
- 📊 Contadores animados de assinaturas
- 📱 Design responsivo com Bootstrap 5
- 💾 Sistema de banco de dados MySQL
- 🎯 Múltiplos espaços para banners publicitários
- 📧 Sistema de newsletter
- 🔒 Validação de CPF e dados

## 📋 Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx)
- Extensões PHP: PDO, GD (opcional para manipulação de imagens)

## 🛠️ Instalação

### 1. Configurar o Banco de Dados

```bash
# Importar o schema do banco de dados
mysql -u root -p < database.sql
```

Ou execute manualmente no phpMyAdmin/MySQL:
- Crie o banco de dados `peticao_db`
- Execute o conteúdo do arquivo `database.sql`

### 2. Configurar o Projeto

Edite o arquivo `config.php` e ajuste as configurações:

```php
// Banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'peticao_db');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');

// Chave PIX
define('PIX_KEY', 'sua-chave-pix@email.com');
define('PIX_NAME', 'Seu Nome');
```

### 3. Configurar Permissões

```bash
# Criar diretório de uploads
mkdir -p uploads/galeria
chmod 755 uploads
chmod 755 uploads/galeria
```

### 4. Configurar Servidor Web

#### Apache (.htaccess)
```apache
RewriteEngine On
RewriteBase /

# Proteção de arquivos
<Files "config.php">
    Order Allow,Deny
    Deny from all
</Files>
```

#### Nginx
```nginx
location ~ /config\.php$ {
    deny all;
}

location /uploads {
    location ~ \.php$ {
        deny all;
    }
}
```

## 📁 Estrutura de Arquivos

```
/
├── index.php              # Página principal
├── processar_peticao.php  # Processa assinaturas
├── upload.php             # Upload de imagens
├── config.php             # Configurações
├── database.sql           # Schema do banco
├── README.md              # Documentação
└── uploads/
    └── galeria/           # Imagens enviadas
```

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
