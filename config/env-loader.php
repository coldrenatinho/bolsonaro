<?php
/**
 * Carregador de variáveis de ambiente
 * Lê o arquivo .env e carrega as variáveis como constantes PHP
 */

function loadEnv($filePath = __DIR__ . '/.env') {
    if (!file_exists($filePath)) {
        error_log("Arquivo .env não encontrado: {$filePath}");
        return false;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Ignorar comentários e linhas vazias
        if (strpos(trim($line), '#') === 0 || empty(trim($line))) {
            continue;
        }

        // Parse da linha
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            
            $key = trim($key);
            $value = trim($value);
            
            // Remover aspas do valor
            $value = trim($value, '"\'');
            
            // Definir como variável de ambiente e constante
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
            
            // Definir como constante se ainda não existir
            if (!defined($key)) {
                define($key, $value);
            }
        }
    }
    
    return true;
}

/**
 * Obter valor de variável de ambiente com valor padrão
 */
function env($key, $default = null) {
    $value = getenv($key);
    
    if ($value === false) {
        $value = $_ENV[$key] ?? $default;
    }
    
    // Conversão de valores booleanos
    if (strtolower($value) === 'true') {
        return true;
    }
    if (strtolower($value) === 'false') {
        return false;
    }
    if (strtolower($value) === 'null') {
        return null;
    }
    
    return $value;
}

// Carregar o .env automaticamente quando este arquivo for incluído
loadEnv();
