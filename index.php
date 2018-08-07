<?php
include('common/config.php');
if(!isset($_SESSION['username']))
{
	header('location:login.php');
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
      <?php
        $data=$p->prepare("SELECT count(*) as title FROM membership");
        $data->execute();
        $row=$data->fetch();
    ?>
      <section id="main-content">
          <section class="wrapper">
              <!--state overview start-->
              <div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="icon-tags"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $row['title']; ?>
                              </h1>
                              <p>Membership Plan</p>
                          </div>
                      </section>
                  </div>
                  <?php
        $data=$p->prepare("SELECT count(*) as name FROM registration");
        $data->execute();
        $row=$data->fetch();
    ?>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="icon-user"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $row['name'];?>
                              </h1>
                              <p>Members</p>
                          </div>
                      </section>
                  </div>
                  <?php
        $data=$p->prepare("SELECT sum(  remaining_amount ) as rem_amount FROM registration");
        $data->execute();
        $row=$data->fetch();
    ?>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="icon-inr"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $row['rem_amount'];?>
                              </h1>
                              <p>Total Remaining Amount</p>
                          </div>
                      </section>
                  </div>
                  <?php
                  $cm=date('m');
                  $cy=date('Y');
                
        $data=$p->prepare("SELECT sum( current_amount ) as c_amount FROM payment Where year(paid_on)='$cy' and month(paid_on)='$cm'  ");
        $data->execute();
        $row=$data->fetch();
    ?>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="icon-inr"></i>
                          </div>
                          <div class="value">
                              <h1>
                                 <?php echo $row['c_amount'];?> 
                              </h1>
                              <p><?php echo date('F ,Y'); ?> Collection</p>
                          </div>
                      </section>
                  </div>
              </div>
              <!--state overview end-->

            
                 
                  

        
	   <div class="row">

      
         <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                         Payment Details
                          </header>
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped" id="example">
                                      <thead>
                                      <tr>
                                          
                                          <th>Member Name</th>

                                          <th>Remaining Amount</th>
                                          <th>Current Amount</th>
                                          <th>Paid on</th>
                                         
										   
                                             </tr></thead>
											 <?php
											 $a=1;
											 $m=$p->prepare("SELECT * FROM `payment` order by id desc limit 0,6");
										     $m->execute();
											
											foreach($m->fetchAll() as $r)
                                            {
                     
                                             ?>
											 <tr>
											  <td>
                                          <?php
                                          $c=$r['member_id'];
                                          $gets=$p->prepare("SELECT name FROM registration where id='$c'");
                                          $gets->execute();
                                          $name=$gets->fetch();
                                          echo $name['name'];
										     ?>
										     <td><?php echo $r['remaining_amount'];?></td>
											 <td><?php echo $r['current_amount'];?></td>
											<td><?php echo date('F j,Y',strtotime($r['paid_on'])); ?></td>
                                               </tr>
											<?php
											}
?>											
                          </table>
                                </div>
                          </div>
                      </section>
                  </div>
              </div>
			  <div class="row">

      
         <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                          Recent Members
                          </header>
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped" id="example">
                                      <thead>
                                      <tr>
                                          
                                          <th>Member Name</th>

                                          <th>Member Plan</th>
                                          <th>Current Amount</th>
                                          <th>Date Of Joining</th>
                                         
										     </tr></thead>
											 <?php
											 $a=1;
											 $m=$p->prepare("SELECT * FROM registration order by id desc limit 0,6");
										     $m->execute();
											
											foreach($m->fetchAll() as $r)
                                            {
                     
                                             ?>
											  <tr>
											  <td><?php echo $r['name'];?></td>
                                          
									
											 </td>
											 <td>
											 <?php
                                          $c=$r['plan'];
                                          $gets=$p->prepare("SELECT title FROM membership where id='$c'");
                                          $gets->execute();
                                          $name=$gets->fetch();
                                          echo $name['title'];
										     ?>
											 </td>
										     <td><?php echo $r['amount'];?></td>
											 
											 <td><?php echo date('F j,Y',strtotime($r['doj'])); ?></td>
                                               </tr>
											<?php
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


