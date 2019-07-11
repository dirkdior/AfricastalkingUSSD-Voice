<?php
include 'makeACall.php';

$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

//Break down the incoming text into an array to determine what level the User is on the USSD flow
$steps = explode("*", $text);

$count = count($steps);

if ($text == "") {
    $response = "CON Welcome\n";
    $response .= "1. View Stockprice\n";
    $response .= "2. Portfolio Balance\n";
    $response .= "3. Sell Order\n";
    $response .= "4. Buy Order\n";
    $response .= "5. Help";

} else if($count == 1) {

    if ($steps[0] == "1") 
        $response = "CON Enter Stock Symbol";
    
    else if($steps[0] == "2") {

        date_default_timezone_set('Africa/Lagos');
        $date = date('d-m-Y');

        $randAmount = rand(4000, 100000);

        $response = "END Your balance at ". $date ." is ". $randAmount . "NGN";
    
    } else if($steps[0] == "3")
        $response = "CON What Stock would you like to sell";

      else if($steps[0] == "4")
        $response = "CON What Stock would you like to buy";

      else if($steps[0] == 5) {
        $response = "END Please expect a call from us shortly. \nThanks!";
        //Make a phone call via Voice API

        makeACall($phoneNumber);

    } else 
        $response = "END Invalid Input. \nPlease try again.";
    

} else if($count == 2) {
    
    if($steps[0] == "1") {

        $randAmount = rand(10, 100) / 10;

        $response = "END The stock price of ". strtoupper($steps[1]) . " as at today is \nNGN " . $randAmount;

    } else if($steps[0] == "3")
        $response = "CON What price do you wish to sell this stock";

      else if($steps[0] == "4") 
        $response = "CON At what price do you wish to buy this stock";  
      else
        $response = "END Invalid Input";
    
} else if($count == 3) {

    if($steps[0] == "3") {

        $stock = $steps[1];
        $price = $steps[2];

        $response = "CON Please confirm the details\n";
        $response .= "Stock Name: ". strtoupper($stock);
        $response .= "\nFor sale at: NGN ". $price;
        $response .= "\n1. Confirm";

    } else if($steps[0] == "3") {

        $stock = $steps[1];
        $price = $steps[2];

        $response = "CON Please confirm the details\n";
        $response .= "Stock Name: ". strtoupper($stock);
        $response .= "\nTo buy at: NGN ". $price;
        $response .= "\n1. Confirm";

    }

} else if($count == 4) {

    if($steps[0] == "3")
        $response = "END Your sale was Successful!";

    else if($steps[0] == "4") 
        $response = "END Your stock was successfully purchased!";

    else
        $response = "END Invalid Input";
}

header('Content-type: text/plain');
echo $response;