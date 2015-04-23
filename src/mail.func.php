<?php
/**
 * Work with emails.
 * 
 * @package fast-code-php
 * @subpackage mail
 * @category functions
 */
/**
 * Send mail. 
 * 
 * @param string    $to
 * @param string    $title
 * @param string    $message
 * @return boolean
 */
function mailSend($from, $to, $title, $message) {
    
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';

    $mail->AddReplyTo($to);
    $mail->AddAddress($from);

    $mail->Subject = $title;
    $mail->Body = $message;

    return $mail->Send();
}
