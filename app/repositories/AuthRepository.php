<?php

namespace App\repositories;
use App\Interfaces\AuthInterface;
use App\Mail\OtpCodeMail;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthRepository implements AuthInterface
{
    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user)
            return false;

        if (!Hash::check($data['password'], $user->password)) {
            return false;
        }
        $user->tokens()->delete();
        
        $user->token = $user->createToken($user->id)->plainTextToken;

        return $user;
    }

    public function register(array $data)
    {
        return User::create($data);
    }

    public function forgottenPassword(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        $otpCode = [
            'email' => $data['email'],
            'code' => rand(121111, 989898),
        ];

            OtpCode::where('email', $data['email'])->delete();
            OtpCode::create($otpCode);
            session()->put('email', $data['email']);
            Mail::to($data['email'])->send(new OtpCodeMail($user->name, $otpCode['code']));

        return $user;
    }

    public function checkOtpCode(array $data)
    {
        $code = OtpCode::where('email', $data['email'])->first();

        if(!$code)
            return false;

        if (Hash::check($data['code'], $code['code'])) {

            $user = User::where('email', $data['email'])->first();
            $user->update(['is_confirmed' => true]);

            $code->delete();

            $user->token = $user->createToken($user->id)->plainTextToken;
            return $user;
        }

        return false;
    }

    public function newPassword(array $data)
    {
        
    }

}
