<?php
include('common/config.php');
if(!isset($_SESSION['username']))
{
  header('location:login.php');
}

if(isset($_REQUEST['mode']))
{
$mode=$_REQUEST['mode'];

switch($mode)
{
	 case "delete":
	   
	   $id=base64_decode($_REQUEST['id']);
	   $del=$p->prepare("delete FROM membership WHERE id='$id'");
	   $del->execute();
	   
	   $_SESSION['sucMsg']="Deleted Successfully";
		?>
		<script>window.location='membership.php'</script>
		<?php
		exit;
		
	 break;

	 
	case "activate":
	   
	   $id=base64_decode($_REQUEST['id']);
	   $del=$p->prepare("UPDATE membership SET status='1' WHERE id='$id'");
	   $del->execute();
	   
	   $_SESSION['sucMsg']="Activated Successfully";
		?>
		<script>window.location='membership.php'</script>
		<?php
		exit;
		
	 break;
	 
	 case "deactivate":
	   
	   $id=base64_decode($_REQUEST['id']);
	   $del=$p->prepare("UPDATE membership SET status='2' WHERE id='$id'");
	   $del->execute();
	   
	   $_SESSION['sucMsg']="Deactivated Successfully";
		?>
		<script>window.location='membership.php'</script>
		<?php
		exit;
		
	 break;
}
}

