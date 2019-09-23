
<html>
<title>Verification form</title>
<!-- Display status message -->
<?php echo !empty($statusMsg)?'<p class="'.$statusMsg['status'].'">'.$statusMsg['msg'].'</p>':''; ?>

<!-- OTP Verification form -->
<form method="post">
    <label>Enter Mobile No</label>
    <input type="text" name="mobile_no" value="<?php echo !empty($recipient_no)?$recipient_no:''; ?>" <?php echo ($otpDisplay == 1)?'readonly':''; ?>/>
    
    <?php if($otpDisplay == 1){ ?>
    <label>Enter OTP</label>
    <input type="text" name="otp_code"/>
    <a href="javascript:void(0);" class="resend">Resend OTP</a>
    <?php } ?>
    <input type="submit" name="<?php echo ($otpDisplay == 1)?'submit_otp':'submit_mobile'; ?>" value="VERIFY"/>
</form>
</html>