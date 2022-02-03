<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Helpers\RequestRules;
use App\Helpers\HttpStatusCodes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Authentication extends Controller{

    public $userModel;

    public function __construct(User $userModel){
        $this->userModel = $userModel;
    }

    public function Login(Request $request){

        try {
            $params = $request->all();
            $validator =  Validator::make($request->all(), RequestRules::getRule('LOGIN'));

            if($validator->fails()) {
                return $this->error($validator->getMessageBag()->all(), HttpStatusCodes::UNPROCESSABLE_ENTITY);
            }

            // Validate the email address
            $userDetails = $this->userModel->getUser($params['email']);
            if($userDetails === false){
                return $this->error("Wrong Login Credentials", HttpStatusCodes::UNAUTHORIZED);
            }

            // Validate Password
            if(!Hash::check($params['password'], $userDetails->password)) {
                return $this->error("Wrong Login Credentials", HttpStatusCodes::UNAUTHORIZED);
            }

            $token = $this->JwtIssuer($userDetails);
            unset($userDetails['password']);
            $msg = "Login Successful";
            $userDetails['token'] = $token;
            return $this->success($msg, HttpStatusCodes::OK, $userDetails);

        } catch(\Exception $e){
            return $this->error("Exception: " .$e->getMessage(), HttpStatusCodes::SERVER_ERROR);
        }


    }



}