if(isset($_REQUEST['submit']))
{
	$name=$_REQUEST['title'];
	$amount=$_REQUEST['amount'];
	$dur=$_REQUEST['duration'];
	$dur_type=$_REQUEST['duration_type'];
	
	if((!empty($name)) && ($name!="") && ($amount!="") && ($dur!="") && ($dur_type!=""))
	{
		$inCls=$p->prepare("INSERT INTO membership(title,amount,duration,duration_type) values ('$name','$amount','$dur','$dur_type')");
		$inCls->execute();
		$_SESSION['sucMsg']="Added Successfully";
		?>
		<script>window.location='membership.php'</script>
		<?php
		exit;
	}
	else
	{
		$_SESSION['errMsg']="All fields are required";
		header('location:membership.php');
		exit;
	}
}
if(isset($_REQUEST['update']))
{
  
  $rid=base64_decode($_REQUEST['id']);
  $title=$_REQUEST['title'];
  $amount=$_REQUEST['amount'];
  $dur=$_REQUEST['duration'];
  $dur_type=$_REQUEST['duration_type'];
  
  ?>
  <?php
  
  if((!empty($title)) && ($amount!="") && ($dur!="") && ($dur_type!=""))
  {
    $inCls=$p->prepare("UPDATE membership SET title='$title',amount='$amount',duration='$dur',duration_type='$dur_type' WHERE id='$rid'");
    $inCls->execute();
    $_SESSION['sucMsg']="Updated Successfully";
    ?>
    <script>window.location='membership.php'</script>
    <?php
    exit;
  }
  else
  {
    $_SESSION['errMsg']="All fields are required";
    header('location:membership.hpp');
    exit;
  }
}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
   
   <?php include('common/css.php'); ?>
   
  </head>

  <body>

  <section id="container" >
      <!--header start-->
	  
      <?php include('common/header.php'); ?>
	  
      <!--header end-->
      <!--sidebar start-->
	  
      <?php include('common/sidebar.php'); ?>
	  
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!--state overview start-->
            <div class="row">
			
			
			<div class="col-lg-3">
			</div>
                    <div class="col-lg-6">
					
					<?php
			if(isset($_SESSION['errMsg']))
			{
				?>
				    <div class="alert alert-block alert-danger fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="icon-remove"></i>
                                  </button>
                               <?php echo $_SESSION['errMsg']; ?>
                    </div>
				<?php
				unset($_SESSION['errMsg']);
			}
			?>
			
			<?php
			if(isset($_SESSION['sucMsg']))
			{
				?>
				    <div class="alert alert-block alert-success fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="icon-remove"></i>
                                  </button>
                               <?php echo $_SESSION['sucMsg']; ?>
                    </div>
				<?php
				unset($_SESSION['sucMsg']);
			}
			?>
			
			<?php
			if((isset($_REQUEST['mode'])) &&  ($_REQUEST['mode']=='edit'))
			{
				$id=base64_decode($_REQUEST['id']);
				$data=$p->prepare("SELECT * FROM membership WHERE id='$id'");
				$data->execute();
				$row=$data->fetch();
				?>
                      <section class="panel">
                          <header class="panel-heading">
                              Edit Membership Plan
                          </header>
                          <div class="panel-body">
                              <form class="form-horizontal" role="form" method="POST" action="">
							  
							  <input type="hidden" value="<?php echo $row['id']?>" name="rowid">
							  
                                  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-10">
                                          <input type="text" name="title" value="<?php echo $row['title']?>"class="form-control" id="inputEmail1" placeholder="Title" required >
                                         
                                      </div>
                                  </div>
								  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Amount</label>
                                      <div class="col-lg-10">
                                          <input type="text" name="amount" value="<?php echo $row['amount']?>"class="form-control" id="inputEmail1" placeholder="Amount" required >
                                         
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Duration</label>
                                      <div class="col-lg-10">
                                          <div class="col-lg-6">
                                          <input type="text" name="duration"  value="<?php echo $row['duration'];?>" class="form-control" id="inputEmail1" placeholder="Enter Duration ex,1,3,30" required >
		                                 
                                      </div>
									  
									  <?php
									  $a=$row['duration_type'];
									  ?>
									   <div class="col-lg-6">
									  <select class="form-control" name="duration_type"  value="<?php echo $row['duration_type'];?>"required>
									  <option value="month" <?php  if($a=="month") { echo "selected"; } ?>>Month</option>
									  <option value="days" <?php  if($a=="days") { echo "selected"; } ?>>Days</option>
									
									  </select>
                                  </div>
                                         
                                      </div>
                                  </div>
                                                                    
                                  <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button type="submit" name="update" class="btn btn-danger">Save</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
                     
					 <?php
			}
			else
			{
			?>
                      <section class="panel">
                          <header class="panel-heading">
                              Add Membership Plan
                          </header>
						   <div class="panel-body">
                              <form class="form-horizontal" role="form" method="POST" action="">
                                  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-10">
                                          <input type="text" name="title" class="form-control" id="inputEmail1" placeholder="Title" required >
                                         
                                      </div>
									  </div>
									  
                                 
								  
                              <form class="form-horizontal" role="form" method="POST" action="">
                                  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Amount</label>
                                      <div class="col-lg-10">
                                          <input type="text" name="amount" class="form-control" id="inputEmail1" placeholder="Amount" required >
                                         
                                      </div>
                                  </div>
								  
                          
								   
                              <form class="form-horizontal" role="form" method="POST" action="">
                                  <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Duration</label>
                                      <div class="col-lg-10">
									  <div class="col-lg-6">
                                          <input type="text" name="duration" class="form-control" id="inputEmail1" placeholder="Enter Duration ex,1,3,30" required >
		                                 
                                      </div>
									  <div class="col-lg-6">
									  <select class="form-control" name="duration_type"required>
									  <option value="month" selected>Month</option>
									  <option value="days" >Days</option>
									  </select>
                                  </div>
								  </div>
                                  
                                  <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button type="submit" name="update" class="btn btn-danger">Save</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
                     
					 <?php
					 }
					 ?>
                  </div>
				  <div class="col-lg-3">
			</div>
              </div>

			  
			   <div class="row">
			
			   <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                          Membership List
                          </header>
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped" id="example">
                                      <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Title</th>
                                          <th>Amount</th>
									      <th>Duration</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                    
                                      </tr>
                                      </thead>
                                      <tbody>
									  <?php
									  $a=1;
									  $getClass=$p->prepare("SELECT * FROM membership");
									  $getClass->execute();
									  foreach($getClass->fetchAll() as $rt)
									  {
										  $status=$rt['status'];
										  
									  ?>
                                      <tr class="gradeX">
                                          <td><?php echo $rt['id']; ?></td>
                                          <td><?php echo $rt['title']; ?></td>
										   <td><?php echo $rt['amount']; ?></td>
										   <td><?php echo $rt['duration']; ?> <?php echo $rt['duration_type']; ?></td>
										    
                                         
                                          <td>
										  <?php
										  switch($status)
										  {
											  case "1":
											  ?>
											  <a class="btn btn-xs btn-success" href="membership.php?mode=deactivate&id=<?php echo base64_encode($rt['id']); ?>">Active</a>
											  <?php
											  break;
											  
											  case "2":
											   ?>
											  <a class="btn btn-xs btn-warning" href="membership.php?mode=activate&id=<?php echo base64_encode($rt['id']); ?>">Deactive</a>
											  <?php
											  break;
										  }
										  ?></td>
                                          <td> 
										     <a class="btn btn-xs btn-info" href="membership.php?mode=edit&id=<?php echo base64_encode($rt['id']); ?>">Edit</a> 
											 <a class="btn btn-xs btn-danger"  onclick="return confirm('Are you sure?')" href="membership.php?mode=delete&id=<?php echo base64_encode($rt['id']); ?>">Delete</a>
										  </td>
                                         
                                      </tr>
                                     <?php
									 $a++;
									 }
									 ?>
                          </table>
                                </div>
                          </div>
                      </section>
                  </div>
              </div>
			  
			  
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
     
	 <?php include('common/footer.php'); ?>
	 
      <!--footer end-->
  </section>

    <?php include('common/js.php'); ?>
	
  </body>
</html>
