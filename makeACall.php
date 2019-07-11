<?php
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;

//Accept phone number parameter
function makeACall($phoneNumber) {
    //Set your credentials 
    $username = "";
    $apiKey   = "";

    $AT       = new AfricasTalking($username, $apiKey);

    $voice    = $AT->voice();

    //Set your registered Virtual Number
    $from     = "";

    $to       = $phoneNumber;

    try {
        // Make the call
        $results = $voice->call([
            'from' => $from,
            'to'   => $to
        ]);

        //print_r($results);
    } catch (Exception $e) {
        //echo "Error: ".$e->getMessage();
    }
}