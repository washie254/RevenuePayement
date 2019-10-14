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

	// LOGIN USER
	if (isset($_POST['login_staff'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		
		if (empty($username)) { array_push($errors, "username is required"); }
		if (empty($password)) { array_push($errors, "Password is required"); }


		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM staff WHERE username='$username' AND password='$password'";
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