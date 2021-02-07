<?php
	session_start();
    if($_SESSION["logged"]!="Ενδιαφερόμενος")
    header("location: index.php");
	$name=$_SESSION['Name'];
	echo "<title> Welcome $name </title>";
  $db=mysqli_connect('localhost','root','','auction');
?>
<html>
  <head>
  	<style type="text/css">
  		<style>
      *{
        margin:4px;
      }
      body{
      	margin: 70px;
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
      input, button{
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
			<li><a href="Listings.php">Αναζήτηση Προϊόντων</a></li>
			<li><a href="BuyerPortal.php">Πρόσθεσε προϊόν</a></li>
			<li><a href="Buyer_orders.php">Οι προσφορές για τα προϊόντα μου</a></li>
			<li><a href="userOrders.php">Οι προσφορές μου</a></li>
			<li><a class="active" href="productstofinBuyer.php">Οριστικοποίηση πλειστηριασμού</a></li>
			<li><a href="MyProductsB.php">Διαγραφή πλειστηριασμού</a></li>
			<li><a href="index.php">Αποσύνδεση</a><li>
		</ul>
        <fieldset>
        <form method="post" action="productstofinBuyer.php">
        <select name='filter'>
         <option  value="ALL">Όλες οι δημοπρασίες</option>
         <option  value="Sat">Ολοκληρωμένες</option>
         <option  value="UnSat">Σε ισχύ</option>
				 <option  value="Del">Διεγραμμένες</option>
        </select>
        <input type="Submit" value='filter'>
        </form>
       </fieldset>
      <fieldset>
 			<form name='myorders' method="POST" action="FinalizeBuyer.php" >
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
        $filter="";
        if(isset($_POST['filter']))
          $filter=$_POST['filter'];

        if($filter=="ALL" || !isset($_POST['filter']))
				  $query="SELECT * FROM product inner JOIN auction_types on a_type_id=type
																				inner JOIN users on id=owner
																				inner Join fin_del_product on prod_status_id=finished
																				where username='$name';";

        else if($filter=="MY")
          $query="SELECT * FROM product where owner='$name';";

      else if($filter=="Sat"){
        $query="SELECT * FROM product inner JOIN auction_types on a_type_id=type
																			inner JOIN users on id=owner
																			inner Join fin_del_product on prod_status_id=finished
																			where username='$name'
																		  and finished=1;";
      }

      else if($filter=="UnSat")
			$query="SELECT * FROM product inner JOIN auction_types on a_type_id=type
																		inner JOIN users on id=owner
																		inner Join fin_del_product on prod_status_id=finished
																		where username='$name'
																	  and finished=0;";
			else if($filter=="Del")
			  $query="SELECT * FROM product inner JOIN auction_types on a_type_id=type
																			inner JOIN users on id=owner
																			inner Join fin_del_product on prod_status_id=finished
																			where username='$name'
											 						    and finished=2;";

        mysqli_query($db,$query) or die("Query Failed");
        $result=mysqli_query($db,$query);
        while($row=mysqli_fetch_array($result)){
					echo '<tr>';
					echo'<td>'.$row['auctionId'].'</td>';
					echo '<td>'.$row['productName'].'</td>';
					echo '<td>'.$row['minbid'].'€</td>';
					if($row['currBid']==0)
						echo '<td>'.$row['minbid'].'€</td>';
					else
						echo '<td>'.$row['currBid'].'€</td>';
					echo '<td>'.$row['price_step'].'€</td>';
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
												//$last=mysqli_fetch_array($last);
												if(mysqli_num_rows($last)==1)
												{
														$d1->modify("+15 minutes");
														mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
														$update="UPDATE product SET Num_of_Extensions = Num_of_Extensions-1";
														$result=mysqli_query($db,$update) or die('Could not update');
														//break;
														echo '<td>Last 15 Minutes</td>';
														break;
												}
								}
								else
									{
										echo '<td>Expired</td>';
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
						if($row['finished']==3 OR $row['finished']==2)
						{
							echo "<td> <button style='background-color:red' type='submit' name='Final' value=".$row['auctionId']." disabled>Finalize</button></td>";
						}
						else {
							echo "<td> <button type='submit' name='Final' value=".$row['auctionId'].">Finalize</button></td>";
						}

          echo '</tr>';
					$_SESSION["product_to_finalize"]=$row['auctionId'];
				}
        echo '</table>';
        mysqli_close($db);
        ?>
      </form>
    </fieldset>
  	</body>
</html>
