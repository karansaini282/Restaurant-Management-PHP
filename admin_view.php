<?php
session_start();
if($_SESSION['user_type']!='admin')
{
	header("location: login.php");
}
include 'conn.php';

?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Restaurant/admin</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel="stylesheet" type="text/css" href="http://localhost/Library/style.css">
  <link rel="stylesheet" type="text/css" href="http://localhost/Library/jq.css">
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js'></script>
  <script type="text/javascript" src="http://localhost/Library/jquery.tablesorter.js"></script> 
  <script type="text/javascript" src="http://localhost/Library/jquery.metadata.js"></script> 
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
      <li><a href="admin.php"><span style='color:yellow'>Add</span></a></li>
      <li class="active"><a><span style='color:yellow'>View</span></a></li>
	  <li><a href="delete.php"><span style='color:yellow'>Delete</span></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
         <li><a href="logout.php"><span style='color:red'><span class="glyphicon glyphicon-log-out"></span> Log Out</span></a></li>
    </ul>
  </div>
</nav>
<div class='container'>
	<ul class="nav nav-pills nav-justified">
		<li class="active"><a data-toggle='pill' href="#customer">Customer</a></li>
		<li><a data-toggle='pill' href="#items">Items</a></li>
		<li><a data-toggle='pill' href="#waiter">Waiter</a></li>
		<li><a data-toggle='pill' href="#manager">Manager</a></li>
	</ul>
	
	<div class='tab-content'>
	
	<div id='customer' class='tab-pane fade in active'>
			<table id="table_customer" class='tablesorter'>
			<thead>
			 <tr>
			  <th>CUSTOMER ID</th>
			  <th>USER ID</th>
			  <th>NAME</th>
			  <th>ADDRESS</th>
			  <th>CONTACT</th>			  
			 </tr>
			</thead>
			<tbody>			
				<?php 
				$sql="SELECT * from customer;";
				$res=$conn->query($sql);
				while($row=mysqli_fetch_assoc($res))
				{
				?>
				<tr>
				 <td><?php echo $row['customer_id']; ?></td>
				 <td><?php echo $row['user_id']; ?></td>
				 <td><?php echo $row['name']; ?></td>
				 <td><?php echo $row['address']; ?></td>
				 <td><?php echo $row['contact']; ?></td>				 
				</tr>
				<?php } ?>			
			</tbody>
			</table>
	</div>
	
	<div id='items' class='tab-pane fade'>
			<table id="table_items" class='tablesorter'>
			<thead>
			 <tr>
			  <th>ITEM ID</th>
			  <th>NAME</th>
			  <th>PRICE</th>
			  <th>DESCRIPTION</th>
			  <th>CATEGORY ID</th>
			 </tr>
			</thead>
			<tbody>			
				<?php 
				$sql="SELECT * from items;";
				$res=$conn->query($sql);
				while($row=mysqli_fetch_assoc($res))
				{
				?>
				<tr>
				 <td><?php echo $row['item_id']; ?></td>
				 <td><?php echo $row['name']; ?></td>
				 <td><?php echo $row['price']; ?></td>
				 <td><?php echo $row['description']; ?></td>
				 <td><?php echo $row['category_id']; ?></td>
				</tr>
				<?php } ?>			
			</tbody>
			</table>
	</div>
	
	<div id='waiter' class='tab-pane fade'>
			<table id="table_waiter" class='tablesorter'>
			<thead>
			 <tr>
			  <th>WAITER ID</th>
			  <th>NAME</th>
			  <th>ADDRESS</th>
			  <th>CONTACT</th>
			  <th>MANAGER ID</th>
			 </tr>
			</thead>
			<tbody>			
				<?php 
				$sql="SELECT * from waiter;";
				$res=$conn->query($sql);
				while($row=mysqli_fetch_assoc($res))
				{
				?>
				<tr>
				 <td><?php echo $row['waiter_id']; ?></td>
				 <td><?php echo $row['name']; ?></td>
				 <td><?php echo $row['address']; ?></td>
				 <td><?php echo $row['contact']; ?></td>
				 <td><?php echo $row['manager_id']; ?></td>
				</tr>
				<?php } ?>			
			</tbody>
			</table>
	</div>	
	
	<div id='manager' class='tab-pane fade'>
			<table id="table_manager" class='tablesorter'>
			<thead>
			 <tr>
			  <th>MANAGER ID</th>
			  <th>NAME</th>
			  <th>ADDRESS</th>
			  <th>CONTACT</th>			  
			 </tr>
			</thead>
			<tbody>			
				<?php 
				$sql="SELECT * from manager;";
				$res=$conn->query($sql);
				while($row=mysqli_fetch_assoc($res))
				{
				?>
				<tr>
				 <td><?php echo $row['manager_id']; ?></td>
				 <td><?php echo $row['name']; ?></td>
				 <td><?php echo $row['address']; ?></td>
				 <td><?php echo $row['contact']; ?></td>				 
				</tr>
				<?php } ?>			
			</tbody>
			</table>
	</div>	
	
	</div>

</div>
</body>
</html>
<script>
$(document).ready(function() 
    { 
        $("#table_customer").tablesorter(); 
		$("#table_items").tablesorter(); 
		$("#table_waiter").tablesorter(); 
		$("#table_manager").tablesorter(); 		
    } 
); 
</script>