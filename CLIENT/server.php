<?php 
	session_start();

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";
	$cdate =date("y-m-d");
	$ctime = date("h:i:s");
	

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'revenue_system');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$street = mysqli_real_escape_string($db, $_POST['street']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$verified = 0 ;
		$emver = 0 ;


		// form validation: ensure that the form is correctly filled
        if (empty($firstname)) { array_push($errors, "First name is required"); }
        if (empty($lastname)) { array_push($errors, "Lastname is required"); }
		if (empty($street)) { array_push($errors, "Select A street"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }
		if (empty($email)) { array_push($errors, "Email is"); }

		// form validation: ensure that the form is correctly filled
		function validate_phone_number($phone)
		{
			// Allow +, - and . in phone number
			$filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
			// Remove "-" from number
			$phone_to_check = str_replace("-", "", $filtered_phone_number);
			// Check the lenght of number
			// This can be customized if you want phone number from a specific country
			if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
			return false;
			} else {
			return true;
			}
		}
		//VALIDATE PHONE NUMBER 
		if (validate_phone_number($phone) !=true) {
			array_push($errors, "Invalid phone number");
		}

		if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			//$username = strtoupper($username);
			// $status = "PENDING";
			 $query = "INSERT INTO member (firstname, lastname, mobile_number, verified, password,email,emailverification, street) 
					  VALUES('$firstname','$lastname','$phone','$verified','$password','$email','$emver','$street')";
			 mysqli_query($db, $query);

			$_SESSION['username'] = $phone;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	// ... 

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		// form validation: ensure that the form is correctly filled
		function validate_phone_number($phone)
		{
			// Allow +, - and . in phone number
			$filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
			// Remove "-" from number
			$phone_to_check = str_replace("-", "", $filtered_phone_number);
			// Check the lenght of number
			// This can be customized if you want phone number from a specific country
			if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
			return false;
			} else {
			return true;
			}
		}
		//VALIDATE PHONE NUMBER 
		if (validate_phone_number($phone) !=true) {
			array_push($errors, "Invalid phone number");
		}
		
		if (empty($password)) { array_push($errors, "Password is required"); }


		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM member WHERE mobile_number='$phone' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $phone;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong phone number/password combination");
			}
        }
    }


?>