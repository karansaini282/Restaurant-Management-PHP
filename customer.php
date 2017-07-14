<?php
session_start(); 
if($_SESSION['user_type']!='member')
{
	header("location: login.php");
}
include 'conn.php';
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Restaurant/customer</title>
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
      <a class="navbar-brand"><span style='color:green;'>Restaurant Management</span></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a><span style='color:yellow;'>Order</span></a></li>      
    </ul>
    <ul class="nav navbar-nav navbar-right">
         <li><a href="logout.php"><span style='color:red'><span class="glyphicon glyphicon-log-out"></span> Log Out</span></a></li>
    </ul>
  </div>
</nav>
<div class='container' style='background:lightgrey;'>
<div class='row'>
<div class='col-sm-6'>
  <table class="table table-bordered th, .table-bordered td { border: 1px solid #ddd!important }">
    <thead>
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
		<th>Category</th>
		<th>ADD</th>
		<th>DEL</th>
      </tr>
    </thead>
    <tbody id='table_items'>
<?php
$sql="SELECT items.name,items.price,items.description,items.item_id,category.name as cname from items inner join category on items.category_id=category.category_id;";
$res=$conn->query($sql);
while($row=mysqli_fetch_assoc($res))
{
?>
      <tr id='items<?php echo $row["item_id"]; ?>'>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["price"]; ?></td>
        <td><?php echo $row["description"]; ?></td>
		<td><?php echo $row["cname"]; ?></td>
		<td><button type="button" class="btn btn-success" onclick="addItem('<?php echo $row["item_id"]; ?>')">ADD</button></td>
		<td><button type="button" class="btn btn-danger" onclick="removeItem('<?php echo $row["item_id"]; ?>')">DEL</button></td>
      </tr>
<?php
}
?>
    </tbody>
  </table>
</div>
<div class='col-sm-2'>
	<div class="btn-group-vertical">
	<button type="button" class="btn btn-primary" onclick="placeOrder()">Place Order</button>
	<button type="button" class="btn btn-info" onclick="placeOrder()">Item <span id='total_no' class="badge">0</span></button>
	<button type="button" class="btn btn-info" onclick="placeOrder()">Total <span id='total_cost' class="badge">0</span></button>
	</div>
</div>
<div class='col-sm-4'>
  <table class="table table-bordered th, .table-bordered td { border: 1px solid #ddd!important }">
    <thead>
      <tr>
	    <th>Item Id</th>
        <th>Name</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody  id='table_cart'>
	</tbody>
  </table>
</div>
  
</div>

</div>
</body>
</html>
<script>
function addItem(id)
{
	tn=document.getElementById('total_no');
	tc=document.getElementById('total_cost');
	tr=document.getElementById('items'+id);
	td=tr.getElementsByTagName('td');
	name=td[0].innerHTML;
	price=td[1].innerHTML;
	tr=document.createElement('tr');
	td1=document.createElement('td');
	td2=document.createElement('td');
	td3=document.createElement('td');
	td1.textContent=id;
	td2.textContent=name;
	td3.textContent=price;
	tr.appendChild(td1);
	tr.appendChild(td2);
	tr.appendChild(td3);
	tb=document.getElementById('table_cart');
	tb.appendChild(tr);
	tn.textContent=parseInt(tn.textContent)+1;
	tc.textContent=parseInt(tc.textContent)+parseInt(price);
}
function removeItem(id)
{
	tb=document.getElementById('table_cart');
	tr=tb.getElementsByTagName('tr');
	if(tr.length==0)
	{
		window.alert("No order has been placed.");
	}
	else
	{
		for(i=0;i<tr.length;i++)
		{
			s=0;
			td=tr[i].getElementsByTagName('td');
			if(td[0].innerHTML==id)
			{
				tb.removeChild(tr[i]);
				tn.textContent=parseInt(tn.textContent)-1;
				tc.textContent=parseInt(tc.textContent)-parseInt(td[2].innerHTML);
				s++;
				break;
			}
		}
		if(s==0)
		{
			window.alert("No order has been placed.");
		}
	}
}
function placeOrder()
{
	tb=document.getElementById('table_cart');
	tr=tb.getElementsByTagName('tr');
	if(tr.length==0)
	{
		window.alert("No order has been placed.");
	}
	else
	{
		form=document.createElement('form');
		form.setAttribute('action','bill.php');
		form.setAttribute('method','POST');
		for(i=0;i<tr.length;i++)
		{
			td=tr[i].getElementsByTagName('td');
			i1=document.createElement('input');
			i1.setAttribute('name','item'+i);
			i1.setAttribute('type','text');
			i1.setAttribute('value',td[0].innerHTML);
			form.appendChild(i1);
		}
		i1=document.createElement('input');
		i1.setAttribute('name','bill_submit');
		i1.setAttribute('type','submit');
		form.appendChild(i1);
		i1.click();
	}
}
</script>