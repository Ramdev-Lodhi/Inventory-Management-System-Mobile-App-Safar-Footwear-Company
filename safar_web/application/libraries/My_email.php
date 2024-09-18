<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class My_email {
    protected $CI;

    public function __construct() {
        // Get the CodeIgniter instance
        $this->CI =& get_instance();
        log_message('debug', 'My_email library loaded');
    }

    public function send_mail($recipient,$sub,$message) {
        // Load the PHPMailer library
        $this->CI->load->library('phpmailer_lib');
        $mail = $this->CI->phpmailer_lib->load();

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@safarfootware.com';
            $mail->Password = 'Safar!@#xxx123';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('info@safarfootware.com', 'Safar Footware');
            $mail->addAddress($recipient);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $sub;
            $mail->Body = $message;
            $mail->AltBody = 'Material Required';

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
