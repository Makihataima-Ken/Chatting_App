<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\auth\StatefulGuard;
use illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class LogsController extends Controller
{
        /**
     * Handle an incoming Login request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request):JsonResponse
    {
        $isvalid=$request->isValidCredential();

        if(!$isvalid['success']){
            return $this->error($isvalid['message'],HttpFoundationResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $user=$isvalid['user'];
        $token=$user->createToken(User::USER_TOKEN);

        return $this->success([
            'user'=>$user,
            'token'=>$token->plainTextToken,
        ],'Logged in successfully');
    }
    /**
     * validate user's credential.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function isValidCredential(LoginRequest $request):array
    {
            $data=$request->validated();
            $user=User::where('email',$data['email'])->first();
            if($user==null){
                return['success'=>false,'message'=>'invalid credentials'];
            }

            if(Hash::check($data['password'],$user->password)){
                return['success'=>1,'user'=>$user];
            }

            return['success'=>false,'message'=>'invalid password'];
    }

    /**
     * log in with a token.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginWithToken():JsonResponse
    {
        return $this->success(auth()->user(),'logged in successfully');
    }

    /**
     * log out function
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request):JsonResponse
    {
        $request->user()->currentAccessToken->delete();
        return $this->success(null,'logged out successfully');
    }
}
