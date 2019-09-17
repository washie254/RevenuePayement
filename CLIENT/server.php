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
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
        if (empty($firstname)) { array_push($errors, "First name is required"); }
        if (empty($lastname)) { array_push($errors, "Lastname is required"); }
		if (empty($street)) { array_push($errors, "Select A street"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			//$username = strtoupper($username);
			// $status = "PENDING";
			 $query = "INSERT INTO member (firstname, lastname, verification_code, verified, password, street) 
					  VALUES('$username', '$email', '$password')";
			// mysqli_query($db, $query);

			// $query2 = "INSERT INTO clearance (student_reg, cod, librarian, housekeeper, dean_of_students, sports_officer, registrar, finance) 
			// 		  		VALUES('$username', '$status', '$status','$status', '$status','$status', '$status','$status')";
			// mysqli_query($db, $query2);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	// ... 

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
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


?>