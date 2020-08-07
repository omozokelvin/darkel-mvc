<?php

namespace helpers;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer {

  private $subject = '';
  private $message = '';
  private $address = [];

  public function __construct(string $subject, string $message, array $address = [SITEMAIL => SITE_NAME]) {
    $this->subject = $subject;
    $this->message = $message;
    $this->address = $address;
  }

  public function send() {

    require_once 'includes/PHPMailer/src/PHPMailer.php';
    require_once 'includes/PHPMailer/src/SMTP.php';
    require_once 'includes/PHPMailer/src/Exception.php';

    /* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
    $mail = new PHPMailer(TRUE);

    $mail->isSMTP();
    $mail->CharSet = 'utf-8';
    $mail->SMTPDebug = false;
    $mail->Host = MAILHOST;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = '';
    $mail->Port = MAILPORT;

    $mail->Username = MAILADDRESS;
    $mail->Password = MAILPASSWORD;

    $mail->From = MAILADDRESS;
    $mail->FromName = SITE_NAME;

    //allow us to pass in multiple users as an array
    $counter = 0;
    foreach ($this->address as $email => $name) {
      $counter++;

      if ($counter === 1) {
        $mail->AddAddress($email, $name);
      } else {
        $mail->AddCC($email, $name);
      }
    }

    $mail->IsHTML(true);
    $mail->WordWrap = 50;

    $body = $this->message;

    $mail->Subject = $this->subject;
    $mail->Body = $body;

    $mail->isHTML(true);

    return $mail->send() ? true : false;
  }
}
