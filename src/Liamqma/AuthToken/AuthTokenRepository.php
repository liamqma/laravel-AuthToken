<?php

namespace Liamqma\AuthToken;

class AuthTokenRepository {

    public function purge($userId, $userTable) {
        \DB::table('AuthToken')->where('user_id', '=', $userId)->where('user_table', '=', $userTable)->delete();
    }

    public function store($userId, $userTable, $publicKey, $privateKey) {
        \DB::table('AuthToken')->insert(
                array('user_id' => $userId, 'user_table' => $userTable, 'public_key'=>$publicKey, 'private_key'=>$privateKey,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s') )
        );
    }

    public function getOrFail($userId, $publicKey, $userTable) {
                $result = \DB::table('AuthToken')
                        ->where('user_id','=',$userId)
                        ->where('public_key','=',$publicKey)
                        ->where('user_table','=',$userTable)
                        ->first();
                if($result)
                    return $result->user_id;
                else
                    return false;
    }

}
