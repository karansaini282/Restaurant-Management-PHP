<?php
session_start();
if($_SESSION['user_type']!='admin')
{
	header("location: login.php");
}
include 'conn.php';
if(isset($_GET['msg']))
{
	if($_GET['msg']==1)
	{
		echo "<script>alert('Item was successfully added');</script>";
	}
	else if($_GET['msg']==2)
	{
		echo "<script>alert('Waiter was successfully added');</script>";
	}	
	else if($_GET['msg']==3)
	{
		echo "<script>alert('Manager was successfully added');</script>";
	}	
}

if(isset($_POST['items_submit']))
{
	$name=$_POST['items_name'];
	$description=$_POST['items_description'];
	$price=$_POST['items_price'];
	$category_id=$_POST['items_category_id'];
	$sql="INSERT INTO items (name,description,price,category_id) VALUES ('".$name."','".$description."',".$price.",".$category_id.");";
	$conn->query($sql);
	$item_id=$conn->insert_id;
	header("location: admin.php?msg=1&item_id=".$item_id);
}
if(isset($_POST['waiter_submit']))
{
	if(!isset($_POST['waiter_manager_id']))
	{
		echo "<script>alert('Mandatory fields are missing');</script>";
	}
	else
	{
		$name=$_POST['waiter_name'];
		$address=$_POST['waiter_address'];
		$contact=$_POST['waiter_contact'];
		$manager_id=$_POST['waiter_manager_id'];
		$sql="INSERT INTO waiter (name,address,contact,manager_id) VALUES ('".$name."','".$address."','".$contact."',".$manager_id.");";
		$conn->query($sql);
		$waiter_id=$conn->insert_id;
		header("location: admin.php?msg=2&waiter_id=".$waiter_id);
	}
}
if(isset($_POST['manager_submit']))
{
	$name=$_POST['manager_name'];
	$address=$_POST['manager_address'];
	$contact=$_POST['manager_contact'];
	$sql="INSERT INTO manager (name,address,contact) VALUES ('".$name."','".$address."','".$contact."');";
	$conn->query($sql);
	$manager_id=$conn->insert_id;
	header("location: admin.php?msg=3&manager_id=".$manager_id);
}

?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Restaurant/admin</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js'></script>
  <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand"><span style='color:green'>Restaurant Management</span></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a><span style='color:yellow'>Add</span></a></li>
      <li><a href="admin_view.php"><span style='color:yellow'>View</span></a></li>
	  <li><a href="delete.php"><span style='color:yellow'>Delete</span></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
         <li><a href="logout.php"><span style='color:red'><span class="glyphicon glyphicon-log-out"></span> Log Out</span></a></li>
    </ul>	
  </div>
</nav>
<div class='container'>
	<ul class="nav nav-pills nav-justified">
		<li class="active"><a data-toggle='pill' href="#items">Items</a></li>
		<li><a data-toggle='pill' href="#waiter">Waiter</a></li>
		<li><a data-toggle='pill' href="#manager">Manager</a></li>
	</ul>
	
	<div class='tab-content'>
	
	<div id='items' class='tab-pane fade in active'>
		<div class='row'>
			<div class='col-md-3'>
			</div>
			<div class='col-md-6'>
				<form role='form' method='POST' action='admin.php'>
				  <div class='form-group'>
					<label for='items_name'>Name: </label>
					<input type='text' class='form-control' id='items_name' name='items_name'>
				  </div>
				  <div class='form-group'>
					<label for='items_description'>Description: </label>
					<input type='text' class='form-control' id='items_description' name='items_description'>
				  </div>
				  <div class='form-group'>
					<label for='items_price'>Price: </label>
					<input type='number' step='50' class='form-control' id='items_price' name='items_price'>
				  </div>
				  <div class='form-group'>
					<label for='items_category_id'>Category: </label>
					<select class='form-control' id='items_category_id' name='items_category_id'>
					 <option value="1">Starter</option>
					 <option value="2">Soup</option>
					 <option value="3">Main Course</option>
					 <option value="4">Desert</option>
					</select> 
				  </div>
				  <div class='form-group'>
					<input style='background:black;color:white;' type='submit' class='form-control' value='Submit' name='items_submit'>
				  </div>
				</form>
			</div>
			<div class='col-md-3'>
			</div>
		</div>
	</div>
	
	<div id='waiter' class='tab-pane fade'>
		<div class='row'>
			<div class='col-md-3'>
			</div>
			<div class='col-md-6'>
				<form role='form' method='POST' action='admin.php'>
				   <div class='form-group'>
					<label for='waiter_name'>Name: </label>
					<input type='text' class='form-control' id='waiter_name' name='waiter_name'>
				  </div>
				  <div class='form-group'>
					<label for='waiter_address'>Address: </label>
					<input type='text' class='form-control' id='waiter_address' name='waiter_address'>
				  </div>				   
				  <div class='form-group'>
					<label for='waiter_contact'>Contact: </label>
					<input type='text' class='form-control' id='waiter_contact' name='waiter_contact'>
				  </div>				   
				  <div class='form-group'>
					<label for='waiter_manager_id'>Manager: </label>
					<select class='form-control' id='waiter_manager_id' name='waiter_manager_id'>
						<?php 
						$sql="SELECT * from manager;";
						$res=$conn->query($sql);
						while($item=mysqli_fetch_assoc($res)){ ?>
						<option value='<?php echo $item["manager_id"]; ?>'><?php echo $item["name"]; ?></option>
						<?php }?>
					</select>
				  </div>					  
				  <div class='form-group'>
					<input style='background:black;color:white;' type='submit' class='form-control' value='Submit' name='waiter_submit'>
				  </div>
				</form>
			</div>
			<div class='col-md-3'>
			</div>
		</div>
	</div>
	
	<div id='manager' class='tab-pane fade'>
		<div class='row'>
			<div class='col-md-3'>
			</div>
			<div class='col-md-6'>
				<form role='form' method='POST' action='admin.php'>
				  <div class='form-group'>
					<label for='manager_name'>Name: </label>
					<input type='text' class='form-control' id='manager_name' name='manager_name'>
				  </div>
				  <div class='form-group'>
					<label for='manager_address'>Address: </label>
					<input type='text' class='form-control' id='manager_address' name='manager_address'>
				  </div>
				  <div class='form-group'>
					<label for='manager_contact'>Contact: </label>
					<input type='text' class='form-control' id='manager_contact' name='manager_contact'>
				  </div>				  
				  <div class='form-group'>
					<input style='background:black;color:white;' type='submit' class='form-control' value='Submit' name='manager_submit'>
				  </div>
				</form>
			</div>
			<div class='col-md-3'>
			</div>
		</div>
	</div>	
	
	</div>

</div>
</body>
</html>