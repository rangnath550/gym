<?php
include 'common/config.php';
$invoice=base64_decode($_REQUEST['id']);

$invoiceDate=date('F j,Y');
$getCompany=$p->prepare("SELECT * FROM company");
$getCompany->execute();
$row=$getCompany->fetch();
$companyName=$row['company_name'];
$logo=$row['logo'];


$add=$p->prepare("SELECT * FROM registration where id='$invoice'");
$add->execute();
$r=$add->fetch();
$name=$r['name'];
$plan=$r['plan'];
$pay_status=$r['payment_status'];
$doj=$r['doj'];
$dateofJoining=date('F j ,Y',strtotime($doj));

$a=$p->prepare("SELECT * FROM membership where id='$plan'");
$a->execute();
$m=$a->fetch();


switch($pay_status)
{
	case "1":
	 $status='<b style="color:green;font-weight:bold">Paid</b>';
	  break;
	  case"0":
	  $status='<b style="color:red;font-weight:bold">Unpaid</b>';
	  break;
}

$html = '<div style="width:100%">
<h1 style="text-align:center">INVOICE</h1>
              <div style="width:100%;border-bottom:1px solid #000">
			     <div style="width:50%;float:left"><img src="common/uploads/logo'.$logo.'" style="width:100px;height:100px"></div>
			     <div style="width:50%;float:left;text-align:right">
				    <b style="font-size:20px">'.$companyName.'</b><br/>
				    '.$row['address'].'<br/>
				    '.$row['email'].'<br/>
				    '.$row['phone'].'<br/>
				 
				 </div>
			  </div>
			   <div style="width:100%;border-bottom:1px solid #000;padding-top:10px">
			     
			     <div style="width:50%;float:left;">
				 <h3>TO</h3>
				    <b >'.$name.'</b><br/>
				   
				    '.$r['email'].'<br/>
				    '.$r['contact'].'<br/>
					 '.$r['address'].'<br/>
				 
				 </div>
				  <div style="width:50%;float:left;text-align:right">
				   <div style="width:100%"> <div style="font-weight:bold;width:50%;float:left">Invoice No - </div> <div style="width:50%;float:right;text-align:center;"> '.$r['invoice_no'].'</div></div>
				   <br/>
				   <div  style="width:100%"> <div style="font-weight:bold;width:50%;float:left"> Invoice Date - </div> <div style="width:50%;float:right;text-align:center;">'.$invoiceDate.'</div></div>
				   </div>
			  </div>
			  <div style="width:100%;border-bottom:1px solid #000;padding-top:5px">
			     <h2 style="text-align:center">Membership Detail</h2>
				 <div style="width:100%">
				    <table style="width:100%;border-collapse:collapse">
					  <thead >
					  <tr style="background:#ddd;">
					   <th style="padding:5px 0px;border:1px solid #000">Membership Plan</th>
					   <th style="padding:5px 0px;border:1px solid #000">Amount</th>
					   <th style="padding:5px 0px;border:1px solid #000">Joining Date</th>
					  </tr>
					  </thead>
					  <tbody>
					     <tr>
						   <td align="center" style="padding:5px 0px;border:1px solid #000">'.$m['title'].'</td>
						   <td  align="center" style="padding:5px 0px;border:1px solid #000">Rs. '.$r['amount'].'</td>
						   <td align="center"  style="padding:5px 0px;border:1px solid #000">'.$dateofJoining.'</td>
						 </tr>
						 <tr>
						   <td colspan="2" align="right" style="padding:5px 5px;border:1px solid #000"><b>Remaining Amount  </b></td>
						   <td  align="center" style="padding:5px 0px;border:1px solid #000">Rs. '.$r['remaining_amount'].'</td>
						 </tr>
						  <tr>
						   <td colspan="2" align="right" style="padding:5px 5px;border:1px solid #000"><b>Payment Status  </b></td>
						   <td  align="center" style="padding:5px 0px;border:1px solid #000"> '.$status.'</td>
						 </tr>
					  </tbody>
					</table>
				 </div>
			   </div>
			   
			  <div style="width:100%;padding-top:5%">
				  <div style="width:50%;float:left">
					<h3>Terms & Conditions</h3>
					<ol>
					   <li>Goods once sold will not be taken back</li>
					   <li>All disputes subject to Lucknow Jurisdiction</li>
					   <li>Our risk & responsibility ceases other delivery of the goods to the carriers</li>
					   <li>interest @ 24% per annum will be charged if this bill is not paid on presentation.</li>
					   <li>E & O.E</li>
					</ol>
				  </div>
				  <div style="width:50%;float:left;text-align:right;">
					 <b>Authorised Signatory</b>
					 <p style="margin-top:14%;font-size:18px">'.$companyName.'</p>
				  </div>
			</div>
			   
			  ';

$html.='<div></div></div>';


//==============================================================
//==============================================================
//==============================================================

include("mpdf/mpdf.php");

$mpdf=new mPDF('c','A4','10'); 
$mpdf->SetWatermarkText($company_row['name'],0.1);
$mpdf->showWatermarkText = true;
$mpdf->SetDisplayMode('fullpage');


$mpdf->WriteHTML();	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

$mpdf->Output('wt-invoice-'.$invoice.'.pdf', 'I');

exit;
//==============================================================
//==============================================================
//==============================================================

?>