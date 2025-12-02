<?php
// Sistema de rastreamento e anúncios
require_once 'ad-manager.php';
require_once 'adsterra-helper.php';

// Rastrear visitante automaticamente
global $adManager;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petição Política - Faça sua voz ser ouvida</title>
    
    <!-- Google Tag Manager (Exemplo) -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
        }
        
        .banner-top {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 30px;
            border: 2px dashed #dee2e6;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .banner-sidebar {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px dashed #dee2e6;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .banner-middle {
            background-color: #f8f9fa;
            padding: 20px;
            margin: 30px 0;
            border: 2px dashed #dee2e6;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }
        
        .about-section {
            padding: 40px 0;
            background-color: #fff;
        }
        
        .petition-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .pix-section {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            margin: 30px 0;
        }
        
        .pix-qrcode {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin: 20px 0;
        }
        
        .image-gallery {
            margin: 40px 0;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .stats-counter {
            background-color: #f8f9fa;
            padding: 40px 0;
            margin: 40px 0;
        }
        
        .stat-box {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        footer {
            background-color: #212529;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    
    <!-- Banner Topo - Adsterra 728x90 -->
    <div class="banner-top">
        <?php renderAdsterraBanner('banner_top'); ?>
    </div>

    <!-- Header/Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Faça sua voz ser ouvida!</h1>
                    <p class="lead">Participe ativamente da mudança que você quer ver. Assine nossa petição e juntos podemos fazer a diferença.</p>
                    <a href="#formulario" class="btn btn-light btn-lg mt-3">
                        <i class="bi bi-pen"></i> Assinar Petição
                    </a>
                </div>
                <div class="col-lg-4">
                    <!-- Banner Lateral 1 - Adsterra 300x250 -->
                    <div class="banner-sidebar bg-white">
                        <?php renderAdsterraBanner('banner_sidebar_1'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contador de Assinaturas -->
    <div class="stats-counter">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-number" id="assinaturas-count">1.247</div>
                        <h5>Assinaturas</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-number" id="compartilhamentos">3.892</div>
                        <h5>Compartilhamentos</h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="stat-number" id="apoiadores">758</div>
                        <h5>Apoiadores</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Seção Sobre -->
        <section class="about-section" id="sobre">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="mb-4">Sobre Nossa Causa</h2>
                    <p class="lead">Esta petição foi criada para dar voz ao povo e promover mudanças reais em nossa sociedade.</p>
                    <p>Acreditamos que a participação ativa dos cidadãos é fundamental para construir um país melhor. Nossa causa busca [DESCREVA AQUI OS OBJETIVOS DA PETIÇÃO].</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4><i class="bi bi-check-circle text-success"></i> Nossos Objetivos</h4>
                            <ul>
                                <li>Promover transparência política</li>
                                <li>Defender os direitos dos cidadãos</li>
                                <li>Combater a corrupção</li>
                                <li>Melhorar a qualidade de vida</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4><i class="bi bi-people text-primary"></i> Quem Somos</h4>
                            <p>Somos um grupo de cidadãos preocupados com o futuro do nosso país, unidos por valores democráticos e pela vontade de promover mudanças positivas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Banner Lateral 2 - Adsterra 160x600 -->
                    <div class="banner-sidebar">
                        <?php renderAdsterraBanner('banner_sidebar_2'); ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Banner Meio 1 - Adsterra 468x60 -->
        <div class="banner-middle">
            <?php renderAdsterraBanner('banner_middle_1'); ?>
        </div>

        <!-- Galeria de Imagens -->
        <section class="image-gallery" id="galeria">
            <h2 class="text-center mb-5">Galeria de Imagens</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="https://via.placeholder.com/400x300/667eea/ffffff?text=Imagem+1" alt="Evento 1">
                        <div class="p-3 bg-light">
                            <h5>Manifestação Popular</h5>
                            <p class="mb-0 text-muted">Cidadãos unidos pela causa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="https://via.placeholder.com/400x300/764ba2/ffffff?text=Imagem+2" alt="Evento 2">
                        <div class="p-3 bg-light">
                            <h5>Entrega de Assinaturas</h5>
                            <p class="mb-0 text-muted">Momento histórico</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gallery-item">
                        <img src="https://via.placeholder.com/400x300/11998e/ffffff?text=Imagem+3" alt="Evento 3">
                        <div class="p-3 bg-light">
                            <h5>Mobilização Nacional</h5>
                            <p class="mb-0 text-muted">Em todo o país</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Upload de Imagens -->
            <div class="mt-4 p-4 bg-light rounded">
                <h4><i class="bi bi-cloud-upload"></i> Compartilhe suas Fotos</h4>
                <p>Participou de algum evento? Compartilhe suas fotos conosco!</p>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="file" class="form-control" name="imagem" accept="image/*" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-upload"></i> Enviar Foto
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Formulário de Petição -->
        <section id="formulario" class="mb-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="petition-form">
                        <h2 class="mb-4"><i class="bi bi-pen-fill text-primary"></i> Assine a Petição</h2>
                        
                        <?php
                        if(isset($_GET['success']) && $_GET['success'] == 1) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle"></i> <strong>Obrigado!</strong> Sua assinatura foi registrada com sucesso!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                  </div>';
                        }
                        ?>
                        
                        <form action="processar_peticao.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nome" class="form-label">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">E-mail *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cpf" class="form-label">CPF *</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label">Telefone *</label>
                                    <input type="tel" class="form-control" id="telefone" name="telefone" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="cidade" class="form-label">Cidade *</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="estado" class="form-label">Estado *</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="">Selecione...</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Por que você apoia esta causa? (Opcional)</label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="4" placeholder="Compartilhe sua motivação..."></textarea>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" value="1">
                                <label class="form-check-label" for="newsletter">
                                    Quero receber atualizações sobre esta causa
                                </label>
                            </div>
                            
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="termos" name="termos" required>
                                <label class="form-check-label" for="termos">
                                    Concordo com os termos de uso e política de privacidade *
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-send"></i> Assinar Petição
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Banner Lateral 3 - Adsterra 160x300 -->
                    <div class="banner-sidebar">
                        <?php renderAdsterraBanner('banner_sidebar_3'); ?>
                    </div>
                    
                    <!-- Banner Lateral 4 - Adsterra 300x250 -->
                    <div class="banner-sidebar">
                        <?php renderAdsterraBanner('banner_sidebar_4'); ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção PIX -->
        <section class="pix-section" id="apoiar">
            <h2 class="mb-4"><i class="bi bi-heart-fill"></i> Apoie Nossa Causa</h2>
            <p class="lead">Sua contribuição nos ajuda a ampliar o alcance desta petição e promover mudanças reais!</p>
            
            <div class="row mt-5">
                <div class="col-md-6 mb-4">
                    <div class="pix-qrcode">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=00020126580014br.gov.bcb.pix0136sua-chave-pix-aqui@email.com520400005303986540510.005802BR5925Seu Nome Aqui6009SAO PAULO62070503***6304XXXX" alt="QR Code PIX">
                        <p class="text-dark mt-3 mb-0"><strong>Escaneie o QR Code</strong></p>
                    </div>
                </div>
                <div class="col-md-6 text-start">
                    <h4 class="mb-3">Como Doar via PIX:</h4>
                    <ol class="fs-5">
                        <li>Abra o app do seu banco</li>
                        <li>Escolha PIX</li>
                        <li>Escaneie o QR Code ou copie a chave</li>
                        <li>Confirme o pagamento</li>
                    </ol>
                    
                    <div class="mt-4 p-3 bg-white bg-opacity-25 rounded">
                        <p class="mb-2"><strong>Chave PIX:</strong></p>
                        <div class="input-group">
                            <input type="text" class="form-control" value="sua-chave-pix@email.com" id="chavePix" readonly>
                            <button class="btn btn-light" onclick="copiarChavePix()">
                                <i class="bi bi-clipboard"></i> Copiar
                            </button>
                        </div>
                    </div>
                    
                    <p class="mt-4 small">
                        <i class="bi bi-shield-check"></i> Todas as doações são seguras e utilizadas exclusivamente para promover nossa causa.
                    </p>
                </div>
            </div>
            
            <!-- Valores sugeridos -->
            <div class="mt-4">
                <h5 class="mb-3">Valores Sugeridos:</h5>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-light btn-lg">R$ 10</button>
                    <button type="button" class="btn btn-light btn-lg">R$ 25</button>
                    <button type="button" class="btn btn-light btn-lg">R$ 50</button>
                    <button type="button" class="btn btn-light btn-lg">R$ 100</button>
                    <button type="button" class="btn btn-light btn-lg">Outro valor</button>
                </div>
            </div>
        </section>

        <!-- Banner Rodapé - Adsterra 728x90 -->
        <div class="banner-middle">
            <?php renderAdsterraBanner('banner_middle_2'); ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Sobre o Projeto</h5>
                    <p>Uma iniciativa cidadã para promover mudanças através da participação democrática.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="#sobre" class="text-white text-decoration-none">Sobre</a></li>
                        <li><a href="#formulario" class="text-white text-decoration-none">Assinar Petição</a></li>
                        <li><a href="#apoiar" class="text-white text-decoration-none">Apoiar</a></li>
                        <li><a href="#galeria" class="text-white text-decoration-none">Galeria</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Compartilhe</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white fs-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-3"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Petição Política. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Máscara CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        });

        // Máscara Telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                e.target.value = value;
            }
        });

        // Copiar chave PIX
        function copiarChavePix() {
            const chavePix = document.getElementById('chavePix');
            chavePix.select();
            document.execCommand('copy');
            alert('Chave PIX copiada!');
        }

        // Animação dos contadores
        function animateCounter(id, target) {
            let current = 0;
            const increment = target / 100;
            const element = document.getElementById(id);
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target.toLocaleString('pt-BR');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString('pt-BR');
                }
            }, 20);
        }

        // Iniciar animação ao carregar
        window.addEventListener('load', () => {
            animateCounter('assinaturas-count', 1247);
            animateCounter('compartilhamentos', 3892);
            animateCounter('apoiadores', 758);
        });
    </script>
    
    <?php
    // Popunder Adsterra (carrega após consentimento)
    renderAdsterraPopunder();
    
    // Incluir banner de consentimento de cookies (LGPD)
    include_once 'cookie-consent.php';
    ?>
</body>
</html>
