<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);
ini_set('display_errors', 0);

// db:africand_smartrev
// user:africand_sr
// pass: Raven254#$

$servername = "localhost";
$username = "africand_sr";
$password = "Raven254#$";
$dbname = "africand_smartrev";

$mpesastate = 0;

// $conn = mysqli_connect($servername,$username,$password,$dbname);
$conn = mysqli_connect("localhost","africand_sr","Raven254#$","africand_smartrev");



// Check connection
if (!$conn) {
    //Return a success response to m-pesa
    $response = array(
        'ResultCode' => 1,
        'ResultDesc' => 'Fail'
    );
    echo json_encode($response);
    die("Connection failed: " . mysqli_connect_error());
}

$callbackJSONData=file_get_contents('php://input');
$callbackData=json_decode($callbackJSONData);

$resultCode=$callbackData->Body->stkCallback->ResultCode;
$resultDesc=$callbackData->Body->stkCallback->ResultDesc;

$merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
$checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;
$amount = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$mpesaReceiptNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$transactionDate = $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
$phoneNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;
$FinalPhoneNumber = substr($phoneNumber, 3);



// $merchantRequestID = "21097-12914299-1";
// $amount = 4;
// $phoneNumber = 254704003701;
// $FinalPhoneNumber =  substr($phoneNumber, 3);
// $resultCode = 50;

// }else{
//           $mpesastate = 2;
//           $sql55 = "UPDATE orders SET ProState = '3'  WHERE id = '$isOrderID'";
//          if(mysqli_query($conn, $sql55)){} else{}
//         //   echo "55";
//       }

 if($resultCode == 0){
      $sql33 = "SELECT * FROM orders WHERE ProState = '0' && MerchantRequestID = '$merchantRequestID' && amountPaid = '$amount' &&  UserPhoneNumber = '$FinalPhoneNumber'";
      $result33 = mysqli_query($conn,$sql33);
      $info = mysqli_fetch_array( $result33 );
      $count33 = mysqli_num_rows($result33);
      $isOrderID = $info["id"];
      
      if($count33 == 1) {
          $mpesastate = 1;
          $sql44 = "UPDATE orders SET MpesaState = '1'  WHERE id = '$isOrderID'";
          if(mysqli_query($conn, $sql44)){} else{}

      }
          
      }else{
              $mpesastate = 3;
              
              $sql44 = "SELECT * FROM orders WHERE ProState = '0' && MerchantRequestID = '$merchantRequestID' ";
              $result44 = mysqli_query($conn,$sql44);
              $info44 = mysqli_fetch_array( $result44);
              $count44 = mysqli_num_rows($result44);
              $isOrderID44 = $info44["id"];
              if($count44 == 1) {
                    $sql44 = "UPDATE orders SET ProState = '4'  WHERE id = '$isOrderID44'";
                    if(mysqli_query($conn, $sql44)){} else{}
              }
      }


$sql="INSERT INTO mpesa (resultCode, resultDesc, merchantRequestID,   checkoutRequestID,   amount,   mpesaReceiptNumber, transactionDate,   phoneNumber, state) VALUES 
                    ('$resultCode', '$resultDesc',  '$merchantRequestID', '$checkoutRequestID', '$amount', '$mpesaReceiptNumber', '$transactionDate', '$FinalPhoneNumber', '$mpesastate')";

mysqli_query($conn,$sql);

// //Return a success response to m-pesa
// $response = array(
//     'ResultCode' => 0,
//     'ResultDesc' => 'Success'
// );
// echo json_encode($response);


mysqli_close($conn);



?>
