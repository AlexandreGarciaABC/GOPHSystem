<?php
require_once('mail/class.phpmailer.php'); //chama a classe de onde você a colocou.
require_once('mail/class.smtp.php'); //chama a classe de onde você a colocou.

$mail = new PHPMailer(); // instancia a classe PHPMailer

$mail->IsSMTP();

//configuração do gmail
$mail->Port = '587'; //porta usada pelo gmail.
$mail->Host = 'smtp.gmail.com'; 
$mail->IsHTML(true); 
$mail->Mailer = 'smtp';
$mail->SMTPSecure = 'tls';

//configuração do usuário do gmail
$mail->SMTPAuth = true; 
$mail->Username = 'xxxxxxxxx@gmail.com'; // usuario gmail.   
$mail->Password = 'xxxxxxx'; // senha do email.

// configuração do email a ver enviado.
$mail->From = "xxxxxx@gmail.com"; 
$mail->FromName = "XXX xX"; 

$mail->addAddress("XXXXXXXX@gmail.com"); // email do destinatario.

$mail->Subject = "Aqui vai o assunto do email, pode vim atraves de variavel."; 
$mail->Body = "Aqui vai a mensagem, que tambem pode vim por variavel.";

if(!$mail->Send())
    echo "Erro ao enviar Email:" . $mail->ErrorInfo;
?>
