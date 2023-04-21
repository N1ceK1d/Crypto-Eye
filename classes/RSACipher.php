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
        var_export($this->publicKey);
    }

    public function getPrivateKey() {
        var_export($this->privateKey);
    }

    public function RSAEncrypt($message, $publicKey) {
        openssl_public_encrypt($message, $encrypted, $publicKey);
        var_export(base64_encode($encrypted));
    }

    public function RSADecrypt($str, $privatekey) {
        openssl_private_decrypt(base64_decode($str), $decrypted, $privatekey);
        var_export($decrypted);
    }
}

?>