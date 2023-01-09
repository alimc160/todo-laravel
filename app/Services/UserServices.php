<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use App\Notifications\EmailVerificationNotification;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    use ApiResponseTrait;
    /**
     * @var UserInterface
     */
    private $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $requestData
     * @return array
     * @throws \Exception
     */
    public function createUser($requestData)
    {
        $verificationCode  = random_int(100000, 999999);
        $user = $this->userRepository->createUser([
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'password' => Hash::make($requestData['password']),
            'otp' => $verificationCode
        ]);
        $user->notify(new EmailVerificationNotification($verificationCode));
       return [
           'name' => $user->name,
           'email' => $user->email,
       ];
    }

    public function verifyUserOTP($requestData)
    {
        $user = $this->userRepository->getUser(
            [
                'email'=>$requestData['email'],
                'otp' => $requestData['otp']
            ]
        );
        if (!$user){
           $this->errorResponse(400,'OTP did not matched!');
        }
        return $this->userRepository->updateUser($user->id,[
            'otp' => null,
            'is_verified' => 1
        ]);
    }
}
