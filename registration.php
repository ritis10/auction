<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
<style>
ul{
list-style-type: none;
margin: 0;
  padding: 0;
overflow: hidden;
background-color: #333;
position: fixed;
top: 0;
width: 100%;
}
li{
    float: left;
}

  li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

 li a:hover:not(.active) {
  background-color: #111;
}
.active {
 background-color: #4CAF50;
}
</style>
  <title>ΕΓΓΡΑΦΗ ΧΡΗΣΤΗ</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <ul>
      <li><a href="guest.php">Προϊόντα</a></li>
      <li><a href="contactus.php">Επικοινωνία</a></li>
      <li><a class="active" href="registration.php">Εγγραφή </a></li>
      <li><a href="index.php">Επιστροφή στο αρχικό μενού</a><li>
  </ul>
  <center>
  <form id = "register" method="post" action="registration.php">
    <p class="title"><b>ΕΓΓΡΑΦΗ ΧΡΗΣΤΗ</b></p>
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <input type="text" name="username" placeholder="Όνομα Χρήστη" value="<?php echo $username; ?>">
  	</div>
  	<div class="input-group">
  	  <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <input type="password" placeholder="Κωδικός" name="password_1">
      <label>(Ο κωδικός πρέπει να περιέχει τουλάχιστον 8 χαρακτήρες, ένα κεφαλαίο γράμμα, ένα μικρό γράμμα και έναν αριθμό!)</label>
  	</div>
  	<div class="input-group">
  	  <input type="password" placeholder="Επιβεβαιώση Κωδικού" name="password_2">
  	</div>
    <div class="input-group">
      <input type="text" name="name" placeholder="Όνομα" value="<?php echo $name; ?>">
    </div>
    <div class="input-group">
      <input type="text" name="lastname" placeholder="Επώνυμο" value="<?php echo $lastname; ?>">
    </div>
    <div class="input-group">
      <input type="text" name="address" placeholder="Διέυθυνση Κατοικίας" value="<?php echo $address; ?>">
    </div>
    <div class="input-group">
      <label>Ημερομηνία Γέννησης</label>
      <input type="date" name="date" value="<?php echo $date; ?>">
    </div>
    <div class="input-group">
        <label><b><u>Επιλέξτε Κατηγορία user</u></b></label>
    <p>
        Eνδιαφερόμενος <input type="radio" name='category' value="buyer">
    </p>
    <p>
        Δημοπράτης <input type="radio" name='category' value="seller">
    </p>
    </div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user" id = "reg">Εγγραφή</button>
  	</div>
  	<p><i>
  	 	 Είσαστε ήδη εγγεγραμμένος;
  	</i></p>
    <p>
       <a href="index.php">Είσοδος σαν μέλος</a>
    </p>
  </form>
  </center>
</body>
</html>
