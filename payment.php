<?php
include('common/config.php');
if(!isset($_SESSION['username']))
{
	header('location:login.php');
}

  $id=base64_decode($_REQUEST['id']);
  if(isset($_REQUEST['submit']))
{
 
 $memid=$_REQUEST['mid'];   
$r_amount=$_REQUEST['r_amount'];      
$c_amount=$_REQUEST['c_amount'];    
$paid=$_REQUEST['a'];   
$refid=$_REQUEST['r_id'];   
$time=$_REQUEST['paid_on'];
$pieces = explode('-', $time);
	 
$date=$pieces[2]."-".$pieces[0]."-".$pieces[1];   
if(!empty($r_amount) && ($c_amount!="") && ($refid!="") && ($date!=""))
{
	$curr_amount=$r_amount-$c_amount;
	
  $pay=$p->prepare("INSERT INTO payment(member_id,remaining_amount,current_amount,payment_mode,reference_id,paid_on) values ('$memid','$curr_amount','$c_amount','$paid','$refid','$date')");
  $pay->execute();
  if(($curr_amount<=0) || ($curr_amount==""))
  {
	$pay_status=1;  
  }
  else{
	$pay_status=0;    
  }
  
 $m=$p->prepare("UPDATE registration SET remaining_amount='$curr_amount',payment_status='$pay_status'  WHERE id='$memid'");
 $m->execute();
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
					    $id=base64_decode($_REQUEST['id']);
					    $pay=$p->prepare("SELECT * FROM registration WHERE id='$id'");
  $pay->execute();
  $row=$pay->fetch();
  $paymentStatus=$row['payment_status'];
 if($paymentStatus==0)
 {
					  ?>
					  
            <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
					
                          <header class="panel-heading">
                            Payment
                          </header>
                          <div class="panel-body">
                              
                              <form class="form-horizontal" onsubmit="return memAcount()" id="default" action=""  method="post">
                                   <div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label"></label>
                                      <div class="col-lg-10">
                                        <input type="hidden" name="mid" id="memId"value="<?php echo $row['id']; ?>"class="form-control">   
                                         </div>
										 </div>
										 
										 
                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Remaining Amount</label>
                                          <div class="col-lg-10">
                                              <input type="text" name="r_amount" id="cId"  value="<?php echo $row['remaining_amount']; ?>"  class="form-control" placeholder="Remaining Amount">
                                          </div>
                                      </div>
                                     
                          
						<div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Current Amount</label>
                                      <div class="col-lg-10">
                                            <input class="form-control" name="c_amount" id="mId" onkeyup="memAcount()" type="text" value="" />
                                         </div>
										 </div>
                                     


                                      <div class="form-group">
                                          <label class="col-lg-2 control-label">Payment Mode</label>
                                          <div class="col-lg-10">
										  <div class="radios">
                                          <label class="label_radio col-lg-4 col-sm-4" for="radio-01">
                                          <input name="a" id="radio-01" value="cheque" type="radio" checked /> cheque
                                               </label>
                                           <label class="label_radio col-lg-4 col-sm-4" for="radio-02">
                                       <input name="a" id="radio-02" value="cash" type="radio" /> cash
                                                       </label>
													   <label class="label_radio col-lg-4 col-sm-4" for="radio-02">
                                       <input name="a" id="radio-03" value="online_tranaction" type="radio" /> online transaction
                                                       </label>
                                           </div>
                                             
                                          </div>
										  </div>
										      
						<div class="form-group">
                                      <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Transaction Id</label>
                                      <div class="col-lg-10">
                                            <input class="form-control" name="r_id" id="refId" type="text" value="" />
                                         </div>
										 </div>
                                     
									   <div class="form-group">
                                          <label class="col-lg-2 control-label">Paid On</label>
                                          <div class="col-lg-10">
 <input class="form-control form-control-inline input-medium default-date-picker"  name="paid_on" size="16" id="date" type="text" value="" />
                                          </div>
                                      </div>
							  
			                          <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button type="submit" name="submit" class="btn btn-danger">Pay</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
						  </div>
						  </div>
				<?php
				}
				?>		  
	  
 <div class="row">

      
         <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                          Payment List  <a class="btn btn-xs btn-danger pull-right" href="invoice.php?id=<?php echo base64_encode($row['id']); ?>" target="_blank">Download Invoice</a>
                          </header>
                          <div class="panel-body">
                                <div class="adv-table">
                                    <table  class="display table table-bordered table-striped" id="example">
                                      <thead>
                                      <tr>
                                        
                                          <th>Member</th>

                                         <th>Remaining Amount</th>
										   
											<th>Current Amount</th>
											
                                            <th>Payment Mode</th> 
                                            <th>Transaction Id</th>											
                                            <th>Paid On</th>                                           
                                          
                                        
                                    
                                      </tr>
                                      </thead>
                  
                         
						   <?php
                    $a=1;
                    $getSub=$p->prepare("SELECT * FROM payment WHERE member_id='$id'");
                    $getSub->execute();
                    foreach($getSub->fetchAll() as $rt)
                    {
                     
                    ?>
                                      <tr class="gradeX">
									   <td>
                                          <?php
                                          $c=$rt['member_id'];
                                          $gets=$p->prepare("SELECT name FROM registration where id='$c'");
                                          $gets->execute();
                                          $name=$gets->fetch();
                                          echo $name['name'];
                                          ?>
                                        </td>
                                        <td><?php echo $rt['remaining_amount']; ?></td>
                                        
                                        <td><?php echo $rt['current_amount']; ?></td>
                                       
                                        <td><?php echo $rt['payment_mode']; ?></td>
                                          <td><?php echo $rt['reference_id']; ?></td>
										  
										 
                                          <td><?php echo $rt['paid_on']; ?></td>
										 
                                     
                           
                                         
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

             
            
                 
                  

          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
     
	 <?php include('common/footer.php'); ?>
	 
      <!--footer end-->
  </section>
   <script>
	 function memAcount()
	{
		var a1=$('#cId').val();
		var a2=$('#mId').val();
		var a1=parseFloat(a1);
		var a2=parseFloat(a2);
		if(a2 > a1)
		{
			alert('Amount can not be greater than remaining amount');
			return false;
		}
		else
		{
			return true;
		}
		
	}
</script>

    <?php include('common/js.php'); ?>
	
	     
	  <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  
   
    <script src="js/advanced-form-components.js"></script>
	
  </body>
</html>


