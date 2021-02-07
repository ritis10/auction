<!DOCTYPE html>
<?php
  session_start();
  $_SESSION["logged"]="";
  $_SESSION["Name"]="";
  $db=mysqli_connect('localhost','root','','auction') or die("Δεν έγινε επιτυχής πρόσβαση στη Βάση Δεδομένων");
  if (isset($_GET["err"]) and $_GET["err"]==1)
      echo "Please Login";
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>
<html>
  <head>
    <style>
body{
      margin:10px;
      font-family:sans-serif;
      background-image: url("pic11.jpg");
      background-repeat: no-repeat;
      background-size: cover;
      height: 100%;
    }
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a, .dropbtn {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

li.dropdown {
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #333;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: red;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1;}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ΕΙΣΟΔΟΣ ΧΡΗΣΤΗ</title>
    <link rel=stylesheet type="text/css" href=cssfile.css>
  </head>
  <body>
    <ul>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Χρήσιμα</a>
    <div class="dropdown-content">
      <a href="guest.php">Είσοδος σαν Επισκέπτης</a>
      <a href="winners.php">Νικητές Δημοπρασιών</a>
      <a href="contactus.php">Επικοινωνήστε μαζί μας</a>
      <a href="indexm.php">Service Providers/Moderators</a>
    </div>
  </li>
</ul>
  	<center><h2><span>Καλως ήρθατε στο site xrisimos.gr για πλειστηριασμούς</span></h2><center>
	  <!--<center><h4><span>Συμπληρώστε username και password για Είσοδο</span></h4><center>-->
    <?php
      if($_SERVER["REQUEST_METHOD"]=="POST")
      {
        $usr=$_POST['usr'];
        $pass=$_POST['passwd'];

        $query="select username from users where username='$usr' and pass='$pass' and status='3';";
        $result=mysqli_query($db,$query) or die("Η σύνδεση απέτυχε");
        $count=mysqli_num_rows($result);
		      if($count!=1)
          {
            $error="Λάθος Διαπιστευτήρια";
            $query="select username from users where username='$usr' and pass='$pass' and status='temporarily disabled'or'finally disabled';";
            $result=mysqli_query($db,$query) or die("Η σύνδεση απέτυχε");
            $count=mysqli_num_rows($result);
              if($count==1)
              {
                  echo "<p style='font-size: 20pt;color:red; background-color:powderblue' > Ο λογαριασμός δεν ειναι ενεργοποιημένος! </p>";
                  echo "<p style='background-color:powderblue'> Επικοινωνήστε με το διαχ/στη του συστήματος για ενεργοποίηση. </p>";
              }
          }
          else
          {
            $query="SELECT role from users where username='$usr' and pass='$pass' and status='3';";
            $result=mysqli_query($db,$query) or die("Η σύνδεση απέτυχε");
            $cat=mysqli_fetch_all($result);
            $role=$cat[0][0];
            $_SESSION["logged"]=$role;
            $_SESSION["Name"]=$usr;
            if($role=="Ενδιαφερόμενος")
          	   header("location: Listings.php");
            else if($role=="Δημοπράτης")
          	   header("location: Seller_portal.php");
            else
              echo "Δεν σας έχει δωθεί κατηγορία user";
           }
      }
     ?>

    <center>
    <form id="login" method="post" action="">
    <p class="title"><b>Είσοδος Χρήστη</b></p>

    <input type="text" placeholder="Username" id='usr' name='usr'  required/>
    <input type="password" placeholder="Password" id='passwd' name='passwd' required/>

    <!--<label><b><u>Επιλέξτε Κατηγορία user</u></b></label>
    <p>
      Eνδιαφερόμενος (Buyer) <input type="radio" name='category' value="buyer">
    </p>
    <p>
      Δημοπράτης (Seller)  <input type="radio" name='category' value="seller">
    </p>
    <!--<input type="radio" name='category' value="svp">(Service Provider)Πάροχος!-->
	  <!--<input type="radio" name='category' value="Moderator">Διαμεσολαβητής!-->

    <?php
        if(isset($error) && !empty($error))
        {
          echo "<p style='color:red'id='error'> $error </p>";
        }
        mysqli_close($db);
    ?>
    <button type="submit" id='lgin'>
      Log In
    </button>
    <p>
       Δεν είσαστε μέλος; <a href="registration.php">Εγγραφή</a>
   </p>
    <!--</form>
    <p>
    <a href="guest.php"><span>Για είσοδο σαν επισκέπτης</span></a>
    </p>
    <p>
    <a href="contactus.php"><span>Για επικοινωνία</span></a>
    </p>
    <p>
    <a href="indexm.php"><span>Service Providers or Moderators</span></a>
  </p>-->
  </center>
  </body>
   </html>
