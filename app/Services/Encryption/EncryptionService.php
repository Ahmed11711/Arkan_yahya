<?php
namespace App\Services;

class EncryptionService
{
     public static function encryptWithPassword(string $plaintext, string $password): array
    {
         $salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);

         $key = sodium_crypto_pwhash(
            SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

         $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);

         $ciphertext = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($plaintext, '', $nonce, $key);

         sodium_memzero($key);

        return [
            'salt' => base64_encode($salt),
            'nonce' => base64_encode($nonce),
            'ciphertext' => base64_encode($ciphertext),
            'version' => 1 // احتياطي لتغييرات مستقبلية في الصيغة
        ];
    }

     public static function decryptWithPassword(array $stored, string $password): ?string
    {
        if (!isset($stored['salt'], $stored['nonce'], $stored['ciphertext'])) {
            return null;
        }

        $salt = base64_decode($stored['salt']);
        $nonce = base64_decode($stored['nonce']);
        $ciphertext = base64_decode($stored['ciphertext']);

        // اشتقاق المفتاح بنفس الإعدادات
        $key = sodium_crypto_pwhash(
            SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

        // محاولة فك التشفير
        $plaintext = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, '', $nonce, $key);

        // مسح المفتاح
        sodium_memzero($key);

        if ($plaintext === false) {
            return null; // كلمة السر خاطئة أو البيانات تالفة
        }

        return $plaintext;
    }
}
