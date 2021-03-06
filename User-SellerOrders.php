<?php
	session_start();
    if($_SESSION["logged"]!="Δημοπράτης")
    header("location: Listings_Seller.php");
	$name=$_SESSION['Name'];
	echo "<title> Welcome $name </title>";
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
				height: 80px;
				padding:50px;
				margin: 60px;
				font-family:sans-serif;
			}
			#logo {width: 2200px;float: left;margin: 10px;height: 500px;}
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
				<li><a href="Seller_portal.php">Πρόσθεσε προϊόν</a></li>
				<li><a href="Listings_Seller.php">Αναζητήστε ένα προϊόν</a></li>
				<li><a href="Seller_orders.php">Οι προσφορές για τα προϊόντα μου</a></li>
				<li><a class="active" href="User-SellerOrders.php">Οι προσφορές μου</a></li>
				<li><a href="productstofin.php">Οριστικοποίηση πλειστηριασμού</a></li>
				<li><a href="MyProducts.php">Διαγραφή πλειστηριασμού</a></li>
				<li><a href="index.php">Αποσύνδεση</a><li>
		</ul>
		<fieldset>
  	<form method="POST" action="Listings_Seller.php">
      <table>
        <tr>
          <th>Κωδικός Παραγγελίας</th>
          <th>Προϊόν</th>
          <th>Πωλητής</th>
          <th>Η Προσφορά μου</th>
					<th>Τωρινή Τιμή Δημοπρασίας</th>
					<th>Πελάτης</th>
					<th>Χρόνος παραγγελίας</th>
          <th>Διεύθυνση Πελάτη</th>
          <th>Κατάσταση Δημοπρασίας</th>
        </tr>
        <?php
        $query="SELECT * FROM orders inner Join users on WhoDoes=id
																		 inner Join product on productId=auctionId
																		 inner Join fin_del_product on prod_status_id=finished
																	   where username='$name';";
        mysqli_query($db,$query) or die("Query Failed");
        $result=mysqli_query($db,$query);
        while($row=mysqli_fetch_array($result)){
          echo '<tr>';
          echo '<td>'.$row['OrderId'].'</td>';
          echo '<td>'.$row['productName'].'</td>';
          echo '<td>'.$row['SellerUsr'].'</td>';
          echo '<td>'.$row['Amount'].'</td>';
					if($row['currBid']==0)
          	echo '<td>'.$row['minbid'].'€</td>';
          else
          	echo '<td>'.$row['currBid'].'€</td>';
					echo '<td>'.$row['first_name'].' '.$row['last_name'].'</td>';
					echo '<td>'.$row['when_'].'</td>';
					echo '<td>'.$row['Address'].'</td>';
          echo '<td>'.$row['prod_status'].'</td>';
          echo '</tr>';
        }
        echo '</table>';
        mysqli_close($db);
        echo "<form action='Listings.php'><button action='Listings_Seller.php'>Πάτησε εδώ για καλύτερη προσφορά</button></form>";
        ?>
      </form>
	</fieldset>
	<div1 id="logo"><img src="BID_PRICE.jpg" alt="Digital Marketing Services" /></div1>
 </body>
</html>
