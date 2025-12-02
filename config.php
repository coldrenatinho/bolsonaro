<?php
// Configurações do Banco de Dados
define('DB_HOST', getenv('DB_HOST') ?: 'mysql');
define('DB_NAME', getenv('DB_NAME') ?: 'peticao_db');
define('DB_USER', getenv('DB_USER') ?: 'user');
define('DB_PASS', getenv('DB_PASS') ?: 'userpassword');

// Configurações do Site
define('SITE_NAME', 'Petição Política');
define('SITE_URL', 'http://localhost');
define('ADMIN_EMAIL', 'admin@peticao.com.br');

// Configurações de Upload
define('UPLOAD_DIR', 'uploads/galeria/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// Configurações de Email
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'seu-email@gmail.com');
define('SMTP_PASS', 'sua-senha');
define('SMTP_FROM', 'noreply@peticao.com.br');
define('SMTP_FROM_NAME', 'Petição Política');

// Configurações PIX
define('PIX_KEY', 'sua-chave-pix@email.com');
define('PIX_NAME', 'Seu Nome Aqui');
define('PIX_CITY', 'SAO PAULO');

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
