<?php
class SecurityService {
    private $algo = "sha256"; // hash algorithm
    private $hash = true; 
    private $salt = "QWEGHDBV$&@BGFND"; // secret key

    public function setCSRFToken() {
        if (empty($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

    public function getCSRFToken() {
        if ($this->hash) {
            return $this->hmac_data($_SESSION["csrf_token"]);
        }
        return $_SESSION["csrf_token"];
    }

    private function hmac_data($data) {
        return hash_hmac($this->algo, $data, $this->salt); 
    }

    public function validate_token($token) {
        if (empty($_SESSION["csrf_token"])) {
            return false;
        }

        if ($this->hash) {
            $token_hash = $this->hmac_data($_SESSION["csrf_token"]);
            return hash_equals($token_hash, $token);
        } else {
            return hash_equals($_SESSION["csrf_token"], $token);
        }
    }
}
