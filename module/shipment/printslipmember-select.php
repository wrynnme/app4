<?php require_once('../../Connections/ml.php'); ?>
<?php
	include ("baht_text.php");
	## วิธีใช้งาน
	//$x = '9123568543241.25'; 
	//echo  $x  . "=>" .convert($x); 
 ?>
<?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

//_______ ค้นหาข้อมูลคนขับรถ _________________
mysql_select_db($database_ml, $ml);
$query_listdrivermember = "SELECT * FROM drivermember WHERE driver_id = ".$_POST["drivermember_id"];
$listdrivermember = mysql_query($query_listdrivermember, $ml) or die(mysql_error());
$row_listdrivermember = mysql_fetch_assoc($listdrivermember);
$totalRows_listdrivermember = mysql_num_rows($listdrivermember);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>


<?php

/*  ตั้งค่าเอกสาร  */
//require_once __DIR__ . '/vendor/autoload.php';
require_once '../../vendor/autoload.php';

//$mpdf->SetImportUse();
//$mpdf = new \Mpdf\Mpdf();

$mpdf = new \Mpdf\Mpdf([
	'format'			=> 'A4',
	'mode'			  => 'utf-8',
	'default_font_size' => '14',
	'default_font' 	  => 'thsarabun',
	]);


$mpdf->SetDocTemplate('templateslipmember.pdf', 1);

//$mpdf->Output();
//$mpdf->AddPage('L');

//กำหนดค่าแสดงผลหัวกระดาษ
$slipmember_id = "THE".date("dmYHi")."-5";
$slipdat_out = date("d/m/Y");
$date_out = date("Y-m-d");


$picturestatus5 = $slipmember_id.".pdf";
$new_status = 4;
$status_oil = 2;

$drivermembername = $row_listdrivermember["driver_first_name"]."   ".$row_listdrivermember["driver_last_name"];
$drivermember_idcard = $row_listdrivermember["driver_id_card"];

$drivermember_bank = $row_listdrivermember["driver_bookbank_name"]." สาขา ".$row_listdrivermember["driver_bookbank_branch"];
$drivermember_bank_bookid = $row_listdrivermember["driver_bookbank_id"];
$drivermember_driver_car_id = $row_listdrivermember["driver_car_id"];
$drivermember_address = $row_listdrivermember["address_1"]." ".
						$row_listdrivermember["address_2"]." ".
						$row_listdrivermember["address_3"]." ".
						$row_listdrivermember["address_4"]." ".
						$row_listdrivermember["address_5"]." ".
						$row_listdrivermember["postcode"]." ".
						"หมายเลขโทรศัพท์  ".$row_listdrivermember["driver_tel"] ;
						
//จบกำหนดค่าแสดงผลหัวกระดาษ



//พิมพ์หัวกระดาษ
/*
$mpdf->WriteFixedPosHTML($slipmember_id, 140, 38, 100, 90, 'auto'); // เลขที่ใบสลิป
$mpdf->WriteFixedPosHTML($slipdat_out, 140, 45, 200, 10, 'auto'); // วันที่ออกใบสลิป

$mpdf->WriteFixedPosHTML($drivermembername, 50, 54, 200, 10, 'auto'); // ชื่อ-นามสกุลคนขับรถ
$mpdf->WriteFixedPosHTML($drivermember_idcard, 120, 54, 200, 10, 'auto'); // เลขบัตรประชาชน


$mpdf->WriteFixedPosHTML($drivermember_bank, 50, 62, 100, 120, 'auto'); // ชื่อธนาคารและสาขา
$mpdf->WriteFixedPosHTML($drivermember_bank_bookid, 120, 61, 100, 120, 'auto'); // หมายเลขบัญชี
$mpdf->WriteFixedPosHTML($drivermember_address, 50, 75, 100, 120, 'auto'); // ที่อยู่
$mpdf->WriteFixedPosHTML($drivermember_driver_car_id, 120, 69, 100, 120, 'auto'); // ทะเบียนรถ
*/
//จบพิมพ์หัวกระดาษ

//$mpdf->Output();


