<?php 
    namespace App\Traits;

    use function PHPUnit\Framework\isNull;

    trait ResponseTrait
    {

        public function responseWhitToken($token,$expires,$route)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $expires,
                'route' => $route
            ]);
        }

        public function responseError($message, $httpCode = 500){
            return response()->json([
                'error' => $message,
            ],$httpCode);
        }

        public function responseOk($message,$data=null){
            $answer = [
                "message" => $message
            ];
            if($data!==null) { $answer['data']=$data; }
            return response()->json($answer,200);
        }
    }

