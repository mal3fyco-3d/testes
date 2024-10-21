//Este ficheiro serve para enviar um email ao utilizador e ao admin quan é feita uma compra e adicionar o pedido do cliente a base de dados
//Se o utilizador nao tiver feito log in vai ver redireçionado para a pagina login.php


<div class="placeorder content-wrapper">
    <h1>O seu pedido foi concluido com sucesso!</h1>
    <p>Obrigado por fazer o seu pedido, vai ser contactado por Email com a confirmação!</p>
</div>
<?php
if (!isset($_SESSION['uid'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

//Função para enviar email para o utilizador quando este realiza uma compra


    use PHPMailer\PHPMailer\PHPMailer;
    function sendmail(){
        $name = "Figures for All";  
        $to = $_SESSION['email'];
        $subject = "O seu pedido esta a caminho";
        $body ='Obrigado Pela sua compra! '. $_SESSION['username'];
        $from = "miguel.f@ua.pt";  
        $password = "#Razer693flay";  

        

        require_once "./objects/PHPMailer.php";
        require_once "./objects/SMTP.php";
        require_once "./objects/Exception.php";
        $mail = new PHPMailer();

    

       
        $mail->isSMTP();
                                  
        $mail->Host = "smtp-servers.ua.pt"; 
        $mail->SMTPAuth = true;
        $mail->Username = $from;
        $mail->Password = $password;
        $mail->Port = 25;  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->smtpConnect([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            ]
        ]);

   
        $mail->isHTML(true);
        $mail->setFrom($from, $name);
        $mail->addAddress($to); 
        $mail->Subject = ("$subject");
        $mail->Body = $body;
        if ($mail->send()) {
            echo "";
        } else {
            echo "Something is wrong: <br><br>" . $mail->ErrorInfo;
        }
    }
//Função para enviar email para o administrador quando é feita uma compra por alguem
    function sendmailadm(){
        $name = "Figures for All";  
        $to = 'miguel.f@ua.pt';
        $subject = "Foi feita uma compra";
        $body = "Foi feito um pedido, verificar pedidos!";
        $from = "miguel.f@ua.pt";  
        $password = "#Razer693flay";  

        

        require_once "./objects/PHPMailer.php";
        require_once "./objects/SMTP.php";
        require_once "./objects/Exception.php";
        $mail = new PHPMailer();

    

       
        $mail->isSMTP();
                                  
        $mail->Host = "smtp-servers.ua.pt"; 
        $mail->SMTPAuth = true;
        $mail->Username = $from;
        $mail->Password = $password;
        $mail->Port = 25;  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->smtpConnect([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            ]
        ]);

   
        $mail->isHTML(true);
        $mail->setFrom($from, $name);
        $mail->addAddress($to); 
        $mail->Subject = ("$subject");
        $mail->Body = $body;
        if ($mail->send()) {
            echo "";
        } else {
            echo "Something is wrong: <br><br>" . $mail->ErrorInfo;
        }
    }
    
    // Carregar e Instanciar Classe
    require_once './objects/Product.php';
    $order = new Order($pdo);

        $state = 'Start';
    
        $errors = false;
      
        if (!$errors) {
            $debug .= '<p>Informação válida proceder ao registo.</p>';
            
            $order->username = $_SESSION['username'];
            $order->total = $_SESSION['subtotal'];
            $order->state = $state;
    
            // Criar pedido
            if ($order->createO()) {
                $html .= 'Pedido criado';
            }else {
                $html .= 'Não foi possível criar pedido';
            }
        }
    

sendmail();
sendmailadm();

//Apagar produtos do carrinho depois de realizar a compra
unset($_SESSION['carrinho']);
?>


