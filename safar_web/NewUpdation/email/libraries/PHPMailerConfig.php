<?php
require APPPATH . 'libraries/src/Exception.php';
require APPPATH . 'libraries/src/PHPMailer.php';
require APPPATH . 'libraries/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PHPMailerConfig {
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'pranjal.pandit900@gmail.com'; // Your SMTP username
        $this->mail->Password = 'tbjydxlgeerxkdxd'; // Your SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
        $this->mail->Port = 587; // SMTP port
        $this->mail->setFrom('ramdevlodhi8815@gmail.com', 'IPS'); // Sender's email and name
    }
    public function  load()
    {
         require_once APPPATG.'third_party/phpmailer/Exception.php';
         require_once APPPATG.'third_party/phpmailer/PHPMailer.php';
         require_once APPPATG.'third_party/phpmailer/SMTP.php';

         $mail=new PHPMailer(true);
         return $mail;
    } 
    
    public function sendEmail($recipientEmail, $recipientName, $subject, $body) {
        try {
            $this->mail->addBCC($recipientEmail, $recipientName);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->send();
          
            return true; // Email sent successfully
        } catch (Exception $e) {
           
            return 'Email could not be sent. Error: ' . $this->mail->ErrorInfo;
        }
    }
  
}