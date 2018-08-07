<?php
include('common/config.php');

if(!isset($_SESSION['username']))
{
  header('location:login.php');
}

  if(isset($_REQUEST['submit']))
{
 $id=$_REQUEST['rid'];

$com_name=$_REQUEST['c_name'];      
$email=$_REQUEST['email'];    
$phone=$_REQUEST['phone'];   
$adress=$_REQUEST['address'];   
$logo=$_FILES['logo']['name'];

if(!empty($com_name) && ($email!="") && ($phone!="") && ($adress!="") && ($logo!=""))
{
	$path="common/uploads/logo/";	
$targetPath=$path.$logo;
move_uploaded_file($_FILES["logo"]["tmp_name"], $targetPath);
	
  $pay=$p->prepare("INSERT INTO company(company_name,email,phone,address,logo) values ('$com_name','$email','$phone','$adress','$logo')");
  $pay->execute();
  
}
}
if(isset($_REQUEST['mode']))
{
  $mode=$_REQUEST['mode'];
$id=base64_decode($_REQUEST['id']);
if(isset($_REQUEST['update']))
{
    $rid=$_REQUEST['id'];
    
$name=$_REQUEST['c_name'];      
$email=$_REQUEST['email'];    
$phone=$_REQUEST['phone'];
$address=$_REQUEST['address'];

$logo=$_FILES['logo']['name']; 

if(!empty($logo))
{
	$path="common/uploads/logo/";	
   $targetPath=$path.$logo;

    move_uploaded_file($_FILES["logo"]["tmp_name"], $targetPath);
    $inCls=$p->prepare("UPDATE company SET logo='$logo' WHERE id='$rid'");
    $inCls->execute();
	
}
if(!empty($name) && ($email!="")  && ($phone!="") && ($address!=""))     
{

    $inCls=$p->prepare("UPDATE company SET company_name='$name',email='$email',phone='$phone',address='$address' WHERE id='$rid'");
    $inCls->execute();
     $_SESSION['sucMsg']="Updated Successfully";
    ?>

     <script>window.location='company.php'</script>
  <?php

}

  }
 }

?>
<!DOCTYPE html>
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
	  <section id="main-content">
          <section class="wrapper">
	  <?php
      if((isset($_REQUEST['mode'])) &&  ($_REQUEST['mode']=='edit'))
      {
        $id=base64_decode($_REQUEST['id']);
        $data=$p->prepare("SELECT * FROM company WHERE id='$id'");
        $data->execute();
        $row=$data->fetch();
        ?>
		<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                           Company Update
                          </header>
                          <div class="panel-body">
                             
                              <form class="form-horizontal" id="default" action="" enctype="multipart/form-data" method="post">
                                    <input type="hidden" value="<?php echo $row['id']?>" name="id">
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Company Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="c_name"  value="<?php echo $row['company_name'];?>" class="form-control" placeholder="Full Name">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Email</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="email"  value="<?php echo $row['email'];?>" class="form-control" placeholder="Email">
                                          </div>
                                      </div>
                                     

                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Phone</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="phone"  value="<?php echo $row['phone'];?>" class="form-control" placeholder="Phone">
                                          </div>
                                      </div>
                                     
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Address</label>
                                          <div class="col-lg-10">
                                              <textarea class="form-control"   name="address" cols="60" rows="5"> <?php echo $row['address'];?> </textarea>
                                          </div>
                                      </div>
									  <div class="form-group">
                                     <label class="col-lg-2 control-label">Logo</label>
									  <div class="col-lg-10">
                                      <input type="file" name="logo"   id="exampleInputFile">
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
	  ?>
	    <?php
$com=$p->prepare("SELECT * FROM company");
  $com->execute();
 $rowCount=$com->rowCount();
 
if($rowCount==0)
{
 
					  ?>
					  
            <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
					
                          <header class="panel-heading">
                            Company
                          </header>
                          <div class="panel-body">
                              
                              <form class="form-horizontal" onsubmit="return memAcount()" id="default" action="" enctype="multipart/form-data" method="post">
                                   <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label"></label>
                                      <div class="col-lg-10">
                                        <input type="hidden" name="id" id="id"value=""class="form-control">   
                                         </div>
										 </div>
										 
										 
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Company Name</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="c_name" id="cId"  value=""  class="form-control" placeholder="Company Name">
                                          </div>
                                      </div>
                                     
                          
						<div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                      <div class="col-lg-10">
                                            <input class="form-control" name="email" id="mId" type="text" value=""  placeholder="Email" />
                                         </div>
										 </div>
                                     


						<div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Phone</label>
                                      <div class="col-lg-10">
                                            <input class="form-control" name="phone" id="refId" type="text" value="" placeholder="Phone" />
                                         </div>
										 </div>
                                     
									   <div class="form-group">
                                          <label class="col-lg-2 control-label">Address</label>
                                          <div class="col-lg-10">
                                    <input class="form-control" name="address" id="refId" type="text" value="" placeholder="Address" />
                                          </div>
                                      </div>
									   <div class="form-group">
                                          <label class="col-lg-2 control-label">Logo</label>
                                          <div class="col-lg-10">
                                    <input class="form-control"  type="file" name="logo" id="refId" value="" placeholder="Logo" />
                                          </div>
                                      </div>
							  
			                          <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button type="submit" name="submit" class="btn btn-danger">Submit</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
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
                          Company List  
                          </header>
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped" id="example">
                                      <thead>
                                      <tr>
                                        
                                          <th>Company Name</th>

                                         <th>Email</th>
										   
											<th>Phone</th>
											
                                            <th>Address</th> 
                                            <th>Logo</th>											
                                              <th>Action</th>	                                     
                                          
                                        
                                    
                                      </tr>
                                      </thead>
                  
                         
						   <?php
                    $a=1;
                    $getSub=$p->prepare("SELECT * FROM company");
                    $getSub->execute();
                    foreach($getSub->fetchAll() as $rt)
                    {
                     
                    ?>
                                      <tr class="gradeX">
									   <td>
                                          <?php echo $rt['company_name']; ?>
                                        </td>
                                        <td><?php echo $rt['email']; ?></td>
                                        
                                        <td><?php echo $rt['phone']; ?></td>
                                       
                                        <td><?php echo $rt['address']; ?></td>
                                          <td><img src="common/uploads/logo/<?php echo $rt['logo']; ?>" class="img-responsive" style></td>
										  
										 
                                      
                           
                                          <td> 
                      
                         <a class="btn btn-xs btn-info" href="company.php?mode=edit&id=<?php echo base64_encode($rt['id']); ?>">Edit</a>
                        
                         
                        
                     
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
                  </div>
              </div>

             
            
                 
				<?php
				}
?>				

          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
     
	 <?php include('common/footer.php'); ?>
	 
      <!--footer end-->
  

    <?php include('common/js.php'); ?>
	
	     
	  <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  
   
    <script src="js/advanced-form-components.js"></script>
	
  </body>
</html>


