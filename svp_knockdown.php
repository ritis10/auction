<?php
	session_start();
    if($_SESSION["logged"]!="1")
    header("location: indexm.php");
    $name=$_SESSION['Name'];
  	$MID=$_SESSION['id_mod'];
    $KDid=$_POST['Knockdown'];

	echo "<title> Complete Knockdown, $name </title>";
	$db=mysqli_connect('localhost','root','','auction') or die("connection failed");
?>
<html>
  <head>
  	<style type="text/css">
  		<style>
      {
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
				text-align: center;
				border-style:solid;
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
      <li><a href="svp.php">Ενεργοποίηση Χρηστών</a></li>
      <li><a href="svp_portaldisable.php">Απενεργοποίηση Χρηστών</a></li>
      <li><a class="active"  href="svp_knockdown.php">Knockdown</a></li>
      <li><a href="svp_Seller_orders.php">Παραγγελίες</a></li>
      <li><a href="svp_Products.php">Προϊόντα</a></li>
      <li><a href="index.php">Αποσύνδεση</a><li>
   </ul>

  	<form method="get" action="newOrder.php">
      <table>
        <tr>
          <th>Id Προσφοράς</th>
					<th>Παράδωση</th>
					<th>Έχει Πληρωθεί Από τον Αγοραστή</th>
					<th>Έχει Πληρωθεί ο Πωλητής</th>
					<th>Έχει Πληρωθεί ο Πάροχος</th>
					<th>Ποσοστό Παρόχου</th>

        </tr>
        <?php

				$query="SELECT * FROM Knockdown WHERE bid_id=$KDid;";
        mysqli_query($db,$query);
        $result=mysqli_query($db,$query);
        while($row=mysqli_fetch_array($result))
				{
          echo '<tr>';
					echo '<td>'.$row['bid_id'].'</td>';
					if ($row['isdelivered']==0)
					{
							echo '<td>ΟΧΙ</td>';
					}
					else {
							echo '<td>NAI</td>';;
						}

					if ($row['ispaidbybuyer']==0)
						{
								echo '<td>ΟΧΙ</td>';
						}
						else {
								echo '<td>NAI</td>';;
							}

						if ($row['ispaidseller']==0)
							{
									echo '<td>ΟΧΙ</td>';
							}
						else {
									echo '<td>NAI</td>';;
								}

						if ($row['isfeespaid']==0)
							{
									echo '<td>ΟΧΙ</td>';
							}
						else {
									echo '<td>NAI</td>';;
							}

							echo '<td>'.$row['providerfees'].'€</td>';



         }
          echo '</table>';
          echo "<br>";
          echo '</tr>';

        mysqli_close($db);
        ?>
      </form>
      <form method="POST" action="landing_page.php">
				<div class="input-group">
						<p><label><b><u>Παράδοση Προϊόντος:</u></b></label>
						ΝΑΙ <input type="radio" name='delivery' value="yes" >
						ΟΧΙ <input type="radio" name='delivery' value="no" checked="checked"></p>
						<p><label><b><u>Πληρωμή προϊόντος από τον Αγοραστή:</u></b></label>
						ΝΑΙ <input type="radio" name='pay' value="yes" >
						ΟΧΙ <input type="radio" name='pay' value="no" checked="checked"></p>
						<p><label><b><u>Πληρωμή Πωλητή:</u></b></label>
						ΝΑΙ <input type="radio" name='selpay' value="yes" >
					  ΟΧΙ <input type="radio" name='selpay' value="no" checked="checked"></p>
						<p><label><b><u>Πληρωμή Παρόχου:</u></b></label>
						ΝΑΙ <input type="radio" name='propay' value="yes" >
						ΟΧΙ <input type="radio" name='propay' value="no" checked="checked"></p>
				</div>
        <p><button type='submit' name='submit' value='18'>Ολοκλήρωση Επεξεργασίας</button></p>
      </form>

      <?php
				$KDid1=$KDid;
				$_SESSION['Knockdown']=$KDid1;
      ?>



 </body>
</html>
