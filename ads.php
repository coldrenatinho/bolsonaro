<?php
/**
 * Sistema de Gerenciamento de Anúncios
 * 
 * Este arquivo permite gerenciar diferentes tipos de anúncios
 * de forma centralizada e fácil de atualizar.
 */

// Tipo de anúncio: 'adsense', 'banner', 'script', 'afiliado'
$ads_config = [
    
    // Banner Topo - 728x90 (Leaderboard)
    'banner_topo' => [
        'tipo' => 'banner', // Opções: 'adsense', 'banner', 'script', 'afiliado'
        'codigo' => '<a href="https://seulink.com" target="_blank">
                        <img src="https://via.placeholder.com/728x90/0066cc/ffffff?text=Anuncio+728x90" 
                             alt="Banner Topo" 
                             style="max-width:100%; height:auto;">
                    </a>',
        'adsense_slot' => '', // Se usar AdSense, coloque o slot aqui
    ],
    
    // Banner Sidebar 1 - 300x250 (Medium Rectangle)
    'banner_sidebar_1' => [
        'tipo' => 'banner',
        'codigo' => '<a href="https://seulink.com" target="_blank">
                        <img src="https://via.placeholder.com/300x250/cc6600/ffffff?text=Sidebar+300x250" 
                             alt="Banner Sidebar 1" 
                             style="max-width:100%; height:auto;">
                    </a>',
        'adsense_slot' => '',
    ],
    
    // Banner Sidebar 2 - 300x250 (Medium Rectangle)
    'banner_sidebar_2' => [
        'tipo' => 'banner',
        'codigo' => '<a href="https://seulink.com" target="_blank">
                        <img src="https://via.placeholder.com/300x250/009900/ffffff?text=Sidebar+300x250" 
                             alt="Banner Sidebar 2" 
                             style="max-width:100%; height:auto;">
                    </a>',
        'adsense_slot' => '',
    ],
    
    // Banner Sidebar 3 - 300x600 (Skyscraper)
    'banner_sidebar_3' => [
        'tipo' => 'banner',
        'codigo' => '<a href="https://seulink.com" target="_blank">
                        <img src="https://via.placeholder.com/300x600/990099/ffffff?text=Skyscraper+300x600" 
                             alt="Banner Sidebar 3" 
                             style="max-width:100%; height:auto;">
                    </a>',
        'adsense_slot' => '',
    ],
    
    // Banner Middle - 970x250 (Billboard)
    'banner_middle' => [
        'tipo' => 'banner',
        'codigo' => '<a href="https://seulink.com" target="_blank">
                        <img src="https://via.placeholder.com/970x250/cc0000/ffffff?text=Billboard+970x250" 
                             alt="Banner Middle" 
                             style="max-width:100%; height:auto;">
                    </a>',
        'adsense_slot' => '',
    ],
    
    // Banner Footer - 728x90 (Leaderboard)
    'banner_footer' => [
        'tipo' => 'banner',
        'codigo' => '<a href="https://seulink.com" target="_blank">
                        <img src="https://via.placeholder.com/728x90/006699/ffffff?text=Footer+728x90" 
                             alt="Banner Footer" 
                             style="max-width:100%; height:auto;">
                    </a>',
        'adsense_slot' => '',
    ],
    
    // Exemplo de Google AdSense
    'adsense_exemplo' => [
        'tipo' => 'adsense',
        'adsense_client' => 'ca-pub-XXXXXXXXXX', // Seu ID do AdSense
        'adsense_slot' => '1234567890', // Slot do anúncio
        'adsense_format' => 'auto', // ou tamanho específico
    ],
    
    // Exemplo de Script de Afiliado (Ex: Amazon, Hotmart, Monetizze)
    'afiliado_exemplo' => [
        'tipo' => 'script',
        'codigo' => '<script src="https://afiliado.com/script.js"></script>
                    <div id="afiliado-widget"></div>',
    ],
];

/**
 * Função para exibir anúncio
 */
function exibir_anuncio($posicao) {
    global $ads_config;
    
    if (!isset($ads_config[$posicao])) {
        return '';
    }
    
    $ad = $ads_config[$posicao];
    
    switch ($ad['tipo']) {
        case 'adsense':
            return renderAdSense($ad);
            
        case 'banner':
        case 'script':
        case 'afiliado':
            return $ad['codigo'];
            
        default:
            return '';
    }
}

/**
 * Renderizar Google AdSense
 */
function renderAdSense($ad) {
    if (empty($ad['adsense_client']) || empty($ad['adsense_slot'])) {
        return '<div class="alert alert-warning">Configure o AdSense em ads.php</div>';
    }
    
    $format = $ad['adsense_format'] ?? 'auto';
    
    return '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . $ad['adsense_client'] . '"
                 crossorigin="anonymous"></script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="' . $ad['adsense_client'] . '"
                 data-ad-slot="' . $ad['adsense_slot'] . '"
                 data-ad-format="' . $format . '"
                 data-full-width-responsive="true"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>';
}

// Exemplo de uso:
// <?php include 'ads.php'; echo exibir_anuncio('banner_topo'); ?>
