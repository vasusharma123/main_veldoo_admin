<?php

namespace App\Http\Controllers;

use App\Setting;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Twilio\Rest\Client;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    protected function validationErrorResponse($errors)
    {
        $response = [
            'statusCode' => 422,
            // 'errors' => $errors,
            // 'message' => 'Unprocessable entity'
            'message' => $errors
        ];
        return $this->returnResponse($response);
    }

    protected function  serverErrorResponse()
    {
        $response = [
            'statusCode' => 500,
            'message' => 'Unable to process your request. Please try again later or contact to the administrator.'
        ];
        return $this->returnResponse($response);
    }

    protected function successResponse($data, $message = '')
    {
        $response = [
            'statusCode' => 200,
            'data' => $data,
            'message' => $message
        ];
        return $this->returnResponse($response);
    }

    protected function notFoundResponse($message)
    {
        $response = [
            'statusCode' => 422,
            'message' => $message
            // 'errors' => [$message],
            // 'message' => 'Unprocessable entity'
        ];
        return $this->returnResponse($response);
    }

    protected function notAuthorizedResponse($message)
    {
        $response = [
            'statusCode' => 401,
            'message' => $message
        ];
        return $this->returnResponse($response);
    }

    public function returnResponse($response)
    {
        return response()->json($response, $response['statusCode']);
    }

    public function sendTextMessage($recipientPhoneNumber, $textMessage)
    {
        try {
            $twilioDetailArr = \Config::get('services.twilio');

            $client = new Client($twilioDetailArr['sid'], $twilioDetailArr['auth_token']);
            $client->messages->create($recipientPhoneNumber, ['from' => $twilioDetailArr['number'], 'body' => $textMessage]);
        } catch (Exception $ex) {
            \Log::info($ex->getMessage());
        }
    }

    public function sendSMS($recipientCountryCode, $recipientPhoneNumber, $textMessage)
    {
        try {
            $twilioDetailArr = \Config::get('services.twilio');
            if ($recipientCountryCode == "+41") {
                $sender = "Taxi2000";
            } else {
                $sender = $twilioDetailArr['number'];
            }
            $client = new Client($twilioDetailArr['sid'], $twilioDetailArr['auth_token']);
            $client->messages->create($recipientCountryCode . $recipientPhoneNumber, ['from' => $sender, 'body' => $textMessage]);
        } catch (Exception $ex) {
            \Log::info($ex->getMessage());
        }
    }

    protected function phone_number_trim($phone_number, $country_code = null)
    {
        $phone_number = str_replace(' ', '', ltrim($phone_number, "0"));
        if (!empty($country_code) && str_contains($phone_number, "+" . $country_code)) {
            $phone_number = str_replace("+" . $country_code, '', $phone_number);
        }
        return $phone_number;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $checkToken = User::where(['random_token'=>$randomString])->first();
        if ($checkToken) 
        {
            return $this->generateRandomString($length);
        }
        return $randomString;
    }

    function createUrlSlug($urlString)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $urlString);
        $checkSlug = Setting::where(['slug'=>$slug])->first();
        if ($checkSlug) 
        {
            return $this->createUrlSlug($slug.rand(1,9));
        }
        return $slug;
    }
}
