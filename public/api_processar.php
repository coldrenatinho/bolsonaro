<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'peticao_db';
$username = 'root';
$password = '';

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validar dados
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $termos = isset($_POST['termos']) ? 1 : 0;
    
    // Validações básicas
    if (!$nome || !$email || !$cpf || !$telefone || !$cidade || !$estado || !$termos) {
        header('Location: index.php?error=1&msg=Preencha todos os campos obrigatórios');
        exit;
    }
    
    // Validar CPF
    if (strlen($cpf) != 11) {
        header('Location: index.php?error=1&msg=CPF inválido');
        exit;
    }
    
    try {
        // Conectar ao banco de dados
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verificar se CPF já existe
        $stmt = $pdo->prepare("SELECT id FROM assinaturas WHERE cpf = ?");
        $stmt->execute([$cpf]);
        
        if ($stmt->rowCount() > 0) {
            header('Location: index.php?error=1&msg=Este CPF já assinou a petição');
            exit;
        }
        
        // Inserir assinatura
        $sql = "INSERT INTO assinaturas (nome, email, cpf, telefone, cidade, estado, mensagem, newsletter, data_assinatura, ip_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nome,
            $email,
            $cpf,
            $telefone,
            $cidade,
            $estado,
            $mensagem,
            $newsletter,
            $_SERVER['REMOTE_ADDR']
        ]);
        
        // Enviar email de confirmação (opcional)
        $assunto = "Obrigado por assinar nossa petição!";
        $corpo = "Olá $nome,\n\nObrigado por assinar nossa petição e apoiar nossa causa!\n\nJuntos faremos a diferença.\n\nAtenciosamente,\nEquipe da Petição";
        $headers = "From: noreply@peticao.com.br\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // mail($email, $assunto, $corpo, $headers);
        
        // Redirecionar com sucesso
        header('Location: index.php?success=1#formulario');
        exit;
        
    } catch (PDOException $e) {
        // Log do erro (em produção, não mostre o erro real)
        error_log("Erro no banco de dados: " . $e->getMessage());
        header('Location: index.php?error=1&msg=Erro ao processar assinatura. Tente novamente.');
        exit;
    }
    
} else {
    header('Location: index.php');
    exit;
}
