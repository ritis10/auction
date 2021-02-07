<?php
	session_start();
  if($_SESSION["logged"]!="1")
	//if($_SESSION["logged"]!="Moderator")
	header("location: indexm.php");
	$name=$_SESSION['Name'];
	$MID=$_SESSION['id_mod'];
	echo "<title> User Activation </title>";
	$db=mysqli_connect('localhost','root','','auction') or die("connection failed");
  $oid=$_POST['Activate'];
  $_SESSION['member_to_active']=$oid;
?>
<html>
  <head>
  	<style type="text/css">
  		<style>
      *{
        margin:4px;
      }
      body{
      	margin:70px;
        font-family:sans-serif;
        background-color: powderblue;
      }
      table{
        border-collapse: collapse;
      }
      tr,td,th{
        border-style:solid;
				text-align: center;
      }
      input, button, textarea{
        background: #2196F3;
        border: none;
        left: 0;
        color: #fff;
        bottom: 0;
        border: 0px solid rgba(0, 0, 0, 0.1);
        border-radius:5px;
        transform: rotateZ(0deg);
        transition: all 0.1s ease-out;
      }
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
  </head>
  <body>
  	<ul>
        <li><a class="active"  href="svp.php">Ενεργοποίηση Χρηστών</a></li>
		    <li><a href="svp_portaldisable.php">Απενεργοποίηση Χρηστών</a></li>
				<li><a href="svp_Seller_portal.php">Knockdown</a></li>
	 		  <li><a href="svp_Seller_orders.php">Παραγγελίες</a></li>
	 		  <li><a href="svp_Products.php">Προϊόντα</a></li>
        <li><a href="index.php">Αποσύνδεση</a><li>
    </ul>
  	<form method="POST" action="landing_page.php">
     <center> <h3> Ενεργοποίηση Χρήστη </h3><center>
			 <table>
         <tr>
					 <th>Όνομα Χρήστη</th>
					 <th>Κωδικός Χρήστη</th>
					 <th>Μικρό Όνομα</th>
					 <th>Επώνυμο</th>
					 <th>Ιδιότητα Χρήστη</th>
					 <th>Ημερομηνία Γέννησης</th>
					 <th>Διέυθυνση</th>
					 <th>email</th>
					 <th>Ημερομηνία Έγκρισης Χρήστη</th>
					 <th>Διαχ/στης που ενήργησε</th>
					 <th>Status</th>

         </tr>
         <?php
         $query="SELECT * FROM users inner JOIN user_status on status=u_status_id
				  													 inner JOIN providerormoderator on pom_id=approval_pom
																		 where id=$oid;";
         mysqli_query($db,$query);
         $result=mysqli_query($db,$query);
         while($row=mysqli_fetch_array($result)){
           echo '<tr>';
           echo '<td>'.$row['username'].'</td>';
           echo '<td>'.$row['id'].'</td>';
					 echo '<td>'.$row['first_name'].'</td>';
           echo '<td>'.$row['last_name'].'</td>';
           echo '<td>'.$row['role'].'</td>';
           echo '<td>'.$row['dob'].'</td>';
           echo '<td>'.$row['address'].'</td>';
           echo '<td>'.$row['email'].'</td>';
					 echo '<td>'.$row['approval_date'].'</td>';
					 echo '<td>'.$row['firstname']." ".$row['lastname'].'</td>';
					 echo '<td>'.$row['u_status_descr'].'</td>';
           echo '</tr>';
           $_SESSION["user_status"]=$row['status'];
           $_SESSION["user_to_active"]=$row['id'];
					 $_SESSION['id_mod']=$MID;
         }
         echo '</table>';
         mysqli_close($db);
         ?>
        <button type='submit' name='submit' value='10'>Ενεργοποίηση</button>
 </body>
</html>
