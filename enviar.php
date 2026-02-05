<<?php
// --- CONFIGURAÇÃO (SÓ MEXA AQUI) ---
// O email que envia (tem que ser o que você criou na Hostinger)
$email_envio = "contato@gigadesign.site"; 

// O email que RECEBE o aviso (pode ser o seu Gmail pessoal para você ver no celular)
$email_destino = "giga.contato123@gmail.com"; 

$nome_empresa = "Giga Design";

// Verifica se os dados vieram do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recebe e limpa os dados
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email_cliente = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $whatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_STRING);
    $empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);
    $segmento = filter_input(INPUT_POST, 'segmento', FILTER_SANITIZE_STRING);
    $servico = filter_input(INPUT_POST, 'servico', FILTER_SANITIZE_STRING);
    $mensagem_cliente = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

    // --- EMAIL 1: PARA VOCÊ (Aviso de novo orçamento) ---
    $assunto_admin = "Novo Lead: $nome solicitou orçamento!";
    $corpo_admin = "
    <html>
    <body>
        <h2>🚀 Novo Pedido de Orçamento</h2>
        <p><strong>Nome:</strong> $nome</p>
        <p><strong>Email:</strong> $email_cliente</p>
        <p><strong>WhatsApp:</strong> $whatsapp</p>
        <p><strong>Empresa:</strong> $empresa</p>
        <p><strong>Segmento:</strong> $segmento</p>
        <p><strong>Interesse:</strong> $servico</p>
        <p><strong>Mensagem:</strong> $mensagem_cliente</p>
    </body>
    </html>
    ";

    // Headers do Admin
    $headers_admin = "MIME-Version: 1.0" . "\r\n";
    $headers_admin .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers_admin .= "From: Site Giga Design <$email_envio>" . "\r\n"; // Sai do servidor
    $headers_admin .= "Reply-To: $email_cliente" . "\r\n"; // Responder vai pro cliente

    // Envia para o SEU GMAIL
    mail($email_destino, $assunto_admin, $corpo_admin, $headers_admin);

    // --- EMAIL 2: PARA O CLIENTE (Resposta Automática) ---
    $assunto_cliente = "Recebemos sua solicitação - Giga Design";
    $corpo_cliente = "
    <html>
    <body>
        <h2>Olá, $nome! 👋</h2>
        <p>Obrigado por entrar em contato com a <strong>Giga Design</strong>.</p>
        <p>Recebemos seus dados com sucesso. Nossa equipe já está analisando seu perfil e em breve entraremos em contato pelo WhatsApp ou E-mail para apresentar uma proposta personalizada.</p>
        <br>
        <p>Atenciosamente,<br><strong>Equipe Giga Design</strong></p>
    </body>
    </html>
    ";

    // Headers do Cliente
    $headers_cliente = "MIME-Version: 1.0" . "\r\n";
    $headers_cliente .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers_cliente .= "From: $nome_empresa <$email_envio>" . "\r\n"; // Sai do servidor

    // Envia para o CLIENTE
    mail($email_cliente, $assunto_cliente, $corpo_cliente, $headers_cliente);

    echo "sucesso";
} else {
    echo "erro";
}
?>