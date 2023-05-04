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
    public function getIv() {
        return $this->iv;
    }
    public function getKey() {
        return $this->key;
    }
    //Данная функция генерирует ключ
    public function generateKey() {
        //передаём в переменную сгенерированные байты
        $bytes = openssl_random_pseudo_bytes(40);
        //преобразуем в двоичные байты в шестнадцатиричные
        $hex = bin2hex($bytes);
        $this->key = $hex;
        //возвращаем получившийся ключ
        return $hex;
    }
    
    //Данная функция производит шифрование текста при помощи
    //ключа и вектора инициализации
    public function AesEncrypt() {
        //Генерируем вектор инициализации при помощи генерации
        //Переводим вектор инициализации в base64
        $this->iv = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher)));
        //передаём в openssl_encrypt сообщение, вид шифра, ключ и вектор инициализации
        $this->encrypted = openssl_encrypt($this->message, $this->cipher, $this->key, $options=0, $this->iv);
        
        return $this->encrypted;
    }

    public function AesDecrypt($encrypted, $key, $iv) {
        //при помощи openssl_decrypt дешифруем и возвращаем результат
        $decrypted = openssl_decrypt($encrypted, $this->cipher, $key, $options=0, $iv);

        return $decrypted;
    }

    public function AesEncryptFile() {
        $file = file_get_contents('text_files/aes/aes_file.txt');

        $this->iv = base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher)));
        $this->encrypted = openssl_encrypt($file, $this->cipher, $this->key, $options=0, $this->iv);
        file_put_contents('text_files/aes/aes_file.txt', $this->encrypted);
    }

    public function AesDecryptFile($key, $iv) {
        $file = file_get_contents('text_files/aes/aes_enc_file.txt');
        $decrypted = openssl_decrypt($file, $this->cipher, $key, $options=0, $iv);
        $this->message = $decrypted;
        file_put_contents('text_files/aes/aes_decrypt_file.txt', $decrypted);
    }
}

?>