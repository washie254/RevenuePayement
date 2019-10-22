<?php
// require('includes/config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");


// $obj = json_decode($_GET["phone"],$_GET["amount"],$_GET["order_no"], false);

$phone = 254718610463;
$amount = '5';
$order_no = '92';

mpesaPush($phone, $amount, $order_no );

// $phone = $_POST['phone'];

// function test($phone, $amount, $order_no){
//   echo $phone.''.$amount.''.$order_no;  
// }

function mpesaPush($phone, $amount, $order_no ){

$account_no = 'Book_store-'.$order_no;

//$conn = mysqli_connect("localhost", "ccco_Macheda2", "h@UbMCo0JEa{", "ccco_Macheda2");
$conn = mysqli_connect("localhost","africand_sr","Raven254#$","africand_smartrev");

$access_token=get_accesstoken();

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header

$BusinessShortCode = 174379;
$LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$date = new DateTime();
$timestamp = $date->format('YmdHis');
$password=base64_encode($BusinessShortCode.$LipaNaMpesaPasskey.$timestamp);

$curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $amount,
    'PartyA' => $phone,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $phone,
    'CallBackURL' => 'http://africandles.org/smartrev/CLIENT/mpesa/response.php',
    'AccountReference' => $account_no,
    'TransactionDesc' => 'Testing',
    'InvoiceNumber' => '123456'
);

$data_string = json_encode($curl_post_data);


curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
//  echo $curl_response;
 $someObject = json_decode($curl_response, true);
//  print_r($someObject);      
  
  if($someObject["MerchantRequestID"]){
      $MerchantRequestID = mysqli_real_escape_string($conn, $someObject["MerchantRequestID"]);

        $sql11 = "UPDATE orders SET MerchantRequestID = '$MerchantRequestID'  WHERE id = '$order_no'";
          if(mysqli_query($conn, $sql11)){
             ///
            } else{
             ///
            }
  }elseif($someObject["requestId"]){
  
      $requestId2 = mysqli_real_escape_string($conn, $someObject["requestId"]);
      
        $sql22 = "UPDATE orders SET requestId = '$requestId2'  WHERE id = '$order_no'";
          if(mysqli_query($conn, $sql22)){
             ///
            } else{
             ///
            }
  }
     

}


  function get_accesstoken(){
    $credentials = base64_encode('oWektoerw4nOcArjA56g6AwwBPIrlMYS:kaPsxWSAABcN3dm3');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials, 'Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response);

    $access_token = $response->access_token;

    // The above $access_token expires after an hour, find a way to cache it to minimize requests to the server
    if(!$access_token){
        throw new Exception("Invalid access token generated");
        return FALSE;
    }
    return $access_token;
}
 

?>
