<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;

trait TwilioSMS {

    public function SendSMS( $mobile, $msg ) : void
    {
        $account_sid = env( 'TWILIO_ACCOUNT_SID' );
        $auth_token = env( 'TWILIO_AUTH_TOKEN' );
        $twilio_number =  env( 'TWILIO_PHONE_NUMBER' );

        $client = new Client( $account_sid, $auth_token );

        $client->messages->create(
            $mobile,
            array(
                'from' => $twilio_number,
                'body' => $msg
            )
        );
    }
}
