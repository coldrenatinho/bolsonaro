<?php
namespace App\Helpers;

class EnvLoader
{
    private static $loaded = false;

    public static function load($filePath = null)
    {
        if (self::$loaded) return true;

        if ($filePath === null) {
            $filePath = dirname(__DIR__, 2) . '/config/.env';
        }

        if (!file_exists($filePath)) {
            error_log("Arquivo .env não encontrado: {$filePath}");
            return false;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0 || empty(trim($line))) continue;

            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, '"\'');
                
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
                if (!defined($key)) define($key, $value);
            }
        }
        
        self::$loaded = true;
        return true;
    }

    public static function get($key, $default = null)
    {
        $value = getenv($key) ?: ($_ENV[$key] ?? $default);
        if (strtolower($value) === 'true') return true;
        if (strtolower($value) === 'false') return false;
        if (strtolower($value) === 'null') return null;
        return $value;
    }
}
