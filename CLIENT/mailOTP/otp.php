<?php
session_start();
if(isset($_POST['save']))
{
$rno=$_SESSION['otp'];
$urno=$_POST['otpvalue'];
if(!strcmp($rno,$urno))
{
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$phone=$_SESSION['phone'];
//For admin if he want to know who is register
$to="example@gmail.com";
$subject = "Thank you!";
$txt = "Some one show your demo Email id: ".$email." Mobile number : ".$phone."";
$headers = "From: studentstutorial@gmail.com" . "\r\n" .
"CC: divyasundarsahu@gmail.com";
mail($to,$subject,$txt,$headers);
echo "<p>Thank you for show our Demo.</p>";

$db = mysqli_connect('localhost', 'root', '', 'revenue_system');
$query = "UPDATE member SET emailverification=1 where email='$email'";
$res= mysqli_query($db, $query);
    if($res){ 
            echo "Record Updated";
            header('location: ../index.php');
    }
    else{
        echo "could not modify the dadtabase";
    }
//For admin if he want to know who is register
}
else{
echo "<p>Invalid OTP</p>";
}
}
//resend OTP
if(isset($_POST['resend']))
{
$message="<p class='w3-text-green'>Sucessfully send OTP to your mail.</p>";
$rno=$_SESSION['otp'];
$to=$_SESSION['email'];
$subject = "OTP";
$txt = "OTP: ".$rno."";
$headers = "From: otp@smartrevenue.com" . "\r\n" .
"CC: otp2@smartrevenue.com";
mail($to,$subject,$txt,$headers);
$message="<p class='w3-text-green w3-center'><b>Sucessfully resend OTP to your mail.</b></p>";
}
?>
<!DOCTYPE html>
<html>
    <header>
    <title>OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <style>
    a{
    text-decoration:none;
    }
    </style>
    <header>
    <body>
        <br>
        <div class="w3-row">
            <div class="w3-half w3-card-2 w3-round">
                <div class="w3-container w3-center w3-green">
                    <h2>OTP</h2>
                </div>
                <br>
                <form class="w3-container" method="post" action="">
                    <br>
                    <br>
                    <p><input class="w3-input w3-border w3-round" type="password" placeholder="OTP" name="otpvalue"></p>
                    <p class="w3-center"><button class="w3-btn w3-green w3-round" style="width:100%;height:40px" name="save">Submit</button></p>
                    <p class="w3-center"><button class="w3-btn w3-green w3-round" style="width:100%;height:40px" name="resend">Resend</button></p>
                </form>
            <div>
            <?php if(isset($message)) { echo $message; } ?>
        </div>
        <br>
        <div class="w3-container w3-center w3-light-grey">
            <h4><a href="studentstutorial.com">Smart Revenue</a></h4>
        </div>
        </div>
        <div class="w3-half">
        </div>
        </div>
    </body>
</html>