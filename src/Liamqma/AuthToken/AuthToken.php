<?php

namespace Liamqma\AuthToken;

use Illuminate\Encryption\Encrypter;

class AuthToken {

    protected $tokenRepo;
    protected $userId;
    protected $hasher;
    protected $encrypter;

    public function __construct(AuthTokenRepository $repo, HashProvider $hasher, Encrypter $encrypter) {
        $this->tokenRepo = $repo;
        $this->hasher = $hasher;
        $this->encrypter = $encrypter;
    }

    public function createToken($userId, $userTable) {
        echo 'aaa';
        $this->setUserId($userId);

        # Purge
        $this->tokenRepo->purge($this->userId, $userTable);

        # Create Keys
        $publicKey = $this->hasher->make();
        $privateKey = $this->hasher->makePrivate($publicKey);

        # Store
        $this->tokenRepo->store($this->userId, $userTable, $publicKey, $privateKey);

        # Return Serialized Token
        $payload = array('id' => $this->userId, 'table' => $userTable, 'key' => $publicKey);
        $token = $this->encrypter->encrypt($payload);
        return $token;
    }

    public function validateToken($token) {
        if ($token == null) {
            return false;
        }

        try {
            $data = $this->encrypter->decrypt($token);
        } catch (DecryptException $e) {
            return false;
        }
        if (empty($data['id']) || empty($data['key']) || empty($data['table'])) {
            return false;
        }
        
        $userId = $this->tokenRepo->getOrFail($data['id'],$data['key'],$data['table']);
        
        if($userId == false)
            return false;

        $this->setUserId($userId);
        
        return true;
        
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getUserId() {
        return $this->userId;
    }

}
