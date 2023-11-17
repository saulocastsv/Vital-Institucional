<?php
error_reporting(E_ERROR | E_PARSE);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Inicia a classe PHPMailer
$email = new PHPMailer();

 // DEFINIÇÃO DOS DADOS DE AUTENTICAÇÃO - Você deve alterar conforme o seu domínio!
 $email->IsSMTP(); // Define que a mensagem será SMTP
 $email->Host = "smtpi.kinghost.net"; // Seu endereço de host SMTP
 $email->SMTPAuth = true; // Define que será utilizada a autenticação -  Mantenha o valor "true"
 $email->Port = 587; // Porta de comunicação SMTP - Mantenha o valor "587"
 $email->SMTPSecure = false; // Define se é utilizado SSL/TLS - Mantenha o valor "false"
 $email->SMTPAutoTLS = true; // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"
 
 $email->Username = 'site@vitalscheffer.com.br'; // Conta de email existente e ativa em seu domínio
 $email->Password = 'cp@fOglco'; // Senha da sua conta de email


//==================================================== 

// DADOS DO REMETENTE
$email->Sender = "site@vitalscheffer.com.br"; // Conta de email existente e ativa em seu domínio
$email->From = "site@vitalscheffer.com.br"; // Sua conta de email que será remetente da mensagem
$email->FromName = "Vital Scheffer"; // Nome da conta de email


//==================================================== 
$emailreceiver = $_POST['emailreceiver'];

// DADOS DO DESTINATÁRIO
$email->AddAddress($emailreceiver);
// $email->AddAddress('informatica01@vitalscheffer.com.br');

$email->AddBCC('marketing03@vitalscheffer.com.br'); // Define qual conta de email receberá uma cópia


function converte($palavra) {
    $palavra = str_replace("à", "&agrave;", $palavra);
    $palavra = str_replace("À", "&Agrave;", $palavra);
    $palavra = str_replace("á", "&aacute;", $palavra);
    $palavra = str_replace("Á", "&Aacute;", $palavra);
    $palavra = str_replace("â", "&acirc;", $palavra);
    $palavra = str_replace("Â", "&Acirc;", $palavra);
    $palavra = str_replace("ã", "&atilde;", $palavra);
    $palavra = str_replace("Ã", "&Atilde;", $palavra);
    $palavra = str_replace("ç", "&ccedil;", $palavra);
    $palavra = str_replace("Ç", "&Ccedil;", $palavra);
    $palavra = str_replace("é", "&eacute;", $palavra);
    $palavra = str_replace("É", "&Eacute;", $palavra);
    $palavra = str_replace("ê", "&ecirc;", $palavra);
    $palavra = str_replace("Ê", "&Ecirc;", $palavra);
    $palavra = str_replace("ì", "&igrave;", $palavra);
    $palavra = str_replace("Ì", "&Igrave;", $palavra);
    $palavra = str_replace("í", "&iacute;", $palavra);
    $palavra = str_replace("Í", "&Iacute;", $palavra);
    $palavra = str_replace("ò", "&ograve;", $palavra);
    $palavra = str_replace("Ò", "&Ograve;", $palavra);
    $palavra = str_replace("ó", "&oacute;", $palavra);
    $palavra = str_replace("Ó", "&Oacute;", $palavra);
    $palavra = str_replace("ô", "&ocirc;", $palavra);
    $palavra = str_replace("Ô", "&Ocirc;", $palavra);
    $palavra = str_replace("õ", "&otilde;", $palavra);
    $palavra = str_replace("Õ", "&Otilde;", $palavra);
    $palavra = str_replace("ẽ", "&etilde;", $palavra);
    $palavra = str_replace("Ẽ", "&Etilde;", $palavra);
    return $palavra;
}

// Função criada como alternativa a converte().
// Retira todas os acentos da lingua portuguesa.
function replace($palavra) {
    $search = explode(",", "à,á,â,ã,ä,ç,è,é,ê,ë,ì,í,î,ï,ñ,ò,ó,ô,õ,ö,ù,ú,û,ü,ý,ÿ,"
            . "À,Á,Â,Ã,Ä,Ç,È,É,Ê,Ë,Ì,Í,Î,Ï,Ñ,Ò,Ó,Ô,Õ,Ö,Ù,Ú,Û,Ü,Ý");
    $replace = explode(",", "a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,"
            . "A,A,A,A,A,C,E,E,E,E,I,I,I,I,N,O,O,O,O,O,U,U,U,U,Y");
    $palavra = str_replace($search, $replace, $palavra);
    return $palavra;
}

//==================================================== 


try{
    $uploadDirectory = 'uploads/'; // Directory to store uploaded files
    $uploadedFile = $_FILES['file']['name'];
    $tempFile = $_FILES['file']['tmp_name'];
    $uploadPath = $uploadDirectory . $uploadedFile;

    move_uploaded_file($tempFile, $uploadPath);

    $email->addAttachment('./uploads/'.$_FILES['file']['name'], $_FILES['file']['name']);

}catch (Exception $e) {
}

$name = $_POST['name'];
$e_mail = $_POST['email'];
$phone = $_POST['phone'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$subjectArr = array (
    "orcamento"  =>  "Orçamento",
    "duvida"  =>  "Dúvida",
    "vagadeemprego"  => "Vaga de Emprego"
);

$email->IsHTML(true); // Define que o e-mail será enviado como HTML
$email->CharSet = 'utf-8'; // Charset da mensagem (opcional)
$email->Subject = "Email Site Vital Scheffer";
$email->Body .= "<h2>Envio de email do site principal da Vital Scheffer.</h2>";
$email->Body .= "<div>Nome: $name</div>";
$email->Body .= "<div>Email: $e_mail</div>";
$email->Body .= "<div>Telefone: $phone</div>";
$email->Body .= "<div>Assunto: ". $subjectArr[$subject] ."</div>";
$email->Body .= "<div>Mensagem: $message</div>";

if($email->Send()) {

    $data = "ok";

    header("Content-Type: application/json");

    echo json_encode($data);
} 
else {
    echo "Error: ";
}   

?>


