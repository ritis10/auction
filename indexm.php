<!DOCTYPE html>
<?php
  session_start();
  $_SESSION["logged"]="";
  $_SESSION["Name"]="";
  $_SESSION["id_mod"]="";
  $db=mysqli_connect('localhost','root','','auction') or die("Δεν έγινε επιτυχής πρόσβαση στη Βάση Δεδομένων");
  if (isset($_GET["err"]) and $_GET["err"]==1)
      echo "Please Login";
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
<html>
  <head>
    <style>
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
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>ΕΙΣΟΔΟΣ SVP OR MOD</title>
    <link rel=stylesheet type="text/css" href=style.css>
  </head>
  <body>
    <ul>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">Χρήσιμα</a>
    <div class="dropdown-content">
      <a href="guest.php">Είσοδος σαν Επισκέπτης</a>
      <a href="winners.php">Νικητές Δημοπρασιών</a>
      <a href="contactus.php">Επικοινωνήστε μαζί μας</a>
      <a href="index.php">User Log in</a>
    </div>
  </li>
</ul>
  	<center><h2><span>Καλως ήρθατε στο site xrisimos.gr για πλειστηριασμούς</span></h2><center>
	  <!--<center><h4><span>Είσοδος Service Provider or Moderator</span></h4><center>-->
    <?php
      if($_SERVER["REQUEST_METHOD"]=="POST")
      {
        $usr=$_POST['usr'];
        $pass=$_POST['passwd'];
        //if(isset($_POST['category']))
        	//$cat=$_POST['category'];

        $query="select username_, pom_id from providerormoderator where username_='$usr' and password='$pass';";
        $result=mysqli_query($db,$query) or die("Η σύνδεση απέτυχε");
        $count=mysqli_num_rows($result);
		      if($count!=1)
          {
            $error="Λάθος Διαπιστευτήρια";
            $query="select username_ from providerormoderator where username_='$usr' and password='$pass';";
            $result=mysqli_query($db,$query) or die("Η σύνδεση απέτυχε");
            $count=mysqli_num_rows($result);
              if($count==1)
              {
                  echo '<tr>';
                  echo '<td>' ."Ο λογαριασμός σας δεν ισχύει".'</td>';
                  echo '</tr>';
              }
          }
          else
          {
            $query="SELECT Is_Moderator from providerormoderator where username_='$usr' and password='$pass';";
            $result=mysqli_query($db,$query) or die("Η σύνδεση απέτυχε");
            $cat=mysqli_fetch_all($result);
            $query2="SELECT pom_id from providerormoderator where username_='$usr' and password='$pass';";
            $result2=mysqli_query($db,$query2) or die("Η σύνδεση απέτυχε");
            $MID1=mysqli_fetch_all($result2);
            $MID=$MID1[0][0];
            $role=$cat[0][0];
            $_SESSION["logged"]=$role;
            $_SESSION["Name"]=$usr;
            $_SESSION["id_mod"]=$MID;
            if($role=="1")
          	   header("location: svp.php");
            else if($role=="0")
          	   header("location: Moderator_portal.php");
            else
              echo "Δεν σας έχει δωθεί κατηγορία admin";
           }
      }
     ?>

    <center>
    <form id="login" method="post" action="">
    <p class="title"><b>Είσοδος Service Provider/Moderator</b></p>

    <input type="text" placeholder="Username" id='usr' name='usr'  required/>
    <input type="password" placeholder="Password" id='passwd' name='passwd' required/>
    <!--<p>
      (Service Provider)Πάροχος<input type="radio" name='category' value="1">
    </p>
    <p>
      (Moderator)Διαμεσολαβητής<input type="radio" name='category' value="0">
    </p>-->
    <?php
        if(isset($error) && !empty($error))
        {
          echo "<p id='error'> $error </p>";
        }
        mysqli_close($db);
    ?>
    <button type="submit" id='lgin'>
      Log In
    </button>
    </form>
    <!--<p>
    <a href="index.php"><span>User Login</span></a>
  </p>-->
  </center>
  </body>
   </html>
