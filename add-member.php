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
  ?>

    <script>window.location='registration.php'</script>
    <?php
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
        <?php
      if((isset($_REQUEST['mode'])) &&  ($_REQUEST['mode']=='edit'))
      {
        $id=base64_decode($_REQUEST['id']);
        $data=$p->prepare("SELECT * FROM registration WHERE id='$id'");
        $data->execute();
        $row=$data->fetch();
        ?>
		<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Member Registration  Form
                          </header>
                          <div class="panel-body">
                             
                              <form class="form-horizontal" id="default" action="" enctype="multipart/form-data" method="post">
                                    <input type="hidden" value="<?php echo $row['id']?>" name="rowid">
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Full Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="name"  value="<?php echo $row['name'];?>" class="form-control" placeholder="Full Name">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Email Address</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="email"  value="<?php echo $row['email'];?>" class="form-control" placeholder="Email Address">
                                          </div>
                                      </div>
                                     

                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Phone</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="contact"  value="<?php echo $row['contact'];?>" class="form-control" placeholder="Phone">
                                          </div>
                                      </div>
                                     
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Address</label>
                                          <div class="col-lg-10">
                                              <textarea class="form-control"   name="address" cols="60" rows="5"> <?php echo $row['address'];?> </textarea>
                                          </div>
                                      </div>
									  <div class="form-group">
                                     <label class="col-lg-2 control-label">Image</label>
									  <div class="col-lg-10">
                                      <input type="file" name="image"   id="exampleInputFile">
                                    </div>
                                  </div>
								 
                                    <div class="form-group">
                                  <label class="col-lg-2 control-label">Date Of Joining</label>
                                   <div class="col-lg-10">
                                      <input class="form-control form-control-inline input-medium default-date-picker" name="doj" size="16" type="text"value="<?php echo $row['doj'];?>" />
                                      <span class="help-block">Select date</span>
                                  </div>
                              </div>
									   <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Membership Plan</label>
                                      <div class="col-lg-10">
                                          <select name="plan"  id="mId" onchange="memAcount(this.value)" class="form-control">
                                            <option value=""></option>
                                            <?php
                                            $b=$p->prepare("SELECT * FROM membership");
                                            $b->execute();
                                            $r=$b->fetchAll();
                                            foreach($r as $n)
                                            {
                                              ?>
                                              <option value="<?php echo $n['id']; ?>"><?php echo $n['title']; ?></option>
                                            <?php
                                            }
                                            ?>
                                          </select>
                                         </div>
										 </div>
										 <div class="form-group">
                                  <label class="col-lg-2 control-label">Amount</label>
                                   <div class="col-lg-10">
                                      <input class="form-control" name="amount" id="total_amount" type="text" value="<?php echo $n['id']; ?>" readonly />
                                      
                                  </div>
                              </div>
							        <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button type="submit" name="update" class="btn btn-danger">Update</button>
                                      </div>
                                  </div>
                      
  </form>
  </div>
  </div>
  <?php
	  }
  
else
{
	?>
	 
            <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
					  
                          <header class="panel-heading">
                             Member Registration  Form
                          </header>
                          <div class="panel-body">
                              
                              <form class="form-horizontal" id="default" action="" enctype="multipart/form-data" method="post">
                                  <fieldset title="Step1" class="step" id="default-step-0">
                                      <legend> </legend>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Full Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="name" class="form-control" placeholder="Full Name">
                                          </div>
                                      </div>
                          
						  <div class="form-group">
                                          <label class="col-lg-2 control-label">Email Address</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="email" class="form-control" placeholder="Email Address">
                                          </div>
                                      </div>
                                     


                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Phone</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="contact" class="form-control" placeholder="Phone">
                                          </div>
                                      </div>
                                     
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Address</label>
                                          <div class="col-lg-10">
                                              <textarea class="form-control" name="address" cols="60" rows="5"></textarea>
                                          </div>
                                      </div>
									  <div class="form-group">
                                     <label class="col-lg-2 control-label">Image</label>
									  <div class="col-lg-10">
                                      <input type="file" name="image" id="exampleInputFile">
                                    </div>
                                  </div>
                                    <div class="form-group">
                                  <label class="col-lg-2 control-label">Date Of Joining</label>
                                   <div class="col-lg-10">
                                      <input class="form-control form-control-inline input-medium default-date-picker" onblur="memAcount()" name="doj" size="16" id="doj" type="text" value="" />
                                      <span class="help-block">Select date</span>
                                  </div>
                              </div>
							 <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">plan</label>
                                      <div class="col-lg-10">
                                          <select name="plan"  id="mId" onchange="memAcount()" class="form-control">
                                            <option value="">Select membership plan</option>
                                            <?php
                                            $b=$p->prepare("SELECT * FROM membership");
                                            $b->execute();
                                            $r=$b->fetchAll();
                                            foreach($r as $n)
                                            {
                                              ?>
                                              <option value="<?php echo $n['id']; ?>"><?php echo $n['title']; ?></option>
                                            <?php
                                            }
                                            ?>
                                          </select>
                                         </div>
                                      </div>
                         
						  <div class="form-group">
                                  <label class="col-lg-2 control-label">Amount</label>
                                   <div class="col-lg-10">
                                      <input class="form-control" name="amount" id="total_amount" type="text" value="" readonly />
                                      
                                  </div>
                              </div>
							  
							   <div class="form-group">
                                  <label class="col-lg-2 control-label">Expiry date</label>
                                   <div class="col-lg-10">
                                      <input class="form-control" name="expiry_date" id="expiry_date" type="text" value="" readonly />
                                      
                                  </div>
                              </div>
							  
			                          <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button type="submit" name="submit" class="btn btn-danger">Save</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
						  </div>
						  </div>
						  
		<?php
}
?>
	  
 

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
