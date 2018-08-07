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
$image=$_REQUEST['image']['name'];
$path="common/uploads/";	
$targetPath=$path.$img;
move_uploaded_file($_FILES["image_name"]["tmp_name"], $targetPath); 
$doj=$_REQUEST['doj']; 

if(!empty($name) && ($email!="")  && ($con!="") && ($address!="") && ($image!="") && ($doj!=""))     
{
$up=$p->prepare("INSERT INTO registration(name,email,contact,address,image,doj) values('$name','$email','$con','$address','image','$doj')");
$up->execute();
$msg="Added successfully";
}
else
{
  $msg="All field";
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

    <script>window.location='member_registration.php'</script>
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
$image=$_REQUEST['image']; 
$doj=$_REQUEST['doj']; 


    $inCls=$p->prepare("UPDATE registration SET name='$name',email='$email',contact='$con',address='$address',doj='$doj' WHERE id='$rid'");
    $inCls->execute();
     $_SESSION['sucMsg']="Updated Successfully";
    ?>

     <script>window.location='member_registration.php'</script>
  <?php
 exit;
 break;
  }
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
             

            <div class="row">
      
         <div class="col-lg-12">
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
        $data=$p->prepare("SELECT * FROM registration WHERE id='$id'");
        $data->execute();
        $row=$data->fetch();
        ?>
        
         <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Registration</h2>
        <div class="login-wrap">
            
          
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']; ?>"autofocus/>
             <input type="text" class="form-control" name="s_name" value="<?php echo $row['name']; ?>" placeholder="DOB" autofocus/>
            
             <input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>" placeholder="Email" autofocus/>
             
             <input type="text" class="form-control" name="contact" value="<?php echo $row['contact']; ?>" placeholder="Contact" autofocus/>
             <input type="text" class="form-control" name="address" value="<?php echo $row['address']; ?>" placeholder="Address" autofocus/>
			  <input type="text" class="form-control" name="image" value="<?php echo $row['image']; ?>" placeholder="Image" autofocus/>
			  
             <input type="text" class="form-control" name="dob" value="<?php echo $row['doj']; ?>" placeholder="Date Of joining" autofocus/>
             

            <button class="btn btn-lg btn-login btn-block" type="submit" name="update">Update</button>
              </div>
        
         </form>
         <?php
       }
       else
       {
       ?>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Form Elements
                          </header>
                          <div class="panel-body">
                              <form class="form-horizontal tasi-form" method="get">
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Default</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Help text</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control">
                                          <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Rounder</label>
                                      <div class="col-sm-10">
                                          <input type="text" class="form-control round-input">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Input focus</label>
                                      <div class="col-sm-10">
                                          <input class="form-control" id="focusedInput" type="text" value="This is focused...">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Disabled</label>
                                      <div class="col-sm-10">
                                          <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Placeholder</label>
                                      <div class="col-sm-10">
                                          <input type="text"  class="form-control" placeholder="placeholder">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-2 col-sm-2 control-label">Password</label>
                                      <div class="col-sm-10">
                                          <input type="password"  class="form-control" placeholder="">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-lg-2 col-sm-2 control-label">Static control</label>
                                      <div class="col-lg-10">
                                          <p class="form-control-static">email@example.com</p>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
                      <section class="panel">
                          <div class="panel-body">
                              <form class="form-horizontal tasi-form" method="get">
                                  <div class="form-group has-success">
                                      <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Input with success</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="inputSuccess">
                                      </div>
                                  </div>
                                  <div class="form-group has-warning">
                                      <label class="col-sm-2 control-label col-lg-2" for="inputWarning">Input with warning</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="inputWarning">
                                      </div>
                                  </div>
                                  <div class="form-group has-error">
                                      <label class="col-sm-2 control-label col-lg-2" for="inputError">Input with error</label>
                                      <div class="col-lg-10">
                                          <input type="text" class="form-control" id="inputError">
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
					  </div>
					  </div>
					  </div>
             
             
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
											<th>Action</th>
                                          
                                          
                                        
                                    
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
										  <td><img src="common/uploads/<?php echo $rt['image']; ?>" style="width:150px;height:100px"></td>
                                          <td><?php echo $rt['doj']; ?></td>
                                          
                    
                                          <td> 
                      
                         <a class="btn btn-xs btn-info" href="member_registration.php?mode=edit&id=<?php echo base64_encode($rt['id']); ?>">Edit</a>
                        
                         
                        
                       <a class="btn btn-xs btn-danger"  onclick="return confirm('Are you sure?')" href="member_registration.php?mode=delete&id=<?php echo base64_encode($rt['id']); ?>">Delete</a>
                      
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
                      <!--weather statement end-->
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
