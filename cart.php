<?php
session_start(); 
if($_SESSION['user_type']!='member')
{
	header("location: login.php");
}
if(isset($_GET['msg']))
{
	if($_GET['msg']==1)
	{
		echo "<script>alert('Book was successfully returned.');</script>";
	}
}
$mem_id=$_SESSION['mem_id'];
include 'conn.php';
$sql="SELECT * from borrow WHERE mem_id=".$mem_id." AND return_date='NONE';";
$res=$conn->query($sql);
$n=mysqli_num_rows($res);
if(isset($_POST['return_submit']))
{
	$fine=0;
	$borrow_id=$_POST['borrow_id'];
	$sql="SELECT * FROM borrow WHERE borrow_id=".$borrow_id.";";
	$res=$conn->query($sql);
	$row=mysqli_fetch_assoc($res);
	$book_id=$row['book_id'];
	$due_date= DateTime::createFromFormat('d-m-Y',$row['due_date']);
	$datetime = new DateTime();
	$return_date=$datetime->format('d-m-Y');
	$return_date= DateTime::createFromFormat('d-m-Y',$return_date);
	$difference = $due_date->diff($return_date);	
	$days=$difference->format('%a');
	$sign=$difference->format('%R');
	if($sign=='+')
	{
		$fine=2*$days;
	}
	$datetime = new DateTime();
	$return_date=$datetime->format('d-m-Y');
	$sql="UPDATE borrow SET return_date='".$return_date."',fine=".$fine." where borrow_id=".$borrow_id.";";
	$conn->query($sql);
	$sql="SELECT * FROM book where book_id=".$book_id.";";
	$res=$conn->query($sql);
	$row=mysqli_fetch_assoc($res);
	$available=$row['available'];
	$available++;
	$sql="UPDATE book SET available=".$available." WHERE book_id=".$book_id.";";
	$conn->query($sql);
	header("location: cart.php?msg=1&fine=".$fine);
	}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Library/member</title>
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
      <a class="navbar-brand"><span style='color:lightblue'>Library Management</span></a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="member.php">Add Books</a></li>
      <li class="active"><a>My Cart <span class="badge"><?php echo $n; ?></span></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
         <li><a href="logout.php"><span style='color:red'><span class="glyphicon glyphicon-log-out"></span> Log Out</span></a></li>
    </ul>
  </div>
</nav>
<div class='container'>
  <table class="table table-bordered th, .table-bordered td { border: 1px solid #ddd!important }">
    <thead>
      <tr>
        <th>Book</th>
        <th>Issue Date</th>
        <th>Due Date</th>
		<th>CART</th>
      </tr>
    </thead>
    <tbody>
<?php
$sql="SELECT borrow.borrow_id,book.title,borrow.issue_date,borrow.due_date from borrow inner join book on borrow.book_id=book.book_id WHERE mem_id=".$mem_id." AND return_date='NONE';";
$res=$conn->query($sql);
while($row=mysqli_fetch_assoc($res))
{
?>
      <tr>
        <td><?php echo $row["title"]; ?></td>
        <td><?php echo $row["issue_date"]; ?></td>
        <td><?php echo $row["due_date"]; ?></td>
		<td><button type="button" class="btn btn-primary" onclick="returnCart('<?php echo $row["borrow_id"]; ?>')">Return</button></td>
      </tr>
<?php
}
?>
    </tbody>
  </table>
</div>
</body>
</html>
<script>
function returnCart(id)
{
		form=document.createElement('form');
		form.setAttribute('action','cart.php');
		form.setAttribute('method','POST');
		i1=document.createElement('input');
		i1.setAttribute('name','borrow_id');
		i1.setAttribute('type','text');
		i1.setAttribute('value',id);
		i2=document.createElement('input');
		i2.setAttribute('name','return_submit');
		i2.setAttribute('type','submit');
		form.appendChild(i1);
		form.appendChild(i2);
		i2.click();
}
</script>