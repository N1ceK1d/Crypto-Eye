<?php
class RSACipher {
    private $publicKey;
    private $privatekey;

    public function generateKeys() {
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        
        //Создать публичный и приватный ключ
        $res = openssl_pkey_new($config);

        // Извлекаем закрытый ключ из $res в $privKey
        openssl_pkey_export($res, $privKey);
        $this->privateKey = &$privKey;

        // Извлечение открытого ключа из $res в $pubKey
        $this->publicKey = openssl_pkey_get_details($res);
        $this->publicKey = $this->publicKey["key"];
    }

    public function getPublicKey() {
        //генерируем и возвращаем публичный ключ
        $pubKey = var_export($this->publicKey, true);
        return $pubKey;
    }

    public function getPrivateKey() {
        //генерирует приватный ключ
        $privKey = var_export($this->privateKey, true);
        return $privKey;
    }

    public function RSAEncrypt($message, $publicKey) {
        //При помощи публичного ключа шифруем сообщение
        openssl_public_encrypt($message, $encrypted, $publicKey);
        $rsa_encrypt = var_export(base64_encode($encrypted), true);
        return $rsa_encrypt;
    }

    public function RSADecrypt($str, $privatekey) {
        //При помощи приватного ключа дешифруем сообщение
        openssl_private_decrypt(base64_decode($str), $decrypted, $privatekey);
        $rsa_decrypt = var_export($decrypted, true);
        return $rsa_decrypt;
    }
}

?>