/* กำหนดรอบการแสดงข้อมูลรายงานต่อ 1 แผ่น  */
$x = 15; // จำนวนรายการต่อ 1 หน้า
//$y = 80; // ตำแหน่งระยะบรรทัดเริ่มต้นในแต่ละรอบ (แนวบรรทัด)
$txt0 = $txt0 + 1; //ลำดับที่เอกสาร
$totalall=0; //ตั้งค่าเริ่มต้น
$payout_bill_type = $_POST["payout_bill_type"];
//echo $payout_bill_type;
//กำหนดจำนวนหน้าที่จะพิมพ์
$countdata = count($_POST["id"]);// จำนวนรายการทั้งหมด
$list_per_page = 15;// จำนวนรายการต่อหน้า
$page = ceil($countdata / $list_per_page);// จำนวนหน้าที่จะพิมพ์
//จบกำหนดจำนวนหน้าที่จะพิมพ์

$data = 0;
$pagecount=0;
for($pagecount=0;$pagecount<$page;$pagecount++)
{
	//พิมพ์หัวกระดาษ
//	$mpdf->WriteFixedPosHTML($payout_bill_type, 140, 38, 100, 90, 'auto'); // เลขที่ใบสลิป	
	$mpdf->WriteFixedPosHTML($slipmember_id, 140, 38, 100, 90, 'auto'); // เลขที่ใบสลิป
	$mpdf->WriteFixedPosHTML($slipdat_out, 140, 45, 200, 10, 'auto'); // วันที่ออกใบสลิป
	
	$mpdf->WriteFixedPosHTML($drivermembername, 50, 54, 200, 10, 'auto'); // ชื่อ-นามสกุลคนขับรถ
	$mpdf->WriteFixedPosHTML($drivermember_idcard, 120, 54, 200, 10, 'auto'); // เลขบัตรประชาชน
	
	
	$mpdf->WriteFixedPosHTML($drivermember_bank, 50, 62, 100, 120, 'auto'); // ชื่อธนาคารและสาขา
	$mpdf->WriteFixedPosHTML($drivermember_bank_bookid, 120, 61, 100, 120, 'auto'); // หมายเลขบัญชี
	$mpdf->WriteFixedPosHTML($drivermember_address, 50, 75, 100, 120, 'auto'); // ที่อยู่
	$mpdf->WriteFixedPosHTML($drivermember_driver_car_id, 120, 69, 100, 120, 'auto'); // ทะเบียนรถ
	//จบพิมพ์หัวกระดาษ
	
	$y = 100; // ตำแหน่งการแสดงผลแนวตั้ง (แนวบรรทัด
	$mpdf->WriteFixedPosHTML("เอกสารแผ่นที่ ".($pagecount+1)." จาก ".$page , 20, 235, 100, 120, 'auto'); // แสดงลำดับที่เอกสาร
//	for($i=0;$i<count($_POST["id"]);$i++)
	for($i=0;$i<$list_per_page;$i++)
	{		
			
		if(trim($_POST["id"][$data]) != "")
		{
			// ค้นหาข้อมูลเพื่อกำหนดข้อมูลแสดงผลใน 1 รอบ
			$colname_search_shipment = "-1";
			if (isset($_POST["id"][$data])) {
				$colname_search_shipment = $_POST["id"][$data];  
			}
			mysql_select_db($database_ml, $ml);
			$query_search_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_search_shipment, "int"));
			$search_shipment = mysql_query($query_search_shipment, $ml) or die(mysql_error());
			$row_search_shipment = mysql_fetch_assoc($search_shipment);
			$totalRows_search_shipment = mysql_num_rows($search_shipment);	
			
			mysql_select_db($database_ml, $ml);
			$query_listslipmember = "SELECT * FROM receipt_member WHERE product_payment_id = '".$row_search_shipment['product_payment_id']."'";
			$listslipmember = mysql_query($query_listslipmember, $ml) or die(mysql_error());
			$row_listslipmember = mysql_fetch_assoc($listslipmember);
			$totalRows_listslipmember = mysql_num_rows($listslipmember);					
			// จบค้นหาข้อมูลเพื่อกำหนดข้อมูลแสดงผลใน 1 รอบ

			//  กำหนดรายการข้อมูลรายละเอียดที่แสดงในใบสลิปคนขับรถ  						
			if ($row_search_shipment['transaction_date'] <> ""){$txt1 = $row_search_shipment['transaction_date'];}else {$txt1 = "";}
			if ($row_search_shipment['product_payment_id'] <> ""){$txt2 = $row_search_shipment['product_payment_id'];}else {$txt2 = "";}
			if ($row_search_shipment['productsource'] <> ""){$txt3 = $row_search_shipment['productsource'];}else {$txt3 = "";}
			if ($row_search_shipment['customer_destination2'] <> ""){$txt4 = $row_search_shipment['customer_destination2'];}else {$txt4 = "";}
			if ($row_search_shipment['product_amount'] <> ""){$txt5 = $row_search_shipment['product_amount'];}else {$txt5 = "0";}
			
			if ($row_search_shipment['rate_priceout_type1'] <> ""){$rate_priceout_type1 = $row_search_shipment['rate_priceout_type1'];}else {$rate_priceout_type1 = 0;}
						if ($row_search_shipment['rate_priceout_type3'] <> ""){$rate_priceout_type3 = $row_search_shipment['rate_priceout_type3'];}else {$rate_priceout_type3 = 0;}

			$txt6 = $rate_priceout_type1 + $rate_priceout_type3;
						
			if ($row_listslipmember['payout_oil_date'] <> ""){$txt8 = $row_listslipmember['payout_oil_date'];}else {$txt8 = "";}
			if ($row_listslipmember['payout_oil_bill_no'] <> ""){$txt9 = $row_listslipmember['payout_oil_bill_no'];}else {$txt9 = "";}
			if ($row_listslipmember['payout_oil_bill_comment'] <> ""){$txt10 = $row_listslipmember['payout_oil_bill_comment'];}else {$txt10 = "";}
			if ($row_listslipmember['payout_oil_bill_total'] <> ""){$txt11 = $row_listslipmember['payout_oil_bill_total'];}else {$txt11 = "";}			
			//จบกำหนดแสดงรายการสินค้าที่ใบส่งสินค้า
						
			//แสดงข้อมูลรายละเอียดในใบสลิปคนขับรถ
			$mpdf->WriteFixedPosHTML($txt1, 1, $y, 100, 120, 'auto'); // วันที่ใบส่งสินค้า
			$mpdf->WriteFixedPosHTML($txt2, 18, $y, 100, 120, 'auto'); // หมายเลขใบสั่งซื้อของลูกค้า
			$mpdf->WriteFixedPosHTML($txt3, 55, $y, 100, 120, 'auto'); // ต้นทางสินค้า
			$mpdf->WriteFixedPosHTML($txt4, 75, $y, 100, 120, 'auto'); // ปลายทางสินค้า
			$mpdf->WriteFixedPosHTML($txt5, 95, $y, 100, 120, 'auto'); // ปริมาณสินค้า
			$mpdf->WriteFixedPosHTML($txt6, 105, $y, 100, 120, 'auto'); // ค่าจ้าง (ค่าจ้าง + ค่าจ้างเพิ่มเติม)
			
			$mpdf->WriteFixedPosHTML($txt8, 120, $y, 100, 120, 'auto'); // ในที่ออกใบเบิกน้ำมัน
			$mpdf->WriteFixedPosHTML($txt9, 140, $y, 100, 120, 'auto'); // หมายเลขใบเบิกน้มัน
			$mpdf->WriteFixedPosHTML($txt10, 160, $y, 100, 120, 'auto'); // รายละเอียด
			$mpdf->WriteFixedPosHTML($txt11, 185, $y, 100, 120, 'auto'); // จำนวนเงินที่เบิกค่าน้ำมัน
			//แสดงข้อมูลรายละเอียดในใบสลิปคนขับรถ 
			
			$txt12 = $txt6; //ยอดรวมรายได้
			$txt13 = $txt11; //ยอดรวมเบิก
			switch ($payout_bill_type)
				{
					case 10 : $txt14 = $txt12*10/100;break;
					case 12 : $txt14 = $txt12*12/100;break;
				}
			$txt15 = ($txt12*1)/100; //ภาษี 1%
			$txt16 = $txt12 - ($txt13 + $txt14 + $txt15);
			
			
//			$mpdf->WriteFixedPosHTML($txt14, 105, 213, 100, 120, 'auto'); // ค่าดำเนินการ
			//UPdate ข้อมูลในตารางบิลน้ำมัน
			$update1SQL = sprintf("UPDATE receipt_member SET
									receipt_member_no=%s,
									date_payment_member=%s,
									payout_bill_type=%s,
									receipt_member_working=%s,
									receipt_member_vat1=%s,
									receipt_member_amout=%s,
									rate_priceout_type1=%s,
									rate_priceout_type3=%s
									WHERE product_payment_id=%s",
							   GetSQLValueString($slipmember_id, "text"),
							   GetSQLValueString($date_out, "date"),
							   GetSQLValueString($payout_bill_type, "int"),
							   GetSQLValueString($txt14, "float"),
							   GetSQLValueString($txt15, "float"),
							   GetSQLValueString($txt16, "float"),
							   GetSQLValueString($rate_priceout_type1, "float"),
							   GetSQLValueString($rate_priceout_type3, "float"),							   							
							   GetSQLValueString($row_search_shipment['product_payment_id'], "text"));										   			
							   
			mysql_select_db($database_ml, $ml);
			$Result1 = mysql_query($update1SQL, $ml) or die(mysql_error());
			//จบ UPdate ข้อมูลในตารางบิลน้ำมัน

			//ปรับสถานะเอกสารเป็นรอพิมพ์ใบเสร็จรับเงิน	
			$update2SQL = sprintf("UPDATE shipment SET picturestatus5=%s, status=%s, status_oil=%s  WHERE product_payment_id=%s",
					GetSQLValueString($picturestatus5, "text"),
					GetSQLValueString($new_status, "int"),
					GetSQLValueString($status_oil, "text"),
					GetSQLValueString($row_search_shipment['product_payment_id'], "text"));					   
			mysql_select_db($database_ml, $ml);
			$Result1 = mysql_query($update2SQL, $ml) or die(mysql_error());
			//จบปรับสถานะเอกสารเป็นรอพิมพ์ใบเสร็จรับเงิน

				
			$txt12_all = $txt12_all+$txt6; //ยอดรวมรายได้
			$txt13_all = $txt13_all + $txt11; //ยอดรวมเบิก
			switch ($payout_bill_type)
				{
					case 10 : $txt7 = "10%"; $txt14_all = $txt12_all*10/100;break;
					case 12 : $txt7 = "12%"; $txt14_all = $txt12_all*12/100;break;
				}
			$txt15_all = ($txt12_all*1)/100; //ภาษี 1%
			$txt16_all = $txt12_all - ($txt13_all + $txt14_all + $txt15_all);
			$txt17_all = baht_text($txt16_all);
			
			$y = $y+5;	
			$txt0 = $txt0 + 1;
			$data = $data + 1;	
		}
		
	}										

	/* จบกำหนดรอบการแสดงข้อมูลรายงานสินค้า  */	
	if($pagecount+1 < $page){$mpdf->AddPage();}
	$pagecount = $pagecount +1;		
} //while($pagecount <= $page);

