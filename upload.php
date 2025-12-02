<?php
// Configurações de upload
$uploadDir = 'uploads/galeria/';
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxFileSize = 5 * 1024 * 1024; // 5MB

// Criar diretório se não existir
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem'])) {
    
    $file = $_FILES['imagem'];
    
    // Validar erros de upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header('Location: index.php?error=1&msg=Erro no upload do arquivo');
        exit;
    }
    
    // Validar tipo de arquivo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        header('Location: index.php?error=1&msg=Tipo de arquivo não permitido. Use JPG, PNG, GIF ou WEBP');
        exit;
    }
    
    // Validar tamanho
    if ($file['size'] > $maxFileSize) {
        header('Location: index.php?error=1&msg=Arquivo muito grande. Máximo 5MB');
        exit;
    }
    
    // Gerar nome único
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFilename = uniqid('img_') . '_' . time() . '.' . $extension;
    $destination = $uploadDir . $newFilename;
    
    // Mover arquivo
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        
        // Opcional: Salvar informação no banco de dados
        /*
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=peticao_db", "root", "");
            $stmt = $pdo->prepare("INSERT INTO galeria (filename, upload_date) VALUES (?, NOW())");
            $stmt->execute([$newFilename]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar imagem no BD: " . $e->getMessage());
        }
        */
        
        header('Location: index.php?success=1&msg=Imagem enviada com sucesso!#galeria');
        exit;
    } else {
        header('Location: index.php?error=1&msg=Erro ao salvar arquivo');
        exit;
    }
    
} else {
    header('Location: index.php');
    exit;
}
