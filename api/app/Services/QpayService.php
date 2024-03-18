<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class QpayService
{
    public function handle($user, $reference, $amount)
    {
        $payload = [
            "em" => $user->email,
            "fn" => $user->first_name,
            "ln" => $user->last_name,
            "am" => $amount,
            "pn" => $user->phone,
            "scode" => config("qpay.scode").$reference
        ];

        return $this->generatePaymentToken($payload);
    }
    
    public function generatePaymentToken($payload)
    {
        try{
            $response = Http::withoutVerifying()->get(config('qpay.url')."/edrum/".json_encode($payload));

            if(! $response->ok())
                $response->throw();
                
            $response = $response->json();

            if(! isset($response['ResponseCode']) || ! isset($response['ResponseEncrypted'])){
                return [
                    "statusCode" => "01",
                ];
            }

            if($response['ResponseCode'] != "00"){
                return [
                    "statusCode" => "01",
                ];
            }

            return [
                "statusCode" => "00",
                "data" => [
                    "url" => config('qpay.url')."/odrum/".$response['ResponseEncrypted']
                ]
            ];
            
        }catch(Throwable $th){
            logger($th);
            return [
                "statusCode" => "01",
            ];
        }
    }    
}