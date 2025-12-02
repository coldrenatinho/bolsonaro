# 📁 Índice de Arquivos do Projeto

## 📄 Arquivos Principais

### Sistema de Petições
| Arquivo | Descrição | Tamanho |
|---------|-----------|---------|
| `index.php` | Página principal com formulário de petição e 8 espaços para anúncios | 28 KB |
| `processar_peticao.php` | Processa assinaturas e salva no banco | 3.2 KB |
| `upload.php` | Upload de imagens para galeria | 2.1 KB |
| `config.php` | Configurações do banco de dados e PIX | 3.1 KB |
| `database.sql` | Schema do banco (tabelas: peticoes, assinaturas, imagens_galeria) | 2.2 KB |

### Sistema de Monetização
| Arquivo | Descrição | Tamanho |
|---------|-----------|---------|
| `ad-manager.php` | Sistema de rastreamento com cookies (visitantes, cliques, impressões) | 7.3 KB |
| `cookie-consent.php` | Banner LGPD/GDPR com 3 níveis de consentimento | 8.7 KB |
| `ads-config.php` | Configuração centralizada (AdSense, Analytics, Facebook Pixel) | 2.4 KB |
| `stats.php` | Dashboard de estatísticas (visitantes, CTR, receita projetada) | 14 KB |
| `ads.php` | Sistema legado de anúncios (não usado na versão atual) | 5.1 KB |

### Infraestrutura
| Arquivo | Descrição | Tamanho |
|---------|-----------|---------|
| `compose.yml` | Docker Compose (PHP, MySQL, Nginx, phpMyAdmin) | 1.8 KB |
| `Dockerfile` | Container PHP 8.2-fpm com extensões mysqli/pdo | - |
| `nginx.conf` | Configuração do servidor web | - |
| `.dockerignore` | Arquivos ignorados no build Docker | - |
| `.env.example` | Exemplo de variáveis de ambiente | - |

## 📚 Documentação

| Arquivo | Descrição | Tamanho |
|---------|-----------|---------|
| `README.md` | Documentação completa do sistema | 13 KB |
| `MONETIZACAO.md` | Guia completo de monetização (AdSense, Analytics, Facebook) | 4.1 KB |
| `INICIO-RAPIDO.md` | Guia de início rápido (3 passos para monetizar) | 4.9 KB |
| `RESUMO-EXECUTIVO.md` | Resumo executivo do projeto | 7.1 KB |
| `GUIA_PROPAGANDAS.md` | Guia de propagandas (versão antiga) | 9.5 KB |
| `INICIO_RAPIDO.md` | Versão antiga do guia rápido | 5.8 KB |

## 🧪 Testes

| Arquivo | Descrição | Tipo |
|---------|-----------|------|
| `test-monetization.sh` | Suite de testes automáticos (arquivos, sintaxe, Docker, APIs) | Shell Script |

## 📊 Logs e Dados

### Diretório: `logs/`
| Arquivo | Descrição | Formato |
|---------|-----------|---------|
| `visitors.json` | Novos visitantes (ID, IP, país, device, referrer) | JSON |
| `returning_visitors.json` | Visitantes recorrentes | JSON |
| `ad_clicks.json` | Cliques em anúncios (por posição) | JSON |
| `ad_impressions.json` | Impressões de anúncios | JSON |

### Diretório: `uploads/galeria/`
Imagens enviadas pelos usuários (galeria da petição)

---

## 🎯 Arquivos por Funcionalidade

### 1. Petição (Core)
```
index.php               # Interface principal
processar_peticao.php   # Backend de assinaturas
upload.php              # Upload de imagens
database.sql            # Estrutura do banco
config.php              # Configurações
```

### 2. Monetização
```
ad-manager.php          # Rastreamento
cookie-consent.php      # LGPD compliance
ads-config.php          # IDs dos serviços
stats.php               # Dashboard
```

### 3. Docker
```
compose.yml             # Orquestração
Dockerfile              # Container PHP
nginx.conf              # Servidor web
.env.example            # Variáveis de ambiente
```

### 4. Documentação
```
README.md               # Geral
MONETIZACAO.md          # Monetização
INICIO-RAPIDO.md        # Guia rápido
RESUMO-EXECUTIVO.md     # Resumo
```

### 5. Dados
```
logs/                   # Rastreamento
uploads/galeria/        # Imagens
```

---

## 📖 Como Usar Este Índice

### Para Desenvolvimento:
1. **Editar conteúdo**: `index.php`
2. **Configurar banco**: `config.php`
3. **Ajustar Docker**: `compose.yml`

### Para Monetização:
1. **Configurar IDs**: `ads-config.php`
2. **Ver estatísticas**: `stats.php`
3. **Ler guia**: `MONETIZACAO.md`

### Para Deploy:
1. **Ler documentação**: `README.md`
2. **Executar testes**: `./test-monetization.sh`
3. **Seguir guia**: `INICIO-RAPIDO.md`

---

## 🔍 Busca Rápida

### Preciso alterar...
- **Texto da petição** → `index.php` (linha ~160)
- **Chave PIX** → `config.php`
- **Cores do site** → `index.php` (CSS, linha ~20)
- **IDs do AdSense** → `ads-config.php`
- **Credenciais do banco** → `config.php`
- **Porta do site** → `compose.yml`

### Preciso entender...
- **Como funciona** → `README.md`
- **Como ganhar dinheiro** → `MONETIZACAO.md`
- **Início rápido** → `INICIO-RAPIDO.md`
- **Visão geral** → `RESUMO-EXECUTIVO.md`

### Preciso verificar...
- **Se está funcionando** → `./test-monetization.sh`
- **Quantos visitantes** → `http://localhost:8080/stats.php`
- **Erros no código** → `docker logs php_peticao`

---

## 📊 Estatísticas do Projeto

```
Total de arquivos: ~25
Linhas de código PHP: ~2.500
Documentação: ~100 KB
Sistema de logs: JSON
Banco de dados: MySQL 8.0
Containers Docker: 4
```

---

## 🚀 Próximos Passos

1. ✅ **Sistema instalado** - Todos arquivos presentes
2. ⏳ **Configurar AdSense** - Editar `ads-config.php`
3. ⏳ **Deploy produção** - Seguir `README.md`

**Comece aqui**: `INICIO-RAPIDO.md`
