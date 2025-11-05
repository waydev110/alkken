
<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'autoload.php';
class classMail{
    private $Host = 'mail.luhazahura99.com';
    private $Username = 'notification@luhazahura99.com';
    private $Name = 'luhazahura99.com';
    private $Password = 'indonesia2020';
    

	public function sendEmail($email_penerima, $subject, $isi_pesan){
        //Create an instance; passing `true` enables exceptions
        if(!$this->validateEmail($email_penerima)){
            return false;
        }
        
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->Host;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->Username;                     //SMTP username
            $mail->Password   = $this->Password;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = "UTF-8";

            //Recipients
            $mail->setFrom($mail->Username, $this->Name);
            $mail->addAddress($email_penerima, '');     
            // Add a recipient
            // $mail->addAddress('ellen@example.com');               
            // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $isi_pesan;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            if($mail->send()){
                return true;
            } else {
                return false;
            }
            // echo 'Message has been sent';
        } catch (Exception $e) {
            return false;
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
	}
    

    private function validateEmail($email) {
        // Menggunakan filter_var untuk validasi sederhana
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}

?>