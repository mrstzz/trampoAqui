<?php
namespace Classes;

class EncryptionHelper
{
    private const CIPHER = 'aes-256-cbc';
    private static $key;

    /**
     * Pega a chave do .env
     */
    private static function getKey(): string
    {
        if (self::$key === null) {
            // Assume que o .env já foi carregado pela classe Conexao ou similar
            self::$key = $_ENV['CHAT_ENCRYPTION_KEY'] ?? null;
            if (empty(self::$key)) {
                throw new \Exception("CHAT_ENCRYPTION_KEY não definida no .env");
            }
        }
        return self::$key;
    }

    /**
     * Criptografa o texto
     */
    public static function encrypt(string $plaintext): string
    {
        $key = self::getKey();
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivlen); // IV único para cada msg
        
        $ciphertext_raw = openssl_encrypt($plaintext, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
        
        // Retorna o IV + Mensagem, codificado em base64
        return base64_encode($iv . $ciphertext_raw);
    }

    /**
     * Descriptografa o texto
     */
    public static function decrypt(string $base64_data): ?string
    {
        $key = self::getKey();
        $data = base64_decode($base64_data);
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        
        $iv = substr($data, 0, $ivlen);
        $ciphertext_raw = substr($data, $ivlen);
        
        $plaintext = openssl_decrypt($ciphertext_raw, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);

        return $plaintext ?: null; // Retorna null se a descriptografia falhar
    }
}