<?php

namespace App\Services;

class SMSService
{
    public function send($number, $message)
    {
        $ch = curl_init();

        $params = [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => $number,
            'message' => $message,
            'sendername' => env('SEMAPHORE_SENDER', 'SEMAPHORE'),
        ];

        curl_setopt($ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
