<?php
/**
 * Configuração de Anúncios
 * 
 * IMPORTANTE: Configure os IDs reais dos seus serviços de publicidade
 */

return [
    // Adsterra (ATIVO - https://beta.publishers.adsterra.com/)
    'adsterra' => [
        'enabled' => true,
        'verification_code' => '', // Código de verificação (meta tag)
        'spots' => [
            // Banner Topo - 728x90
            'banner_top' => [
                'key' => '979a9f3418ef96fd72188961f9c4be21',
                'format' => 'iframe',
                'width' => 728,
                'height' => 90,
                'invoke_url' => '//www.highperformanceformat.com/979a9f3418ef96fd72188961f9c4be21/invoke.js',
            ],
            
            // Sidebar 1 - 300x250
            'banner_sidebar_1' => [
                'key' => '5fe3835d572ff7dfd0a84494e19632e4',
                'format' => 'iframe',
                'width' => 300,
                'height' => 250,
                'invoke_url' => '//www.highperformanceformat.com/5fe3835d572ff7dfd0a84494e19632e4/invoke.js',
            ],
            
            // Sidebar 2 - 160x600
            'banner_sidebar_2' => [
                'key' => '6f07d81924848fc9726f55f8e33d7274',
                'format' => 'iframe',
                'width' => 160,
                'height' => 600,
                'invoke_url' => '//www.highperformanceformat.com/6f07d81924848fc9726f55f8e33d7274/invoke.js',
            ],
            
            // Banner Meio 1 - 468x60
            'banner_middle_1' => [
                'key' => 'f7383e4e4aa8793f3102447b8d64b34e',
                'format' => 'iframe',
                'width' => 468,
                'height' => 60,
                'invoke_url' => '//www.highperformanceformat.com/f7383e4e4aa8793f3102447b8d64b34e/invoke.js',
            ],
            
            // Banner Meio 2 - 728x90
            'banner_middle_2' => [
                'key' => '979a9f3418ef96fd72188961f9c4be21',
                'format' => 'iframe',
                'width' => 728,
                'height' => 90,
                'invoke_url' => '//www.highperformanceformat.com/979a9f3418ef96fd72188961f9c4be21/invoke.js',
            ],
            
            // Sidebar 3 - 160x300
            'banner_sidebar_3' => [
                'key' => '884e1eb1f0260fbe5aa1229c6f409791',
                'format' => 'iframe',
                'width' => 160,
                'height' => 300,
                'invoke_url' => '//www.highperformanceformat.com/884e1eb1f0260fbe5aa1229c6f409791/invoke.js',
            ],
            
            // Sidebar 4 - 300x250
            'banner_sidebar_4' => [
                'key' => '5fe3835d572ff7dfd0a84494e19632e4',
                'format' => 'iframe',
                'width' => 300,
                'height' => 250,
                'invoke_url' => '//www.highperformanceformat.com/5fe3835d572ff7dfd0a84494e19632e4/invoke.js',
            ],
            
            // Popunder (ALTO CPM!)
            'popunder' => [
                'key' => '5684dbbe76b18d4a5eb0ec1d550a314d',
                'format' => 'popunder',
                'invoke_url' => '//pl28173009.effectivegatecpm.com/56/84/db/5684dbbe76b18d4a5eb0ec1d550a314d.js',
            ],
        ],
    ],
    
    // Google AdSense (ALTERNATIVO - caso prefira AdSense)
    'adsense' => [
        'enabled' => false, // Desativado (use Adsterra OU AdSense, não ambos)
        'client_id' => 'ca-pub-XXXXXXXXXXXXXXXX', // Seu Publisher ID do AdSense
        'slots' => [
            'banner_top' => '1234567890',      // Slot do banner superior (728x90)
            'banner_sidebar_1' => '0987654321', // Slot da sidebar 1 (300x250)
            'banner_sidebar_2' => '1122334455', // Slot da sidebar 2 (300x250)
            'banner_middle_1' => '2233445566',  // Slot do banner meio 1 (728x90)
            'banner_middle_2' => '3344556677',  // Slot do banner meio 2 (728x90)
            'banner_footer_1' => '4455667788',  // Slot do rodapé 1 (300x250)
            'banner_footer_2' => '5566778899',  // Slot do rodapé 2 (300x250)
            'banner_native' => '6677889900',    // Native ads
        ],
    ],
    
    // Google Analytics
    'analytics' => [
        'enabled' => true,
        'measurement_id' => 'G-XXXXXXXXXX', // ID do Google Analytics 4
        'gtm_id' => 'GTM-XXXXXXX',          // ID do Google Tag Manager (opcional)
    ],
    
    // Facebook Pixel
    'facebook_pixel' => [
        'enabled' => true,
        'pixel_id' => 'XXXXXXXXXXXXXXXX',   // Seu Facebook Pixel ID
    ],
    
    // Google Ad Manager (programmatic ads)
    'ad_manager' => [
        'enabled' => false,
        'network_code' => 'XXXXXXXXX',       // Código de rede do Ad Manager
    ],
    
    // Prebid.js (Header Bidding)
    'prebid' => [
        'enabled' => false,
        'timeout' => 2000, // ms
        'bidders' => [
            // Configurar quando necessário
        ],
    ],
    
    // Configurações gerais
    'general' => [
        'lazy_load' => true,                 // Carregar anúncios sob demanda
        'refresh_enabled' => false,          // Auto-refresh de anúncios
        'refresh_interval' => 30000,         // Intervalo de refresh em ms
        'block_ad_blockers' => false,        // Detectar e bloquear ad-blockers
    ],
    
    // LGPD/GDPR Compliance
    'privacy' => [
        'cookie_consent_required' => true,
        'consent_mode' => 'opt-in',          // 'opt-in' ou 'opt-out'
        'privacy_policy_url' => '/politica-privacidade.php',
        'terms_url' => '/termos-de-uso.php',
    ],
];
