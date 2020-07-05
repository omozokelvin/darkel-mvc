<?php

namespace helpers;

class Security {
  private $encrypt_method = "AES-256-CBC";
  private  $secret_key = '12345';
  private  $secret_iv = '1';

  /*********Encryption of data***************/
  public function encrypt(string $string) {
    $output = false;
    // hash
    $key = hash('sha256', $this->secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
    $output = openssl_encrypt($string, $this->encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;
  }

  /**********Decryption of data*************/
  public function decrypt(string $string) {
    $output = false;
    // hash
    $key = hash('sha256', $this->secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $iv);

    return $output;
  }

  // Encrypt password
  public function passwordEncrypt($data): string {
    $options = ['cost' => 10,];
    $password = password_hash($data, PASSWORD_BCRYPT, $options);
    return $password;
  }

  public function VerifyPassword($password, $dbPassword): bool {
    return password_verify($password, $dbPassword);
  }
}
