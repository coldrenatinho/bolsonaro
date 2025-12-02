<?php
/**
 * Página de Doação via PIX
 * Gera QR Code dinâmico para doações
 */

require_once 'config.php';

// Valor sugerido ou personalizado
$valorSugerido = isset($_GET['valor']) ? floatval($_GET['valor']) : 0;
$valores = [10, 20, 50, 100, 200, 500];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doe via PIX - <?php echo SITE_NAME; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
            padding: 40px;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .qrcode-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-bottom: 25px;
        }
        
        #qrcode {
            margin: 20px auto;
            display: inline-block;
            border: 3px solid #667eea;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }
        
        .pix-key {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-family: monospace;
            font-size: 14px;
            word-break: break-all;
        }
        
        .copy-button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            transition: all 0.3s;
        }
        
        .copy-button:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        
        .copy-button:active {
            transform: translateY(0);
        }
        
        .valores-sugeridos {
            margin-bottom: 25px;
        }
        
        .valores-sugeridos h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .valores-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        
        .valor-btn {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        
        .valor-btn:hover {
            border-color: #667eea;
            background: #f0f2ff;
        }
        
        .valor-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        .valor-custom {
            margin-top: 15px;
        }
        
        .valor-custom input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
        }
        
        .valor-custom input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .info {
            background: #e7f3ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }
        
        .voltar {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .voltar:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 25px;
            }
            
            .valores-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💚 Doe via PIX</h1>
        <p class="subtitle">Apoie nossa causa</p>
        
        <div class="valores-sugeridos">
            <h3>Escolha um valor:</h3>
            <div class="valores-grid">
                <?php foreach ($valores as $valor): ?>
                    <button class="valor-btn" onclick="selecionarValor(<?php echo $valor; ?>)">
                        R$ <?php echo number_format($valor, 2, ',', '.'); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            
            <div class="valor-custom">
                <input type="number" 
                       id="valorCustom" 
                       placeholder="Ou digite outro valor (R$)"
                       min="1"
                       step="0.01"
                       onchange="atualizarQRCode(this.value)">
            </div>
        </div>
        
        <div class="qrcode-section">
            <h3 style="margin-bottom: 10px;">Escaneie o QR Code</h3>
            <div id="qrcode">
                <img id="qrcodeImg" src="" alt="QR Code PIX" style="display: none;">
                <p id="qrPlaceholder" style="color: #999;">Selecione um valor acima</p>
            </div>
            
            <div style="margin-top: 20px;">
                <strong>Chave PIX:</strong>
                <div class="pix-key" id="pixKey"><?php echo htmlspecialchars(PIX_KEY); ?></div>
                <button class="copy-button" onclick="copiarChavePix()">
                    📋 Copiar Chave PIX
                </button>
            </div>
        </div>
        
        <div class="info">
            <strong>ℹ️ Como doar:</strong><br>
            1. Escolha o valor da doação<br>
            2. Escaneie o QR Code com o app do seu banco<br>
            3. Ou copie a chave PIX e cole no app<br>
            4. Confirme o pagamento
        </div>
        
        <a href="index.php" class="voltar">← Voltar para a petição</a>
    </div>

    <script>
        let valorAtual = <?php echo $valorSugerido > 0 ? $valorSugerido : 0; ?>;
        
        function selecionarValor(valor) {
            valorAtual = valor;
            document.getElementById('valorCustom').value = '';
            
            // Remove active de todos os botões
            document.querySelectorAll('.valor-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Adiciona active no botão clicado
            event.target.classList.add('active');
            
            atualizarQRCode(valor);
        }
        
        function atualizarQRCode(valor) {
            if (!valor || valor <= 0) {
                document.getElementById('qrcodeImg').style.display = 'none';
                document.getElementById('qrPlaceholder').style.display = 'block';
                return;
            }
            
            valorAtual = parseFloat(valor);
            
            // Gerar payload PIX
            const payload = gerarPayloadPix(valorAtual);
            
            // Gerar QR Code
            const qrcodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${encodeURIComponent(payload)}`;
            
            document.getElementById('qrcodeImg').src = qrcodeUrl;
            document.getElementById('qrcodeImg').style.display = 'block';
            document.getElementById('qrPlaceholder').style.display = 'none';
        }
        
        function gerarPayloadPix(valor) {
            const pixKey = '<?php echo addslashes(PIX_KEY); ?>';
            const nome = '<?php echo addslashes(PIX_NAME); ?>';
            const cidade = '<?php echo addslashes(PIX_CITY); ?>';
            const id = '<?php echo addslashes(PIX_IDENTIFICADOR); ?>';
            
            // Formato simplificado do payload PIX
            // Em produção, usar biblioteca específica para gerar payload EMV correto
            let payload = '00020126';
            payload += `${pixKey.length + 14}`.padStart(2, '0') + '0014br.gov.bcb.pix01';
            payload += `${pixKey.length}`.padStart(2, '0') + pixKey;
            payload += '52040000'; // Merchant Category Code
            payload += '5303986'; // Currency (BRL)
            
            if (valor > 0) {
                const valorStr = valor.toFixed(2);
                payload += '54' + `${valorStr.length}`.padStart(2, '0') + valorStr;
            }
            
            payload += '5802BR'; // Country
            payload += '59' + `${nome.length}`.padStart(2, '0') + nome;
            payload += '60' + `${cidade.length}`.padStart(2, '0') + cidade;
            payload += '62' + `${id.length + 4}`.padStart(2, '0') + '05' + `${id.length}`.padStart(2, '0') + id;
            payload += '6304'; // CRC placeholder
            
            return payload;
        }
        
        function copiarChavePix() {
            const pixKey = document.getElementById('pixKey').textContent;
            navigator.clipboard.writeText(pixKey).then(() => {
                const btn = event.target;
                const textOriginal = btn.textContent;
                btn.textContent = '✅ Copiado!';
                btn.style.background = '#28a745';
                
                setTimeout(() => {
                    btn.textContent = textOriginal;
                    btn.style.background = '#667eea';
                }, 2000);
            });
        }
        
        // Se veio com valor na URL, selecionar automaticamente
        <?php if ($valorSugerido > 0): ?>
            atualizarQRCode(<?php echo $valorSugerido; ?>);
        <?php endif; ?>
    </script>
</body>
</html>
