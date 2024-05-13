<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends ApiResponseController
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                // dd($user);
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;

                return $this->sendSuccess($success, 'User login successfully.');
            } else {
                return $this->sendError('Wrong Credentials.', ['error' => 'Wrong Credentials']);
            }
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error' => $e->getMessage()]);
        }

    }
    public function relogin(){
        return $this->sendError('404', ['error' => '404']);
    }

}
