<?php
include('common/config.php');

if(!isset($_SESSION['username']))
{
  header('location:login.php');
}
if(isset($_REQUEST['submit']))
{
$name=$_REQUEST['name'];      
$email=$_REQUEST['email'];    
$con=$_REQUEST['contact'];   
$address=$_REQUEST['address'];
$expiry_date=$_REQUEST['expiry_date'];
$img=$_FILES['image']['name']; 

$doj=$_REQUEST['doj'];
$pieces = explode('-', $doj);
	 
$date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
$plan=$_REQUEST['plan']; 
$amount=$_REQUEST['amount']; 
if(!empty($name) && ($email!="")  && ($con!="") && ($address!="") && ($img!="") && ($date!="") &&  ($plan!="") &&($amount!=""))     
{
	
$path="common/uploads/";	
$targetPath=$path.$img;
move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);

$del=$p->prepare("SELECT * FROM registration ORDER BY id DESC LIMIT 1");
$del->execute();
$rowCount=$del->rowCount();
if($rowCount!=0)
{
	$rd=$del->fetch();
	$previnvoiceNo=$rd['invoice_no'];
	$exInv=explode('-',$previnvoiceNo);
	$sr=$exInv[1];
	$invLast = $sr + 1;
	
}
else
{ 
  $invLast="1";
}

$invoiceNo="INV-".$invLast;

$up=$p->prepare("INSERT INTO registration(invoice_no,name,email,contact,address,image,doj,plan,amount,expiry_date,remaining_amount) values('$invoiceNo','$name','$email','$con','$address','$img','$date','$plan','$amount','$expiry_date','$amount')");
$up->execute();
 $_SESSION['sucMsg']="Added successfully";
}
else
{
   $_SESSION['sucMsg']="All field required";
}
}
if(isset($_REQUEST['mode']))
{
  $mode=$_REQUEST['mode'];

   switch($mode)

{
   case "delete":
     
     $id=base64_decode($_REQUEST['id']);
     $del=$p->prepare("delete FROM registration WHERE id='$id'");
     $del->execute();
     
     $_SESSION['sucMsg']="Deleted Successfully";
     ?>

    <script>window.location='registration.php'</script>
    <?php
    exit;
    
   break;
   case "edit":
 $id=base64_decode($_REQUEST['id']);
if(isset($_REQUEST['update']))
{
    $rid=($_REQUEST['id']);
    
$name=$_REQUEST['name'];      
$email=$_REQUEST['email'];    
$con=$_REQUEST['contact'];   
$address=$_REQUEST['address'];
$img=$_FILES['image']['name']; 
$doj=$_REQUEST['doj'];
 $pieces = explode('-', $doj);
	 
	 $date=$pieces[2]."-".$pieces[0]."-".$pieces[1];
$plan=$_REQUEST['plan']; 

$amount=$_REQUEST['amount']; 

if(!empty($img))
{
	$path="common/uploads/";	
    $targetPath=$path.$img;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);
    $inCls=$p->prepare("UPDATE registration SET image='$img' WHERE id='$id'");
    $inCls->execute();
	
}
if(!empty($name) && ($email!="")  && ($con!="") && ($address!="") && ($date!="") &&  ($plan!="") &&($amount!=""))     
{

    $inCls=$p->prepare("UPDATE registration SET name='$name',email='$email',contact='$con',address='$address',doj='$date',plan='$plan',amount='$amount' WHERE id='$id'");
    $inCls->execute();
     $_SESSION['sucMsg']="Updated Successfully";
    ?>

     <script>window.location='registration.php'</script>
  <?php
 exit;
}
 break;
  }
 }

  
}

