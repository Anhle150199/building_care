<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AccessToken extends Model
{
    use HasFactory,SoftDeletes;
    public $table = "personal_access_tokens";

    public static function getToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    // public function createActivation($user)
    // {

    //     $activation = $this->getActivation($user);

    //     if (!$activation) {
    //         return $this->createToken($user);
    //     }
    //     return $this->regenerateToken($user);

    // }

    private function regenerateToken($user)
    {

        $token = $this->getToken();
        AccessToken::where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => now()
        ]);
        return $token;
    }

    // uid: user_id, namne: name of token, $type:ENUM('admin', 'customer')
    public static function createToken($uid, $name, $type)
    {
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));
        while (AccessToken::where('token', $token)->count() != 0) {
            $token = hash_hmac('sha256', Str::random(40), config('app.key'));
        }
        AccessToken::insert([
            'tokenable_type'=> $type,
            'tokenable_id' => $uid,
            'name'=>$name,
            'token' => $token,
            'created_at' => now()
        ]);
        return $token;
    }


}
