<?php
	require_once('variables.php');
	
	$selgrp = 0;
	$selord = 'N';
	if(isset( $_GET['groupid']))
	{
		$selgrp = $_GET['groupid'];
	}
	if(isset( $_GET['ordcol']))
	{
		$selord = $_GET['ordcol'];
	}
	$_SESSION['currentgroupid'] = $selgrp;
	$_SESSION['currentordcol'] = $selord;
	
?>
<html>
<head>
<title>
 Music Kart
</title>
</head>
<link rel='stylesheet' type = 'text/css' href='music.css'>
<body>
<div id = 'topboxS'>
	<img src="http://localhost/images1/QVcartTrans.png">
</div>
<div id = 'contentS'>
<div class = 'leftdivWrapperS'>
	<div id = 'leftboxS'>
		Items:
		<br />
		<?php
			
			
			$sqlcon = mysqli_connect($_SESSION['server'], $_SESSION['user'], $_SESSION['password'], $_SESSION['database']);
			if(!$sqlcon)
			{
				die("Error in connecting database");
			}
			$result = $sqlcon -> query(
			"select pg.GroupId, pg.GroupName, count(*) itemcount  from ProductGroups PG inner join Products P on P.GroupId = PG.GroupID group by pg.GroupId, pg.GroupName");
			echo '<ul>';
			while($row = $result->fetch_assoc())
			{
				echo '<li>';
				echo'<a href ="index.php?groupid=' . $row['GroupId'] . '&ordcol=' . $selord . '">' . $row['GroupName'] . '<a> [';
				echo $row['itemcount'];
				echo ']';
				echo'<br />';
				echo '</li>';
			}
			echo '</ul>';
		?>
	</div>
	
	<div id = 'leftbottomS'>
		Sort By:
		<?php
		    echo '<ul>';
				echo '<li>';
					echo'<a href ="index.php?groupid=' . $selgrp . '&ordcol=N' . '">Name</a>';
				echo '</li>';
				echo '<br />';
				echo '<li>';	
					echo'<a href ="index.php?groupid=' . $selgrp . '&ordcol=P' . '">Price</a>';
				echo '</li>';
			echo '</ul>';	
		?>
	</div>
</div>

<div id = 'rightboxS'>
<?php
		$qury = "select ProductId,ProductName, Price from Products where GroupId = " . $selgrp ;
		switch($selord)
		{
			case 'N':
				$itemres = $sqlcon -> query($qury . ' order by ProductName');
				break;
			case 'P':
				$itemres = $sqlcon -> query($qury . ' order by Price');
				break;
		}
		while($row = $itemres -> fetch_assoc())
		{
			echo '<div class ="itembrd">';
			echo '<div class = "ProImgBrd">';
			echo '<img src = "images/'.$selgrp.'/'.$row['ProductId'].'.jpg">';
			echo '</div>';
			echo '<br />';
			echo 'Product Id: '.$row['ProductId'];
			echo '<br />';
			echo 'Name: '. $row['ProductName'];
			echo '<br />';
			echo 'Price: '. $row['Price'];
			
			echo '<br />';
			if($_SESSION['login'] == 1)
			{
				echo '<form method="POST" action="cart.php">';
				
				echo 'Quantity:  ';
				echo '<input type="text" name="quantity" size="5">';
				echo '<input type="hidden" name="prodid" value = "' . $row['ProductId'] . '">';
				echo '<br />';
				echo "<img src = 'http://localhost/images/Buy-Now-Button1.png'>";
				echo '<input type="submit" name="cart" value="Add to cart">';
				
			
				echo '</form>';
			
			}
			
			echo '</div>';
		} 
?>	
</div>
</div>
<div id = 'bottomboxS'>
	<p><b>Copyright : Supriya Movva,FOSS,Amritpuri</b></p>
<div id = boxlinks>
<a href="http://localhost/index.php?"><b> |Home| </b></a>
<a href="http://localhost/signin.php?"><b> |signin| </b></a>
</div>
<?php
		$sqlcon->close();
?>
</body>
</html>