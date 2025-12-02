<?php
/**
 * Helper para Renderizar Anúncios Adsterra
 */

// Carregar configuração
$adsConfig = require_once 'ads-config.php';

/**
 * Renderizar um banner Adsterra
 */
function renderAdsterraBanner($position) {
    global $adsConfig;
    
    if (!isset($adsConfig['adsterra']['enabled']) || !$adsConfig['adsterra']['enabled']) {
        return;
    }
    
    $spot = $adsConfig['adsterra']['spots'][$position] ?? null;
    
    if (!$spot || empty($spot['key'])) {
        echo "<!-- Adsterra {$position}: não configurado -->";
        return;
    }
    
    // Rastrear impressão
    if (function_exists('trackAdImpression')) {
        global $adManager;
        $adManager->trackAdImpression($spot['key'], $position);
    }
    
    ?>
    <!-- Adsterra <?= htmlspecialchars($position) ?> -->
    <div class="adsterra-ad" data-position="<?= htmlspecialchars($position) ?>" data-key="<?= htmlspecialchars($spot['key']) ?>">
        <script type="text/javascript">
            atOptions = {
                'key' : '<?= $spot['key'] ?>',
                'format' : '<?= $spot['format'] ?>',
                'height' : <?= $spot['height'] ?>,
                'width' : <?= $spot['width'] ?>,
                'params' : {}
            };
        </script>
        <script type="text/javascript" src="<?= $spot['invoke_url'] ?>"></script>
    </div>
    <?php
}

/**
 * Renderizar Popunder Adsterra
 */
function renderAdsterraPopunder() {
    global $adsConfig;
    
    if (!isset($adsConfig['adsterra']['enabled']) || !$adsConfig['adsterra']['enabled']) {
        return;
    }
    
    $popunder = $adsConfig['adsterra']['spots']['popunder'] ?? null;
    
    if (!$popunder || empty($popunder['invoke_url'])) {
        return;
    }
    
    ?>
    <script type="text/javascript">
        if (typeof getCookie !== 'undefined' && getCookie('ads_consent') === 'true') {
            (function() {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = '<?= $popunder['invoke_url'] ?>';
                document.head.appendChild(script);
            })();
        }
    </script>
    <?php
}
