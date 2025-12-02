<?php
/**
 * Configurações do Sistema
 * Carrega variáveis do arquivo .env
 */

// Carregar variáveis de ambiente
require_once __DIR__ . '/env-loader.php';

// Configurações do Banco de Dados (do .env)
if (!defined('DB_HOST')) define('DB_HOST', env('DB_HOST', 'mysql'));
if (!defined('DB_NAME')) define('DB_NAME', env('DB_NAME', 'peticao_db'));
if (!defined('DB_USER')) define('DB_USER', env('DB_USER', 'user'));
if (!defined('DB_PASS')) define('DB_PASS', env('DB_PASS', 'userpassword'));

// Configurações do Site (do .env)
if (!defined('SITE_NAME')) define('SITE_NAME', env('SITE_NAME', 'Petição Política'));
if (!defined('SITE_URL')) define('SITE_URL', env('SITE_URL', 'https://bolsonarolivre.publicvm.com'));
if (!defined('ADMIN_EMAIL')) define('ADMIN_EMAIL', env('ADMIN_EMAIL', 'admin@exemplo.com'));

// Configurações de Upload
define('UPLOAD_DIR', 'uploads/galeria/');
define('MAX_FILE_SIZE', (int)env('UPLOAD_MAX_SIZE', 5242880)); // 5MB padrão
$allowedTypesString = env('ALLOWED_IMAGE_TYPES', 'image/jpeg,image/png,image/gif,image/webp');
define('ALLOWED_TYPES', explode(',', $allowedTypesString));

// Configurações de Email (do .env)
if (!defined('SMTP_HOST')) define('SMTP_HOST', env('SMTP_HOST', 'smtp.gmail.com'));
if (!defined('SMTP_PORT')) define('SMTP_PORT', (int)env('SMTP_PORT', 587));
if (!defined('SMTP_USER')) define('SMTP_USER', env('SMTP_USER', ''));
if (!defined('SMTP_PASS')) define('SMTP_PASS', env('SMTP_PASS', ''));
if (!defined('SMTP_FROM')) define('SMTP_FROM', env('SMTP_FROM', ADMIN_EMAIL));
if (!defined('SMTP_FROM_NAME')) define('SMTP_FROM_NAME', env('SMTP_FROM_NAME', SITE_NAME));

// Configurações PIX (do .env)
if (!defined('PIX_KEY')) define('PIX_KEY', env('PIX_KEY', ''));
if (!defined('PIX_NAME')) define('PIX_NAME', env('PIX_NAME', ''));
if (!defined('PIX_CITY')) define('PIX_CITY', env('PIX_CITY', 'SAO PAULO'));
if (!defined('PIX_IDENTIFICADOR')) define('PIX_IDENTIFICADOR', env('PIX_IDENTIFICADOR', 'PETICAO'));

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Função para conectar ao banco
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erro de conexão: " . $e->getMessage());
        die("Erro ao conectar ao banco de dados. Por favor, tente novamente mais tarde.");
    }
}

// Função para sanitizar dados
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Função para validar CPF
function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    if (strlen($cpf) != 11) {
        return false;
    }
    
    // Verifica se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    
    // Validação do primeiro dígito verificador
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    
    return true;
}

// Função para gerar QR Code PIX
function gerarQRCodePIX($valor = null) {
    $pixKey = PIX_KEY;
    $name = PIX_NAME;
    $city = PIX_CITY;
    
    // Payload básico do PIX
    $payload = "00020126580014br.gov.bcb.pix0136{$pixKey}";
    if ($valor) {
        $payload .= "5204000053039865406" . number_format($valor, 2, '', '');
    }
    $payload .= "5802BR5925{$name}6009{$city}62070503***6304";
    
    // Gerar QR Code via API
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($payload);
    
    return $qrCodeUrl;
}
