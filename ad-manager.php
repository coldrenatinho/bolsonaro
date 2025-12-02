<?php
/**
 * Gerenciador de Anúncios com Rastreamento
 * Sistema completo com cookies, analytics e monetização
 */

class AdManager {
    private $cookieName = 'visitor_id';
    private $cookieExpiry = 30 * 24 * 60 * 60; // 30 dias
    private $logsDir;
    
    public function __construct() {
        $this->logsDir = __DIR__ . '/logs';
        $this->ensureLogsDirectory();
        $this->initVisitor();
    }
    
    // Garantir que diretório de logs existe
    private function ensureLogsDirectory() {
        if (!is_dir($this->logsDir)) {
            mkdir($this->logsDir, 0777, true);
        }
    }
    
    // Inicializar visitante com cookie único
    private function initVisitor() {
        if (!isset($_COOKIE[$this->cookieName])) {
            $visitorId = $this->generateVisitorId();
            setcookie($this->cookieName, $visitorId, time() + $this->cookieExpiry, '/', '', isset($_SERVER['HTTPS']), true);
            $_COOKIE[$this->cookieName] = $visitorId;
            $this->trackNewVisitor($visitorId);
        } else {
            $this->trackReturningVisitor($_COOKIE[$this->cookieName]);
        }
    }
    
    // Gerar ID único para visitante
    private function generateVisitorId() {
        return bin2hex(random_bytes(16)) . '_' . time();
    }
    
    // Rastrear novo visitante
    private function trackNewVisitor($visitorId) {
        $data = [
            'visitor_id' => $visitorId,
            'first_visit' => date('Y-m-d H:i:s'),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'ip' => $this->getClientIP(),
            'referrer' => $_SERVER['HTTP_REFERER'] ?? 'direct',
            'page' => $_SERVER['REQUEST_URI'] ?? '/',
            'country' => $this->getCountryFromIP()
        ];
        
        $this->saveVisitorData($data);
    }
    
    // Rastrear visitante recorrente
    private function trackReturningVisitor($visitorId) {
        $data = [
            'visitor_id' => $visitorId,
            'visit_time' => date('Y-m-d H:i:s'),
            'page' => $_SERVER['REQUEST_URI'] ?? '/',
            'ip' => $this->getClientIP()
        ];
        
        $this->updateVisitorData($data);
    }
    
    // Obter IP real do cliente
    private function getClientIP() {
        $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ips = explode(',', $_SERVER[$key]);
                return trim($ips[0]);
            }
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    // Obter país do IP (simplificado)
    private function getCountryFromIP() {
        $ip = $this->getClientIP();
        // Usar API gratuita para obter país
        try {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country,countryCode");
            if ($response) {
                $data = json_decode($response, true);
                return $data['countryCode'] ?? 'Unknown';
            }
        } catch (Exception $e) {
            // Silencioso
        }
        return 'Unknown';
    }
    
    // Salvar dados do visitante
    private function saveVisitorData($data) {
        $logFile = $this->logsDir . '/visitors.json';
        $logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
        
        if (!is_array($logs)) $logs = [];
        
        $logs[] = $data;
        
        // Manter apenas últimos 10000 registros
        if (count($logs) > 10000) {
            $logs = array_slice($logs, -10000);
        }
        
        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }
    
    // Atualizar dados do visitante
    private function updateVisitorData($data) {
        $logFile = $this->logsDir . '/returning_visitors.json';
        $logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
        
        if (!is_array($logs)) $logs = [];
        
        $logs[] = $data;
        
        // Manter apenas últimos 5000 registros
        if (count($logs) > 5000) {
            $logs = array_slice($logs, -5000);
        }
        
        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }
    
    // Obter ID do visitante
    public function getVisitorId() {
        return $_COOKIE[$this->cookieName] ?? null;
    }
    
    // Rastrear clique em anúncio
    public function trackAdClick($adId, $position) {
        $data = [
            'visitor_id' => $this->getVisitorId(),
            'ad_id' => $adId,
            'position' => $position,
            'click_time' => date('Y-m-d H:i:s'),
            'page' => $_SERVER['REQUEST_URI'] ?? '/',
            'ip' => $this->getClientIP()
        ];
        
        $this->saveAdClick($data);
        return true;
    }
    
    // Salvar clique em anúncio
    private function saveAdClick($data) {
        $logFile = $this->logsDir . '/ad_clicks.json';
        $logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
        
        if (!is_array($logs)) $logs = [];
        
        $logs[] = $data;
        
        // Manter apenas últimos 5000 cliques
        if (count($logs) > 5000) {
            $logs = array_slice($logs, -5000);
        }
        
        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }
    
    // Rastrear impressão de anúncio
    public function trackAdImpression($adId, $position) {
        $data = [
            'visitor_id' => $this->getVisitorId(),
            'ad_id' => $adId,
            'position' => $position,
            'impression_time' => date('Y-m-d H:i:s'),
            'page' => $_SERVER['REQUEST_URI'] ?? '/'
        ];
        
        $logFile = $this->logsDir . '/ad_impressions.json';
        $logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];
        
        if (!is_array($logs)) $logs = [];
        
        $logs[] = $data;
        
        if (count($logs) > 10000) {
            $logs = array_slice($logs, -10000);
        }
        
        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }
    
    // Obter estatísticas
    public function getStats() {
        $visitorsFile = $this->logsDir . '/visitors.json';
        $clicksFile = $this->logsDir . '/ad_clicks.json';
        $impressionsFile = $this->logsDir . '/ad_impressions.json';
        
        $visitors = file_exists($visitorsFile) ? json_decode(file_get_contents($visitorsFile), true) : [];
        $clicks = file_exists($clicksFile) ? json_decode(file_get_contents($clicksFile), true) : [];
        $impressions = file_exists($impressionsFile) ? json_decode(file_get_contents($impressionsFile), true) : [];
        
        $totalVisitors = is_array($visitors) ? count($visitors) : 0;
        $totalClicks = is_array($clicks) ? count($clicks) : 0;
        $totalImpressions = is_array($impressions) ? count($impressions) : 0;
        
        $ctr = $totalImpressions > 0 ? ($totalClicks / $totalImpressions) * 100 : 0;
        
        return [
            'total_visitors' => $totalVisitors,
            'total_clicks' => $totalClicks,
            'total_impressions' => $totalImpressions,
            'ctr' => round($ctr, 2)
        ];
    }
}

// Inicializar gerenciador global
global $adManager;
$adManager = new AdManager();
