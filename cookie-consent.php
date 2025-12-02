<!-- Cookie Consent Banner (LGPD/GDPR Compliant) -->
<div id="cookieConsent" class="cookie-consent" style="display: none;">
    <div class="cookie-content">
        <p>
            <strong>🍪 Este site usa cookies e tecnologias de rastreamento</strong><br>
            Utilizamos cookies e tecnologias semelhantes para melhorar sua experiência, 
            personalizar conteúdo e anúncios, fornecer recursos de mídia social e analisar nosso tráfego. 
            Também compartilhamos informações sobre o uso do site com nossos parceiros de mídia social, 
            publicidade e análise. Ao continuar navegando, você concorda com nossa 
            <a href="/politica-privacidade.php" target="_blank">Política de Privacidade</a>.
        </p>
        <div class="cookie-buttons">
            <button onclick="acceptCookies()" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Aceitar Todos
            </button>
            <button onclick="acceptEssential()" class="btn btn-secondary">
                <i class="bi bi-shield-check"></i> Apenas Essenciais
            </button>
            <button onclick="togglePreferences()" class="btn btn-outline-primary">
                <i class="bi bi-gear"></i> Configurar
            </button>
        </div>
        
        <!-- Preferências Detalhadas -->
        <div id="cookiePreferences" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <h6>Preferências de Cookies</h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="essentialCookies" checked disabled>
                <label class="form-check-label" for="essentialCookies">
                    <strong>Cookies Essenciais</strong> (Obrigatórios)<br>
                    <small>Necessários para o funcionamento básico do site</small>
                </label>
            </div>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="analyticsCookies" checked>
                <label class="form-check-label" for="analyticsCookies">
                    <strong>Cookies de Analytics</strong><br>
                    <small>Nos ajudam a entender como você usa o site (Google Analytics)</small>
                </label>
            </div>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="adsCookies" checked>
                <label class="form-check-label" for="adsCookies">
                    <strong>Cookies de Publicidade</strong><br>
                    <small>Permitem exibir anúncios personalizados e medir eficácia</small>
                </label>
            </div>
            <button onclick="savePreferences()" class="btn btn-primary mt-3">
                <i class="bi bi-save"></i> Salvar Preferências
            </button>
        </div>
    </div>
</div>

<style>
.cookie-consent {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
    padding: 20px;
    z-index: 99999;
    border-top: 4px solid #0d6efd;
    max-height: 80vh;
    overflow-y: auto;
}

.cookie-content {
    max-width: 1200px;
    margin: 0 auto;
}

.cookie-content p {
    margin-bottom: 15px;
    line-height: 1.6;
}

.cookie-content a {
    color: #0d6efd;
    text-decoration: underline;
}

.cookie-buttons {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.cookie-buttons .btn {
    padding: 10px 20px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .cookie-consent {
        padding: 15px;
    }
    
    .cookie-buttons {
        flex-direction: column;
    }
    
    .cookie-buttons .btn {
        width: 100%;
    }
}
</style>

<script>
// Verificar se já deu consentimento
window.addEventListener('load', function() {
    if (!getCookie('cookie_consent')) {
        setTimeout(function() {
            document.getElementById('cookieConsent').style.display = 'block';
        }, 1000); // Mostrar após 1 segundo
    } else {
        loadTrackingScripts();
    }
});

function togglePreferences() {
    const prefs = document.getElementById('cookiePreferences');
    prefs.style.display = prefs.style.display === 'none' ? 'block' : 'none';
}

function acceptCookies() {
    setCookie('cookie_consent', 'all', 365);
    setCookie('analytics_consent', 'true', 365);
    setCookie('ads_consent', 'true', 365);
    setCookie('functional_consent', 'true', 365);
    document.getElementById('cookieConsent').style.display = 'none';
    loadTrackingScripts();
    
    // Mostrar notificação
    showNotification('✅ Todas as preferências de cookies foram aceitas!');
}

function acceptEssential() {
    setCookie('cookie_consent', 'essential', 365);
    setCookie('analytics_consent', 'false', 365);
    setCookie('ads_consent', 'false', 365);
    setCookie('functional_consent', 'false', 365);
    document.getElementById('cookieConsent').style.display = 'none';
    
    showNotification('✅ Apenas cookies essenciais foram aceitos.');
}

function savePreferences() {
    const analytics = document.getElementById('analyticsCookies').checked;
    const ads = document.getElementById('adsCookies').checked;
    
    setCookie('cookie_consent', 'custom', 365);
    setCookie('analytics_consent', analytics ? 'true' : 'false', 365);
    setCookie('ads_consent', ads ? 'true' : 'false', 365);
    setCookie('functional_consent', 'true', 365);
    
    document.getElementById('cookieConsent').style.display = 'none';
    
    if (analytics || ads) {
        loadTrackingScripts();
    }
    
    showNotification('✅ Suas preferências foram salvas!');
}

function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    const secure = window.location.protocol === 'https:' ? '; Secure' : '';
    document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/" + secure + "; SameSite=Lax";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function loadTrackingScripts() {
    // Carregar Google Analytics
    if (getCookie('analytics_consent') === 'true') {
        loadGoogleAnalytics();
    }
    
    // Carregar scripts de anúncios
    if (getCookie('ads_consent') === 'true') {
        loadAdScripts();
    }
}

function loadGoogleAnalytics() {
    // Substituir com seu ID do Google Analytics
    const GA_ID = 'G-XXXXXXXXXX'; // CONFIGURAR!
    
    const gaScript = document.createElement('script');
    gaScript.async = true;
    gaScript.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
    document.head.appendChild(gaScript);
    
    gaScript.onload = function() {
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', GA_ID, {
            'anonymize_ip': true,
            'cookie_flags': 'SameSite=None;Secure'
        });
    };
}

function loadAdScripts() {
    // Google AdSense
    const ADSENSE_CLIENT = 'ca-pub-XXXXXXXXXXXXXXXX'; // CONFIGURAR!
    
    const adsenseScript = document.createElement('script');
    adsenseScript.async = true;
    adsenseScript.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' + ADSENSE_CLIENT;
    adsenseScript.crossOrigin = 'anonymous';
    document.head.appendChild(adsenseScript);
}

function showNotification(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 15px 25px;
        border-radius: 5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 100000;
        animation: slideIn 0.3s ease-out;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Animações
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