/*  ข้อมูลท้ายกระดาษ */
$mpdf->WriteFixedPosHTML($txt12_all, 105, 207, 100, 120, 'auto'); // รวมรายได้ทั้งสิ้น
$mpdf->WriteFixedPosHTML($txt13_all, 185, 207, 100, 120, 'auto'); // รวมเบิกค่าน้ำมันทั้งหมด
$mpdf->WriteFixedPosHTML($txt7, 30, 214, 100, 120, 'auto'); // แสดง % ค่าดำเนินการ
$mpdf->WriteFixedPosHTML($txt14_all, 105, 213, 100, 120, 'auto'); // ค่าดำเนินการ
$mpdf->WriteFixedPosHTML($txt15_all, 105, 221, 100, 120, 'auto'); // ภาษี 1%
$mpdf->WriteFixedPosHTML($txt16_all, 105, 265, 100, 120, 'auto'); // ยอดสุทธิ
$mpdf->WriteFixedPosHTML($txt17_all, 20, 265, 100, 120, 'auto'); // ข้อความยอดสุทธิ
/*  จบข้อมูลท้ายกระดาษ */

$mpdf->Output('../shipment/fileupload/'.$picturestatus5,'F');
$mpdf->Output();

?>

</body>
</html>
<?php
mysql_free_result($listslipmember);

///mysql_free_result($search_shipment);

mysql_free_result($listdrivermember);

///mysql_free_result($search_drivermember);

mysql_free_result($search_drivermember);
?>