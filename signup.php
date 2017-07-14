<?php
include 'conn.php';
if(isset($_POST['submit']))
{
$username=$_POST['username'];
$pass=$_POST['pass'];
$pass2=$_POST['pass2'];
$user_type='member';
$name=$_POST['name'];
$address=$_POST['address'];
$contact=$_POST['contact'];
if($pass!=$pass2)
{
	echo "<script>alert('The passwords do not match');</script>";
}
else
{
	$sql="INSERT INTO admin (username,pass,user_type) VALUES ('".$username."','".md5($pass)."','".$user_type."')";
	$conn->query($sql);
	$user_id=$conn->insert_id;
	$sql2="INSERT INTO customer (user_id,address,name,contact) VALUES (".$user_id.",'".$address."','".$name."','".$contact."')";
	$conn->query($sql2);
	header("location: login.php?msg=1");
}

$conn->close();
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Restaurant/signup</title>
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
      <li><a href="login.php"><span style='color:yellow'>Login</span></a></li>
      <li class="active"><a><span style='color:yellow'>Signup</span></a></li>
    </ul>
  </div>
</nav>
<div class='container'>
<div class='row'>
	<div class='col-sm-3'>
	</div>
	<div class='col-sm-6'>
		<form role='form' method='POST' action='signup.php'>
		  <div class='form-group'>
			<label for='username'>Username: </label>
			<input type='text' class='form-control' id='username' name='username'>
		  </div>
		  <div class='form-group'>
			<label for='pass'>Password: </label>
			<input type='password' class='form-control' id='pass' name='pass'>
		  </div>
		  <div class='form-group'>
			<label for='pass2'>Re-Type Password: </label>
			<input type='password' class='form-control' id='pass2' name='pass2'>
		  </div>
		  <div class='form-group'>
			<label for='name'>Name: </label>
			<input type='text' class='form-control' id='name' name='name'>
		  </div>
		  <div class='form-group'>
			<label for='address'>Address: </label>
			<input type='text' class='form-control' id='address' name='address'>
		  </div>
		  <div class='form-group'>
			<label for='contact'>Contact: </label>
			<input type='text' class='form-control' id='contact' name='contact'>
		  </div>
		  <div class='form-group'>
		    <input style='background:black;color:white;' type='submit' class='form-control' value='Submit' name='submit'>
		  </div>
		</form>
	</div>
	<div class='col-sm-3'>
	</div>
</div>
</div>
</body>
</html>