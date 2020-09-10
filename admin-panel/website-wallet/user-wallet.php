<br><br>
<div class="content-box">
		<?php
if($_GET['subcat']=='add-user-profile'){

	if(!empty($_GET['edit'])){

   $editId= $_GET['edit'];
   $query="SELECT * FROM user_wallet WHERE id=$editId";
   $res= $conn->query($query);
   $editData=$res->fetch_assoc();
   $fullName=$editData['full_name'];
   $email=$editData['email'];
   $mobile=$editData['mobile'];
   $address=$editData['address'];
   $password=$editData['password'];

   
   $idAttr="updateForm";


   
}else{

   $fullName="";
   $email="";
   $mobile="";
   $address="";
   $password="";
   $editId='';
   $idAttr="adminForm";

}
?>
  <div class="row">
		<div class="col">
			<h3>User Wallet</h3>
		</div>
		<div class="col text-right">
			<a href="dashboard.php?cat=website-user&subcat=user-wallet" class="btn btn-secondary content-link">View</a>
		</div>
	</div>
<br>
<form id="<?php echo $idAttr; ?>" rel="<?php echo $editId; ?>" name="user_profile">
<div class="row">
	<div class="col">
		<div class="form-group">
			<label>Full Name</label>
			<input type="text" placeholder="Full Name" class="form-control" name="full_name" value="<?php echo $fullName; ?>">
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Email</label>
			<input type="text" placeholder="Email" class="form-control" name="email" value="<?php echo $email; ?>">
		</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="form-group">
			<label>Mobile Number</label>
			<input type="text" placeholder="Mobile Number" class="form-control" name="mobile" value="<?php echo $mobile; ?>">
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Address</label>
			<input type="text" placeholder="City" class="form-control" name="address" value="<?php echo $address; ?>">
		</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="form-group">
			<label>Password</label>
			<input type="password" placeholder="Password" class="form-control" name="password">
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Confirm Password</label>
			<input type="password" placeholder="Password" class="form-control" name="cpassword">
		</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="form-group">
			<button class="btn btn-secondary">Save</button>
		</div>
	</div>
	<div class="col">
		
	</div>
</div>
</form>
<?php } elseif (!empty($_GET['view'])) {?>
	
<?php 

   $id= $_GET['view'];
   $query="SELECT * FROM user_wallet WHERE id=$id";
   $res= $conn->query($query);
   $viewData=$res->fetch_assoc();

   

   $backId=$viewData['id']-1;

   $uid = $viewData['user_id'];

   $queryy="SELECT * FROM user_profile WHERE id=$uid";
   $ress= $conn->query($queryy);
   $viewDatas=$ress->fetch_assoc();


   $fullName=$viewDatas['full_name'];
   $amount=$viewData['amount'];
   $transactionid=$viewData['transaction_id'];
   $date=$viewData['created_at'];
   
   ?>
<div class="row">
	<div class="col">
		<h4>User Wallet</h4>
	</div>
	<div class="col text-right">
		<a href="dashboard.php?cat=website-wallet&subcat=user-wallet" class="btn btn-secondary content-link">Back</a>
	</div>
</div>
<br>
<div class="table-responsive">
	<table class="table">
		<tr>
			<th>User Name -</th><td><?php echo $fullName; ?></td>
		</tr>
		<tr>
			<th>Transaction Id -</th><td><?php echo $transactionid; ?></td>
		</tr>
		<tr>
			<th>Amount -</th><td><?php echo $amount; ?></td>
		</tr>
		<tr>
			<th>Date -</th><td><?php echo $date; ?></td>
		</tr>
		
</div>
   <?php
   
 }else {?>


<!-----=================table content start=================-->
	
	<div class="row">
		<div class="col">
			<h4>User Wallet</h4>
		</div>
		<div class="col text-right">
			<!-- <a href="dashboard.php?cat=website-user&subcat=add-user-profile" class="btn btn-secondary content-link"> Add New</a> -->
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col">
	<div class="table-responsive">
		<table class="table">
			<tr>
				<th>S.N</th>
				<th>User Name</th>
				<th>Transaction Id</th>
				<th>Amount</th>
				<th>Date</th>
				<th>Status</th>
				<th>View</th>
				<!-- <th>Edit</th> -->
				<th>Delete</th>
				
			</tr>
			<?php
  $sql1="SELECT * FROM user_wallet ORDER BY id DESC";
  $res1= $conn->query($sql1);
  if($res1->num_rows>0)
  {$i=1;
   while($data=$res1->fetch_assoc()){
   	$uid = $data['user_id'];
   	
    $sql11="SELECT * FROM user_profile WHERE id=$uid";
    $res11= $conn->query($sql11);
    $datad=$res11->fetch_assoc()
   	?>
   	<tr>
   		<td><?php echo $i; ?></td>
   		<td><?php echo $datad['full_name']; ?></td>
   		<td><?php echo $data['transaction_id']; ?></td>
   		<td><?php echo $data['amount']; ?></td>
   		<td><?php echo $data['created_at']; ?></td>
    <td>
   			
   			<?php
   			if($data['status']==0){
   			?>
   			<a href="javascript:void(0)" name="user_profile" class=" text-secondary userRole"  rel="<?php echo $data['id']; ?>">
   			<i class='fas fa-user-alt-slash iconRole'></i>
   		<?php } else{ ?>
   			<a href="javascript:void(0)" name="user_profile" class=" text-success userRole"  rel="<?php echo $data['id']; ?>">
              <i class='fas fa-user-alt iconRole'></i>
   		<?php } ?>
   	
   		</a></td>
   		<td><a  href="dashboard.php?cat=website-wallet&subcat=user-wallet&view=<?php echo $data['id']; ?>" class="text-secondary content-link"><i class='far fa-eye'></i></a></td>

        <!-- <td><a href="dashboard.php?cat=website-admin&subcat=add-admin-profile&edit=<?php echo $data['id']; ?>" class="text-success content-link"><i class=' far fa-edit'></i></a></td> -->

        <td><a href="javascript:void(0)" class="text-danger delete"  name="user_profile" id="<?php echo $data['id']; ?>"><i class='far fa-trash-alt'></i></a></td>

   	</tr>
   	<?php
   $i++;}
}else{

?>
<tr>
	<td colspan="6">No User Wallet Data</td>
</tr>
<?php } ?>
			
		</table>
	</div>
</div>
</div>
	<!-----==================table content end===================-->
<?php } ?>

</div>