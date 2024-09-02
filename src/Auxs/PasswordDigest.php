<?php

namespace Cirel\LaravelBasicsAuxs\Auxs;

use Exception;
use Illuminate\Support\Carbon;

class PasswordDigest
{
    protected string $password;
    protected string $nonce;
    protected string $created;
    protected string $digest;

    /**
     * @param string $password
     * @throws Exception
     */
    public function __construct(string $password)
    {
        $this->password = $password;
        $this->generateNonce();
        $this->generateDate();
    }

    private function generateDate(): void
    {
        $this->created = Carbon::now('UTC')->format('Y-m-d\TH:i:s\Z');
    }

    /**
     * @param int $length
     * @return void
     * @throws Exception
     */
    private function generateNonce(int $length = 16): void
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $nonce = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $nonce .= $characters[random_int(0, $maxIndex)];
        }
        $this->nonce = $nonce;
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $combined_str = $this->nonce . $this->created . $this->password;
        $sha1 = sha1($combined_str, true);
        $this->digest = base64_encode($sha1);
    }

    public function getDigest(): string
    {
        return $this->digest;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function toArray(){
        return [
            'nonce' => $this->nonce,
            'created' => $this->created,
            'digest' => $this->digest
        ];
    }

}
