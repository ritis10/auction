<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$name     = "";
$lastname = "";
$address  = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'auction');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$command = "SELECT MAX(id) AS max FROM users";
$rowSQL = mysqli_query($db, $command);
$row = mysqli_fetch_assoc($rowSQL);
$largestid = $row["max"];
$newid = $largestid+1;
// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $address = mysqli_real_escape_string($db, $_POST['address']);
  $date = mysqli_real_escape_string($db, $_POST['date']);
  $category = mysqli_real_escape_string($db, $_POST['category']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Το Username είναι υποχρεωτικό"); }
  if (empty($email))
  {
    array_push($errors, "Το Email είναι υποχρεωτικό");
  }
  else
	{
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
 			$erremail = "Εισάγεται ενα έγκυρο e-mail";
 			$err = true;
		}
	}
  if (empty($name))
  {
    array_push($errors, "Το Βαπτιστικό όνομα είναι υποχρεωτικό");
  }
  else
	{
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z ]*$/",$name))
		{
  			  array_push($errors, "Το Βαπτιστικό όνομα του χρήστη μπορεί να περιέχει μόνο γράμματα και κενά!");
  	}
	}
  if (empty($lastname))
  {
    array_push($errors, "Το Επίθετο είναι υποχρεωτικό");
  }
  else
	{
		$lastname = test_input($_POST["lastname"]);
		if (!preg_match("/^[a-zA-Z ]*$/",$lastname))
		{
  			  array_push($errors, "Το Επίθετο του χρήστη μπορεί να περιέχει μόνο γράμματα και κενά!");
  	}
	}
  if (empty($address)) {array_push($errors, "Η διέυθνση είναι υποχρεωτική"); }
  if (empty($password_1))
  {
    array_push($errors, "Ο κωδικός είναι υποχρεωτικός");
  }
  elseif (strlen($_POST["password_1"]) <= '8')
  {
      array_push($errors, "Ο κωδικός πρέπει να είναι τουλάχιστον 8 ψηφία");
  }
  elseif(!preg_match("#[0-9]+#",$password_1))
  {
    array_push($errors, "Ο κωδικός πρέπει να περιέχει τουλάχιστον έναν αριθμό");
  }
  elseif(!preg_match("#[A-Z]+#",$password_1))
  {
    array_push($errors, "Ο κωδικός πρέπει να περιέχει τουλάχιστον έναν κεφαλαίο γράμμα");
  }
  elseif(!preg_match("#[a-z]+#",$password_1))
  {
    array_push($errors, "Ο κωδικός πρέπει να περιέχει τουλάχιστον έναν μικρό γράμμα");
  }
  if (empty($date)) { array_push($errors, "Η ημερομηνία γέννσης ειναι υποχρεωτική"); }
  if (empty($category)) { array_push($errors, "Η κατηγορία ειναι υποχρεωτική"); }
  if ($password_1 != $password_2)
  {
	array_push($errors, "Οι δύο κωδικοί που εισάγεται δεν είναι οι ίδιοι");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = $password_1;//encrypt the password before saving in the database
    $message="Η εγγραφή σας έγινε ΕΠΙΤΥΧΩΣ!";
  	$query = "INSERT INTO users (status, approval_pom, username, id,  pass, first_name, last_name, role, dob,  address, email )
  			  VALUES('disable', NULL , '$username', '$newid', '$password', '$name', '$lastname', '$category', '$date',  '$address', '$email' )";
  //	mysqli_query($db, $query);
    $result=mysqli_query($db,$query) or die("could not add");
    if($result){
      echo "<title>Successfull registration</title>";
      echo '<script type="text/javascript">';
      echo 'alert("Η εγγραφή σου πραγματοποιήθηκε ΕΠΙΤΥΧΩΣ");';
      echo 'window.location.href = "index.php";';
      echo '</script>';
    }
  }


  }
  function test_input($data)
  {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