?><!DOCTYPE html>
<html lang="en">
  <head>
   
   <?php include('common/css.php'); ?>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
   
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
        
 <div class="row">

      
         <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                          Member Details
                          </header>
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped" id="example">
                                      <thead>
                                      <tr>
                                          
                                          <th>Name</th>

                                          <th>Email</th>
                                          
                                          <th>Contact</th>
                                          <th>Address</th>
										   <th>Image</th>
										    <th>Date Of Joining</th>
											<th>Membership Plan</th>
											<th>Amount</th>
											<th>Action</th>
											<th>Payment</th>
										    <th>Payment Status</th>
                                          
                                          
                                        
                                    
                                      </tr>
                                      </thead>
                                      <tbody>
                    <?php
                    $a=1;
                    $getSub=$p->prepare("SELECT * FROM registration");
                    $getSub->execute();
                    foreach($getSub->fetchAll() as $rt)
                    {
                     
                    ?>
                                      <tr class="gradeX">
                                        <td><?php echo $rt['name']; ?></td>
                                        
                                        <td><?php echo $rt['email']; ?></td>
                                       
                                        <td><?php echo $rt['contact']; ?></td>
                                          <td><?php echo $rt['address']; ?></td>
										  
										  <td><img src="common/uploads/<?php echo $rt['image']; ?>" class="img-responsive"></td>
                                          <td><?php echo $rt['doj']; ?></td>
										 
                                     
                                         <td>
                                          <?php
                                          $c=$rt['plan'];
                                          $gets=$p->prepare("SELECT title FROM membership where id='$c'");
                                          $gets->execute();
                                          $name=$gets->fetch();
                                          echo $name['title'];
                                          ?>
                                        </td>
										<td><?php echo $rt['amount']; ?><br/>
										<b>Expiry Date : </b> <?php echo date('F j,Y',strtotime($rt['expiry_date'])); ?>
										
										</td>
                                          
                    
                                          <td> 
                      
                         <a class="btn btn-xs btn-info" href="add-member.php?mode=edit&id=<?php echo base64_encode($rt['id']); ?>">Edit</a>
                        
                         
                        
                       <a class="btn btn-xs btn-danger"  onclick="return confirm('Are you sure?')" href="registration.php?mode=delete&id=<?php echo base64_encode($rt['id']); ?>">Delete</a>
					   <br/><br/>
					   <?php
					   $ex_date=$rt['expiry_date'];
					   $cDate=date('Y-m-d');
					   if($ex_date < $cDate)
					   {
						   ?>
						    <a class="btn btn-xs btn-danger">Expired</a>
						   <?php
					   }
					   ?>
                      
                      </td>
					  <td><a class="btn btn-xs btn-info" href="payment.php?id=<?php echo base64_encode($rt['id']); ?>">Payment</a></td>
                        
                                          <td> <?php
					   $pay_status=$rt['payment_status'];
					  
					   if($pay_status==1)
					   {
						   ?>
						    <a class="btn btn-xs btn-danger">Paid</a>
						   <?php
					   }
					   else
					   {
					   ?>
					   
						 
						    <a class="btn btn-xs btn-success">Unpaid</a>
						   <?php
					   }
					   ?></td> 
                      
                                         
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
	  <script>
	 function memAcount()
	{
		var rid=$('#mId').val();
		var dj=$('#doj').val();
		if(dj!="")
		{
		$.ajax({
		  type: "POST",
		  url: "ajax.php",
		  cache: false,
		  data: "doj="+ dj +"&cid="+ rid +"&mode=memAcount",
		  dataType: "json",
		  success: function(dt){
		
                  $('#total_amount').val(dt.amount);
                  $('#expiry_date').val(dt.expiryDate);
                   // window.location='cart.php';
              
			  
			//$("#results").html(html);;
			//$("#results").remove();
		  }
		});
	  }
	  else{
		  alert("Please select Date of joining first");
	  }
	}
</script>
   
	 <?php include('common/footer.php'); ?>
	 
   
    <?php include('common/js.php'); ?>
	     
	  <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  
   
    <script src="js/advanced-form-components.js"></script>
  </body>
</html>
