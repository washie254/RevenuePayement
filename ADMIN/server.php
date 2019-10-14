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
	$db = mysqli_connect('localhost', 'root', '', 'dkut_revenue_system');

	// REGISTER USER
	if (isset($_POST['reg_admin'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$verified = 0 ;

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($phone)) { array_push($errors, "Phone is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($firstname)) { array_push($errors, "First name is required"); }
        if (empty($lastname)) { array_push($errors, "Lastname is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

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
			 $query = "INSERT INTO admin (username, firstname, lastname, mobile_number, email, password ) 
					  VALUES('$username','$firstname','$lastname','$phone','$email','$password')";
			 mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	// ... 

	// LOGIN USER
	if (isset($_POST['login_admin'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		
		if (empty($username)) { array_push($errors, "username is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }


		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
        }
    }


	//ADD A STAFF MEMBER 
	if (isset($_POST['add_staff'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		$category = mysqli_real_escape_string($db, $_POST['category']);
		$taskdescription = mysqli_real_escape_string($db, $_POST['taskdescription']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$status = 'ACTIVE' ;

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($phone)) { array_push($errors, "Phone is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($firstname)) { array_push($errors, "First name is required"); }
		if (empty($lastname)) { array_push($errors, "Lastname is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }
		if (empty($taskdescription)) { array_push($errors, "Insert Some task description"); }

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
			$query = "INSERT INTO staff (username, firstname, lastname, email, phone, category, description, password, status) 
					  VALUES('$username','$firstname', '$lastname',	'$email', '$phone', '$category','$taskdescription', '$password','$status')";
			$res = mysqli_query($db, $query);
			if($res){
				echo "Data Updated Successfly";
			}else{
				echo "dinsnt excecute";
			}

			
			header('location: addstaff.php');
		}

	}

?>