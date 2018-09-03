<?php
/**
 * Created by PhpStorm.
 * User: burhan
 * Date: 9/3/18
 * Time: 2:50 PM
 */
namespace App\helper;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserHandler{
    public static function UserRegistration($request){
        try{
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
            return ['status' => true,'message' => 'User Created Successfully'];
        }catch (\Exception $e){
            return ['status' => false,'message' => 'User Created Successfully'];
        }
    }
    public static function UserLoginHandler($request){
        $email = $request['email'];
        $password = $request['password'];
        $oUser = User::where('email',$email)->first();
        if(!empty($oUser)) {
            $validCredentials = Hash::check($password, $oUser->password);
            if ($validCredentials) {
                return $oUser->toArray();
            }
        }
        return false;
    }
}