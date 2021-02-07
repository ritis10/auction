<?php
	session_start();
	$name=$_SESSION['Name'];
	echo "<title> Ακύρωση Δημοπρασίας </title>";
	$db=mysqli_connect('localhost','root','','auction') or die("connection failed");
  $pid=$_POST['Delete'];
  $_SESSION['Auction_to_delete']=$pid;
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
 		 <li><a href="svp_Seller_portal.php">Knockdown</a></li>
 		 <li><a href="svp_Seller_orders.php">Παραγγελίες</a></li>
 		 <li><a class="active"  href="svp_Products.php">Προϊόντα</a></li>
 		 <li><a href="index.php">Αποσύνδεση</a><li>
    </ul>
  	<form method="POST" action="landing_page.php">
     <center> <h3> Ακύρωση Δημοπρασίας </h3><center>
			 <table>
			 <tr>
				 <th>Κωδικός Πλειστηριασμού</th>
				 <th>Όνομα Προϊόντος ή Υπηρεσίας</th>
				 <th>Τιμή Εκκίνησης</th>
				 <th>Τωρινή Τιμή Δημοπρασίας</th>
				 <th>Τιμή Επόμενου Χτυπήματος</th>
				 <th>Λεπτομέρειες</th>
				 <th>Τύπος Δημοπρασίας</th>
				 <th>Πωλητής</th>
				 <th>Επιτρέπονται οι Παρατασεις</th>
				 <th>Ώρα που απομένει</th>
				 <th>Αριθμός επιτρεπόμενων επεκτάσεων</th>
				 <th>Χρόνος μιας επέκτασης</th>
				 <th>crucial time</th>
				 <th>Κατάσταση Δημοπρασίας</th>
			 </tr>
			 <?php
			 $query="SELECT * FROM product inner JOIN auction_types on a_type_id=type
 																		inner JOIN users on owner=id
 																		inner Join fin_del_product on prod_status_id=finished where auctionId=$pid;";
			 mysqli_query($db,$query);
			 $result=mysqli_query($db,$query);
			 while($row=mysqli_fetch_array($result)){
				 echo '<tr>';
				 echo '<td>'.$row['auctionId'].'</td>';
				 echo '<td>'.$row['productName'].'</td>';
				 echo '<td>'.$row['minbid'].'</td>';
				 echo '<td>'.$row['currBid'].'</td>';
				 echo '<td>'.$row['username'].'</td>';
				 echo '<td>'.$row['descp'].'</td>';
				 echo '<td>'.$row['a_type_descr'].'</td>';
				 echo '<td>'.$row['first_name']. ' ' .$row['last_name'].'</td>';
				 if($row['extensions']==1)
					 echo '<td>NAI</td>';
				 else
					 echo '<td>OXI</td>';
					 $d1=date_create($row['expiry']);
					 $d1->modify("+5 hours");
					 $d2=date_create(date("Y-m-d H:i:s"));
					 //$d2=strtotime($d2);
					 $diff=date_diff($d2,$d1);
					 if($diff->format("%R%a")<0)
					 {
									 echo '<td>Expired</td>';
									 $isSaveDisabled = true;
					 }
					 elseif ($row['finished']!=0) {
						 echo '<td>Expired</td>';
					 }
					 elseif($d1<$d2)
					 {
							 if($row['extensions']==1)
							 {
											 $last="SELECT currBid as \"lastBid\" from product WHERE currBid > (NOW() - INTERVAL 30 MINUTE)";
											 $last=mysqli_query($db,$last) or die("query failed");
											 $last=mysqli_fetch_array($last);
											 if($last == true)
											 {
													 $d1->modify("+15 minutes");
													 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
													 $update="UPDATE product SET Num_of_Extensions = Num_of_Extensions-1";
													 $result=mysqli_query($db,$update) or die('Could not update');
											 }
							 }
							 else{
									 echo '<td>Expired</td>';
									 $isSaveDisabled = true;
							 }
					 }
					 elseif($diff->format("%R%h")>4)
					 {
						 echo '<td>Last 4 Hours</td>';
					 }
					 elseif($diff->format("%R%h")>3)
					 {
						 echo '<td>Last 3 Hours</td>';
					 }
					 elseif($diff->format("%R%h")>2)
					 {
						 echo '<td>Last 2 Hours</td>';
					 }
					 elseif($diff->format("%R%h")>1)
					 {
						 echo '<td>Last Hour</td>';
					 }
					 elseif($diff->format("%R%i")>30)
					 {
						 echo '<td>Last 30 Minutes</td>';
					 }
					 elseif($diff->format("%R%i")>20)
					 {
						 echo '<td>Last 20 Minutes</td>';
					 }
					 elseif($diff->format("%R%i")>10)
					 {
						 echo '<td>Last 10 Minutes</td>';
					 }
					 elseif($diff->format("%R%i")>5)
					 {
						 echo '<td>Last 5 Minutes</td>';
					 }
					 elseif($diff->format("%R%i")>4)
					 {
						 echo '<td>Last 4 Minutes</td>';
					 }
					 elseif($diff->format("%R%i")>3)
					 {
						 echo '<td>Last 3 Minutes</td>';
					 }
					 elseif($diff->format("%R%i")>2)
					 {
						 echo '<td>Last 2 Minutes</td>';
					 }
					 elseif($diff->format("%R%i")>1)
					 {
						 echo '<td>Last Minute</td>';
					 }

					 echo '<td>'.$row['Num_of_Extensions'].'</td>';
					 echo '<td>'.$row['Time_of_Extensions'].'</td>';
					 echo '<td>'.$row['crucial_time'].'</td>';
					 echo '<td>'.$row['prod_status'].'</td>';

				 //echo "<td> <button type='submit' name='Delete' value=".$row['auctionId'].">Ακύρωση Δημοπρασίας</button></td>";
				 echo '</tr>';
				  $_SESSION["Auction_to_delete"]=$row['auctionId'];
			 }
			 echo '</table>';
			 mysqli_close($db);
			 ?>
        <button type='submit' name='submit' value='13'>Ακύρωση Δημοπρασίας</button>
 </body>
</html>
