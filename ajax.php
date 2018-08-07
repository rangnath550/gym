<?php
include('common/config.php');
$mode=$_REQUEST['mode'];
switch($mode)
{
	case "memAcount":
	  
	  $rid=$_REQUEST['cid'];
	  $dateOfJoining=$_REQUEST['doj'];

	  $data=$p->prepare("SELECT * FROM membership WHERE id='$rid'");
	  $data->execute();
	  $rows=$data->fetch();
	  $amount=$rows['amount'];
	  $duration=$rows['duration'];
	  $duration_type=$rows['duration_type'];
	  
	  $pieces = explode('-', $dateOfJoining);
	 
	  $dateOfJoining=$pieces[2]."-".$pieces[0]."-".$pieces[1];
	 
	 switch($duration_type)
	 {
		  case "month";
		   $type="months";
		  break;
		  
		  case "days";
		   $type="days";
		  break;
	 }
	 
	 
	  $expiryDate = date('Y-m-d', strtotime("+".$duration.$type, strtotime($dateOfJoining)));
	  $aReturn['amount']=$amount;
	  $aReturn['expiryDate']=$expiryDate;
	  
	  echo json_encode($aReturn);
	break;
	case "remAcount":
	 $rid=$_REQUEST['cid'];
	  $data=$p->prepare("SELECT * FROM registration WHERE id='$rid'");
	  $data->execute();
	  $rows=$data->fetch();
	  $amount=$rows['amount'];
	  echo json_encode($amount);
	  break;
}
?>