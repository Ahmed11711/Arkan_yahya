<?php

namespace App\Http\Controllers\Api\CreateTron;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CReateTRonController extends Controller
{
    public function store(Request $request)
    {

       
            $walletData = [
            'address' => $request['address'],
            'private_key' => $request['private_key'],
            'public_key' => $request['public_key'],
            'phrase' => $request['phrase'],
              ];
            $this->encryptData($walletData, 'A_141516141516');
 
    }

    private function encryptData(array $walletData,  string $password)
    {
        $plaintext = json_encode($walletData);

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

        $encrypted = [
            'ciphertext' => base64_encode($ciphertext),
            'salt' => base64_encode($salt),
            'nonce' => base64_encode($nonce)
        ];

        DB::table('user_trons')->insert([
            'user_id' => 0,
            'address' => $walletData['address'] ?? null,
            'encrypted_payload' => json_encode($encrypted),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    private function decryptData($password): ?array
    {
        $record = DB::table('user_trons')->where('user_id', 0)->first();

        if (!$record || !$record->encrypted_payload) {
            return null;
        }

        $encrypted = json_decode($record->encrypted_payload, true);

        // فك التشفير
        $salt = base64_decode($encrypted['salt']);
        $nonce = base64_decode($encrypted['nonce']);
        $ciphertext = base64_decode($encrypted['ciphertext']);

        $key = sodium_crypto_pwhash(
            SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

        $plaintext = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, '', $nonce, $key);
        sodium_memzero($key);

        if ($plaintext === false) {
            return null;
        }

        return json_decode($plaintext, true);
    }


     public function decryptDataAhmed($user_id): ?array
    {
        $password='A_141516141516';
         $record = DB::table('user_trons')->where('user_id', $user_id)->first();

         if (!$record || !$record->encrypted_payload) {
            return null;
        }
        // $ssl={"ciphertext":"QWZBMsGjfdxaWeNjquPcQN2fxbb+PBgrKX3mfm+v+zhwLcrBhjdc5snaxn+YKcQi+eDTbwPjJmf8VNijWRm+z7Fangjm9iHOezlmqkNMu6agiZx6CjwiRuCqXaq3+0FbQicH4j503kWDThmQSPtVhDZQusRoOKznijCsL+tKDyY44trE1tc7Grtq0UFOj\/Qnc5biEt91KF0hxVKA50Nsr+kiZZtcFInHLboU7kjRRKnXyjyhWVowjFU45QPyqUYuQ\/FcfoT++UN\/orgDJR1sJh7yFx\/SPPkbTtKejPhqN3Jt7Z8SteRexS7aSF8iqfraVjlTaxP8LtZD8Oxv+xbX30ufgGmLF9H9qT54yJ+vcCNgdMgMe58oZfPsqIKdwxngKkb21GPe09tKQEQqCRrUzlOppzEcJiP1DOHK4DSxRw8wxPq9OiCPFVXi+mlNlShegzFTsyyWEYKkwy0htC5wbzKf8MXP49fYEfgA46IwowBR2skrdGhVxTmfaYY1JA==","salt":"123A2p4Cgz\/T6Iwqtii9Lw==","nonce":"zK169Zk04c7EI8oqpetoK3WqGUzbKKO8"};

        $encrypted = json_decode($record->encrypted_payload, true);

        // فك التشفير
        $salt = base64_decode($encrypted['salt']);
        $nonce = base64_decode($encrypted['nonce']);
        $ciphertext = base64_decode($encrypted['ciphertext']);

        $key = sodium_crypto_pwhash(
            SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
            $password,
            $salt,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

        $plaintext = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, '', $nonce, $key);
        sodium_memzero($key);

        if ($plaintext === false) {
            return null;
        }

        return json_decode($plaintext, true);
    }

}
