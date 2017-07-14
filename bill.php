<?php
session_start();
if($_SESSION['user_type']!='member')
{
	header("location: login.php");
}
include 'conn.php';
$customer_id=$_SESSION['customer_id'];
$sql="SELECT max(waiter_id) as max_waiter_id from waiter;";
$res=$conn->query($sql);
$row=mysqli_fetch_assoc($res);
$max_waiter_id=$row['max_waiter_id'];
$check=0;
do
{
	$waiter_id=rand(1,$max_waiter_id);
	$sql="SELECT * FROM waiter WHERE waiter_id=".$waiter_id.";";
	$res=$conn->query($sql);
	if(mysqli_num_rows($res)>0)
	{
		$check++;
	}
}while($check==0);
$items=array();
$total_cost=0;
if(isset($_POST['bill_submit']))
{
	$i=0;
	while(isset($_POST['item'.$i]))
	{
		array_push($items,$_POST['item'.$i]);
		$i++;
	}
}
else
{
	header("location: customer.php");
}
for($i=0;$i<count($items);$i++)
{
	$sql="SELECT * FROM items WHERE item_id=".$items[$i].";";
	$res=$conn->query($sql);
	$row=mysqli_fetch_assoc($res);
	$total_cost+=$row['price'];
}
$sql="INSERT INTO bill (total_cost,customer_id,waiter_id) VALUES(".$total_cost.",".$customer_id.",".$waiter_id.");";
$conn->query($sql);
$bill_id=$conn->insert_id;
for($i=0;$i<count($items);$i++)
{
	$sql="INSERT INTO orders (item_id,bill_id) VALUES (".$items[$i].",".$bill_id.");";
	$res=$conn->query($sql);
}
$sql="SELECT * FROM customer WHERE customer_id=".$customer_id.";";
$res=$conn->query($sql);
$row=mysqli_fetch_assoc($res);
$customer_name=$row['name'];
$sql="SELECT * FROM waiter WHERE waiter_id=".$waiter_id.";";
$res=$conn->query($sql);
$row=mysqli_fetch_assoc($res);
$waiter_name=$row['name'];
$manager_id=$row['manager_id'];
$sql="SELECT * FROM manager WHERE manager_id=".$manager_id.";";
$res=$conn->query($sql);
$row=mysqli_fetch_assoc($res);
$manager_name=$row['name'];
$datetime = new DateTime();
$date=$datetime->format('d-m-Y');
$datetime = new DateTime();
$time=$datetime->format('h-i-s');
?>


<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Restaurant/bill</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js'></script>
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand"><span style='color:green'>Restaurant Management</span></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a><span style='color:yellow'>Bill</span></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
         <li><a href="logout.php"><span style='color:red'><span class="glyphicon glyphicon-log-out"></span> Log Out</span></a></li>
    </ul>
  </div>
</nav>
<div class='container'>
	<div class='row'>
	<div class='col-sm-6'>
			<table id="table_bill" class='table table-bordered th, .table-bordered td { border: 1px solid #ddd!important }'>
			<thead>
			 <tr style='background:black;color:white;'>
			  <th>ITEM</th>
			  <th>PRICE</th>			  
			 </tr>
			</thead>
			<tbody>			
				<?php 
				for($i=0;$i<count($items);$i++)
				{
					$sql="SELECT * FROM items WHERE item_id=".$items[$i].";";
					$res=$conn->query($sql);
					$row=mysqli_fetch_assoc($res);
				?>
				<tr>
				 <td><?php echo $row['name']; ?></td>
				 <td><?php echo $row['price']; ?></td>				 
				</tr>
				<?php } ?>
				<tr style='background:red;color:white;'>
				 <td>TOTAL</td>
				 <td><?php echo $total_cost; ?></td>				 
				</tr>				
			</tbody>
			</table>
	</div>
	<div class='col-sm-6'>
		<div class="panel-group">
		  <div class="panel panel-primary">
			<div class="panel-heading">CUSTOMER</div>
			<div class="panel-body"><?php echo $customer_name;?></div>
		  </div>
		  <div class="panel panel-primary">
			<div class="panel-heading">WAITER</div>
			<div class="panel-body"><?php echo $waiter_name;?></div>
		  </div>
		  <div class="panel panel-primary">
			<div class="panel-heading">MANAGER</div>
			<div class="panel-body"><?php echo $manager_name;?></div>
		  </div>
		  <div class="panel panel-primary">
			<div class="panel-heading">DATE</div>
			<div class="panel-body"><?php echo $date;?></div>
		  </div>
		  <div class="panel panel-primary">
			<div class="panel-heading">TIME</div>
			<div class="panel-body"><?php echo $time;?></div>
		  </div>		  
        </div>
	</div>
	</div>
</div>
</body>
</html>