<?php 

class AESCipher {

    private $message;
    private $cipher = "AES-192-CBC";
    private $iv;
    private $key;

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getKey() {
        return $this->key;
    }

    public function generateKey() {
        $bytes = openssl_random_pseudo_bytes(40);
        $hex = bin2hex($bytes);
        $this->key = $hex;

        return $hex;
    }

    public function getIv() {
        return $this->iv;
    }

    public function AesEncrypt() {
        $this->iv = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher)));
        $this->encrypted = openssl_encrypt($this->message, $this->cipher, $this->key, $options=0, $this->iv);
        
        return $this->encrypted;
    }

    public function AesDecrypt($encrypted, $key, $iv) {
        $decrypted = openssl_decrypt($encrypted, $this->cipher, $key, $options=0, $iv);

        return $decrypted;
    }

    public function AesEncryptFile() {
        $file = file_get_contents('text_files/aes_file.txt');

        $this->iv = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher)));
        $this->encrypted = openssl_encrypt($file, $this->cipher, $this->key, $options=0, $this->iv);

        file_put_contents('text_files/aes_file.txt', $this->encrypted);
    }

    public function AesDecryptFile($key, $iv) {
        $file = file_get_contents('text_files/aes_enc_file.txt');
        $decrypted = openssl_decrypt($file, $this->cipher, $key, $options=0, $iv);
        $this->message = $decrypted;
        file_put_contents('text_files/aes_decrypt_file.txt', $decrypted);
    }
}

?>