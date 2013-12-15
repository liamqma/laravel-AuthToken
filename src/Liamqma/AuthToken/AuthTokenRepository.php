<?php

namespace Liamqma\AuthToken;

class AuthTokenRepository {

    public function purge($userId, $userTable) {
        \DB::table('AuthToken')->where('user_id', '=', $userId)->where('user_table', '=', $userTable)->delete();
    }

    public function store($userId, $userTable, $publicKey, $privateKey) {
        \DB::table('AuthToken')->insert(
                array('user_id' => $userId, 'user_table' => $userTable, 'public_key'=>$publicKey, 'private_key'=>$privateKey)
        );
    }

    public function getOrFail($userId, $publicKey, $userTable) {
                $result = \DB::table('AuthToken')->insert(
                array('user_id' => $userId, 'public_key'=>$publicKey, 'user_table' => $userTable) 
        )->first();
                if($result)
                    return $result->user_id;
                else
                    return false;
    }

}
