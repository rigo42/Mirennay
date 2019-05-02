<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'controlador/Exception.php';
require 'controlador/PHPMailer.php';
require 'controlador/SMTP.php';

/**
 * Autor Rigoberto Villa
 */

class enviarCorreoControlador{
	
	function __construct(){
		# code...
	}

	public function enviarCorreo($correo,$asunto,$mensaje){
        
			// Instantiation and passing `true` enables exceptions
 			$mail = new PHPMailer(true);
 			$mail->CharSet = "UTF-8";

			try {
			    //Server settings
			    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
			    $mail->isSMTP();                                            // Set mailer to use SMTP
			    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail->Username   = "rigoberto.villa42@gmail.com";                     // SMTP username
			    $mail->Password   = 'terribibibi';                               // SMTP password
			    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
			    $mail->Port       = 587;                                    // TCP port to connect to

			    //Recipients
			    $mail->setFrom("rigobero.villa42@gmail.com", "MIRENNAY");
			    $mail->addAddress($correo);

			    // Attachments
			    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = $asunto;
			    $mail->Body    = $mensaje;
			    
			   	if(!$mail->send()) {
	                return false;
	                echo "Ocurrio un error: ".$mail->ErrorInfo;
	            } else {
	                return true;
	            }
	        } catch (Exception $e) {
	            return false;
	            // echo 'Message could not be sent.';
	            echo 'Mailer Error: ' . $mail->ErrorInfo;
	        }
	}

}
 ?>
