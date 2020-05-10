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



//_______ ค้นหาข้อมูลใบส่งของ _________________
$customer_id = $_POST["customer_id"];
mysql_select_db($database_ml, $ml);
$query_search_customer = "SELECT * FROM customer WHERE id =".$customer_id;
$search_customer = mysql_query($query_search_customer, $ml) or die(mysql_error());
$row_search_customer = mysql_fetch_assoc($search_customer);
$totalRows_search_customer = mysql_num_rows($search_customer);
/*


*/



/*


$colname_search_shipment = "-1";
if (isset($_GET['id'])) {
  $colname_search_shipment = $_GET['id'];  
}

mysql_select_db($database_ml, $ml);
$query_search_shipment = sprintf("SELECT * FROM shipment WHERE id = %s", GetSQLValueString($colname_search_shipment, "int"));
$search_shipment = mysql_query($query_search_shipment, $ml) or die(mysql_error());
$row_search_shipment = mysql_fetch_assoc($search_shipment);
$totalRows_search_shipment = mysql_num_rows($search_shipment);



mysql_select_db($database_ml, $ml);
$query_search_drivermember = "SELECT * FROM drivermember WHERE driver_id =".$row_search_shipment['drivermember_id'];
$search_drivermember = mysql_query($query_search_drivermember, $ml) or die(mysql_error());
$row_search_drivermember = mysql_fetch_assoc($search_drivermember);
$totalRows_search_drivermember = mysql_num_rows($search_drivermember);



//_______ หมดค้นหาข้อมูลใบส่งของ _________________
*/

$billing_id = "THE".date("dmYHi")."-3";
$picturestatus3 = $billing_id.".pdf";
$new_status = 2;
$credit = $_POST["credit"];
$credit_end = $_POST["credit_end_date"];
//$credit_end = $_POST["credit_end_d"]."/".$_POST["credit_end_m"]."/".$_POST["credit_end_y"];
switch ($_POST["billtype"])
{
	case "1" : $txtpayment = "ธนาคารทหารไทย จำกัด (มหาชน) สาขาสระบุรี กระแสรายวัน เลขบัญชี 312-1-07922-6";break;
	case "2" : $txtpayment = "ธนาคารกสิกรไทย จำกัด (มหาชน) สาขาเทสโก้โลตัส สระบุรี ออมทรัพย์ เลขบัญชี 086-1-01769-9";break;
	case "3" : $txtpayment = "ธนาคารกรุงศรีอยุธยา จำกัด (มหาชน) สาขาเทสโก้โลตัส สระบุรี ออมทรัพย์ เลขบัญชี 800-1-99964-4";break;
	case "4" : $txtpayment = "ธนาคารกสิกรไทย จำกัด (มหาชน) (อรนุช บุตดีมี) สาขาหนองแค ออมทรัพย์ เลขบัญชี 029-8-22327-9";break;
}


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
	'default_font_size' => '12',
	'default_font' 	  => 'thsarabun',
	]);


$txt2=  $row_search_customer['address1']."  ".
		$row_search_customer['address2']."  ".
		$row_search_customer['address3']."  ".
		$row_search_customer['address4']."  ".
		$row_search_customer['address5']."  ".
		$row_search_customer['postcode'];
		
$txt245 = "โทรศัพท์ ".$row_search_customer['telephone']."  ".
		"โทรสาร ".$row_search_customer['faxnumber'];


$txt13 = $row_search_drivermember['driver_first_name']."  ".
		 $row_search_drivermember['driver_last_name'];


$mpdf->SetDocTemplate('templatebilling.pdf', 1);
//$mpdf->AddPage('L');

if ($row_search_customer['name'] <> ""){$txt1 = $row_search_customer['name'];}else {$txt1 = "";}
if ($txt2 == ""){$txt2 = " ";}


if ($row_search_customer['tax_customer_id'] <> ""){$txt24 = $row_search_customer['tax_customer_id'];}else {$txt24 = "";}
//if ($row_search_customer['comment_costomer'] <> ""){$txt25 = $row_search_customer['comment_costomer'];}else {$txt25 = "";}

$txt25 = $credit." วัน";
$txt26 = date("d/m/Y");
$txt27 = $credit_end;
$txt4 = $billing_id;

if ($row_search_shipment['order_number'] <> ""){$txt7 = $row_search_shipment['order_number'];}else {$txt7 = "ไม่มี";}

if ($row_search_shipment['type_product'] <> ""){$txt9 = $row_search_shipment['type_product'];}else {$txt9 = "";}
if ($row_search_shipment['product_amount2'] <> ""){$txt10 = $row_search_shipment['product_amount2'];}else {$txt10 = "";}

if ($row_search_shipment['comment3'] <> ""){$txt12 = $row_search_shipment['comment3'];}else {$txt12 = "";}
if ($txt13 == ""){$txt2 = " ";}

if ($row_search_shipment['date3'] <> ""){$txt15 = $row_search_shipment['date3'];}else {$txt15 = "";}








//พิมพ์หัวกระดาษ
//$mpdf->WriteFixedPosHTML($txt1, 37, 42, 100, 90, 'auto'); // ชื่อผู้ซื้อ
//$mpdf->WriteFixedPosHTML($txt2, 37, 48, 200, 10, 'auto'); // ที่อยู่ผู้ซื้อ
//$mpdf->WriteFixedPosHTML($txt24, 37, 54, 200, 10, 'auto'); // เลขผู้เสียภาษี
//$mpdf->WriteFixedPosHTML($txt245, 37, 60, 200, 10, 'auto'); // เลขโทรศัพท์ลูกค้า

//$mpdf->WriteFixedPosHTML(' '.$txt4, 175, 13, 100, 120, 'auto'); // เลขที่เอกสารใบแจ้งหนี้
//$mpdf->WriteFixedPosHTML(' '.$txt26, 175, 20, 100, 120, 'auto'); // วันที่ออกใบแจ้งหนี้
//$mpdf->WriteFixedPosHTML(' '.$txt25, 175, 27, 100, 120, 'auto'); // เงื่อนไข
//$mpdf->WriteFixedPosHTML(' '.$txt27, 175, 34, 100, 120, 'auto'); // วันครบกำหนด
//จบพิมพ์หัวกระดาษ



/* กำหนดรอบการแสดงข้อมูลรายงานสินค้า  */
//$x = 15; // ตำแหน่งการแสดงผลแนวนอน (แนวตัวอักษร)
//$y = 80; // ตำแหน่งการแสดงผลแนวตั้ง (แนวบรรทัด)
$txt0 = $txt0 + 1;
$totalall=0;

//กำหนดจำนวนหน้าที่จะพิมพ์
$countdata = count($_POST["id"]);// จำนวนรายการทั้งหมด
$list_per_page = 24;// จำนวนรายการต่อหน้า
$page = ceil($countdata / $list_per_page);// จำนวนหน้าที่จะพิมพ์
//จบกำหนดจำนวนหน้าที่จะพิมพ์

$data = 0;
$startdate_out = 0;
$pagecount=0;
for($pagecount=0;$pagecount<$page;$pagecount++)
{
	//พิมพ์หัวกระดาษ
	$mpdf->WriteFixedPosHTML($txt1, 37, 56, 100, 90, 'auto'); // ชื่อผู้ซื้อ
	$mpdf->WriteFixedPosHTML($txt2, 37, 62, 200, 30, 'auto'); // ที่อยู่ผู้ซื้อ
	$mpdf->WriteFixedPosHTML($txt24, 37, 68, 200, 10, 'auto'); // เลขผู้เสียภาษี
	$mpdf->WriteFixedPosHTML($txt245, 37, 74, 200, 10, 'auto'); // หมายเลขโทรศัพท์

	$mpdf->WriteFixedPosHTML(' '.$txt4, 175, 27, 100, 120, 'auto'); // เลขที่เอกสารใบแจ้งหนี้
	$mpdf->WriteFixedPosHTML(' '.$txt26, 175, 34, 100, 120, 'auto'); // วันที่ออกใบแจ้งหนี้
	$mpdf->WriteFixedPosHTML(' '.$txt25, 175, 41, 100, 120, 'auto'); // เงื่อนไข
	$mpdf->WriteFixedPosHTML(' '.$txt27, 175, 48, 100, 120, 'auto'); // วันครบกำหนด
	//จบพิมพ์หัวกระดาษ
	
	$y = 86; // ตำแหน่งการแสดงผลแนวตั้ง (แนวบรรทัด
	$mpdf->WriteFixedPosHTML("เอกสารแผ่นที่ ".($pagecount+1)." จาก ".$page , 90, 215, 100, 120, 'auto'); // แสดงลำดับที่เอกสาร
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
			// จบค้นหาข้อมูลเพื่อกำหนดข้อมูลแสดงผลใน 1 รอบ

			//แสดงข้อมูล
			//echo "data $i = ".$_POST["id"][$i]."<br>";
			/*  กำหนดแสดงรายการสินค้าที่ใบส่งสินค้า  */
			if ($row_search_shipment['product_dateout'] <> ""){$txt5 = $row_search_shipment['product_dateout'];}else {$txt5 = "";}
			if ($row_search_shipment['ref_product_payment_id'] <> ""){$txt8 = $row_search_shipment['ref_product_payment_id'];}else {$txt8 = "";}
			if ($row_search_shipment['po_number'] <> ""){$txt6 = $row_search_shipment['po_number'];}else {$txt6 = "-";}
			if ($row_search_shipment['car_id'] <> ""){$txt14 = $row_search_shipment['car_id'];}else {$txt14 = "";}
			if ($row_search_shipment['productsource'] <> ""){$txt23 = $row_search_shipment['productsource'];}else {$txt23 = "";}
			if ($row_search_shipment['customer_destination2'] <> ""){$txt3 = $row_search_shipment['customer_destination2'];}else {$txt3 = "";}
			if ($row_search_shipment['product_amount'] <> ""){$txt11 = $row_search_shipment['product_amount'];}else {$txt11 = "0";}
			if ($row_search_shipment['rate_pricein_type1'] <> ""){$txt16 = $row_search_shipment['rate_pricein_type1']; $txt161 = $txt16; }else {$txt16 = "0";$txt161=" ";}
			if ($row_search_shipment['rate_pricein_type3'] <> ""){$txt17 = $row_search_shipment['rate_pricein_type3']; $txt171 = $txt17; }else {$txt17 = "0";$txt171=" ";}
			//เพิ่มค่าขนส่งเพิ่ม
			if ($row_search_shipment['product_amount'] <> ""){$txt28 = $row_search_shipment['product_amount'];}else {$txt28 = "";}
			if ($row_search_shipment['comment2'] <> ""){$txt29 = $row_search_shipment['comment2'];}else {$txt29 = "";}
			if ($row_search_shipment['rate_pricein_type2'] <> ""){$txt30 = $row_search_shipment['rate_pricein_type2'];}else {$txt30 = "0";}
			//เพิ่มค่าขนส่งเพิ่ม
			//$txt18 = ($txt11 * $txt16) + ($txt11 * $txt17);
			$txt18 = $txt16;
			//$txt17 = ค่าขนส่งเพิ่ม
			$txt21 = ($txt18 * 1) / 100;  //ภาษี 1 %
			$txt22 = ($txt18 + $txt17) - $txt21; //ราคาสินค้า + ค่าขนส่งเพิ่ม

			/*  จบกำหนดแสดงรายการสินค้าที่ใบส่งสินค้า  */

			/*	แสดงข้อมูลใบส่งสินค้า  6 7 18*/
			$mpdf->WriteFixedPosHTML($txt0, 10, $y, 100, 120, 'auto'); // ลำดับรายการ
			$mpdf->WriteFixedPosHTML($txt5, 20, $y, 100, 120, 'auto'); // วันที่ทำรายการ
			$mpdf->WriteFixedPosHTML($txt8, 40, $y, 100, 120, 'auto'); // หมายเลขใบสั่งซื้อของลูกค้า
			$mpdf->WriteFixedPosHTML($txt6, 62, $y, 100, 120, 'auto'); // หมายเลขใบ PO
			$mpdf->WriteFixedPosHTML($txt14, 83, $y, 100, 120, 'auto'); // เลขทะเบียนรถ
			$mpdf->WriteFixedPosHTML($txt23, 98, $y, 100, 120, 'auto'); // สถานรับต้นทาง
			$mpdf->WriteFixedPosHTML($txt3, 112, $y, 100, 120, 'auto'); // สถานที่ปลายทาง
			$mpdf->WriteFixedPosHTML($txt28, 143, $y, 100, 120, 'auto'); // จำนวนตัน
			$mpdf->WriteFixedPosHTML(number_format($txt18,2), 155, $y, 100, 120, 'auto'); // ราคารวม
			$mpdf->WriteFixedPosHTML($txt29, 166, $y, 100, 120, 'auto'); // รายละเอียดการจ้างเพิ่ม
			$mpdf->WriteFixedPosHTML(number_format($txt17,2), 192, $y, 100, 120, 'auto'); // ค่าจ้างเพิ่ม
			/*   จบแสดงข้อมูลใบส่งสินค้า  */
			$y = $y+5;	
			$txt0 = $txt0 + 1; //แสดงลำดับที่
			$totalall = $totalall + $txt18; //ราคาสินค้ารวมทั้งหมด
			$total_rate_type2 = $total_rate_type2 + $txt17; //ราคาค่าขนส่งเพิ่มรวมทั้งหมด
			

			$startdate_out = 0;
			$stopdate_out = $countdata-1; 			
			mysql_select_db($database_ml, $ml);
			$sql1 = "SELECT product_dateout FROM shipment WHERE id =".$_POST["id"][$startdate_out];
			$sql2 = "SELECT product_dateout FROM shipment WHERE id =".$_POST["id"][$stopdate_out];
			$r1=mysql_query($sql1, $ml) or die(mysql_error());
			$r2=mysql_query($sql2, $ml) or die(mysql_error());
			
			$row_start = mysql_fetch_assoc($r1);
			$row_stop = mysql_fetch_assoc($r2);
			
			$txt_date = "รอบวันที่  ". $row_start['product_dateout']."  ถึงวันที่  ".$row_stop['product_dateout']; 




//$txt_date = "";
			//UPdate ข้อมูลเลขที่ใบแจ้งหนี้ในตารางใบเสร็จ
			$update1SQL = sprintf("UPDATE receipt SET customer_id=%s,billing_id=%s,amount=%s,amount2=%s,amount3=%s,vat=%s,total=%s,round_shipment=%s WHERE shipment_id=%s",
							   GetSQLValueString($row_search_shipment['customer_id'], "text"),
							   GetSQLValueString($billing_id, "text"),
							   GetSQLValueString($txt18, "float"),
							   GetSQLValueString($txt17, "float"),
							   GetSQLValueString($txt30, "float"),
							   GetSQLValueString($txt21, "float"),
							   GetSQLValueString($txt22, "float"),
							   GetSQLValueString($txt_date, "text"),
							   GetSQLValueString($_POST["id"][$data], "text"));
							   			   
			mysql_select_db($database_ml, $ml);
			$Result1 = mysql_query($update1SQL, $ml) or die(mysql_error());
			//จบ UPdate ข้อมูลเลขที่ใบแจ้งหนี้ในตารางใบเสร็จ

			//ปรับสถานะเอกสารเป็นรอพิมพ์ใบเสร็จรับเงิน
			if ($row_search_shipment['status'] == 4){$new_status = $row_search_shipment['status'];}	
			$update2SQL = sprintf("UPDATE shipment SET picturestatus3=%s , status=%s WHERE id=%s",
					GetSQLValueString($picturestatus3, "text"),
					GetSQLValueString($new_status, "int"),
					GetSQLValueString($_POST["id"][$data], "int"));					   
			mysql_select_db($database_ml, $ml);
			$Result1 = mysql_query($update2SQL, $ml) or die(mysql_error());
			//จบปรับสถานะเอกสารเป็นรอพิมพ์ใบเสร็จรับเงิน	
			$data = $data + 1;	
		}
		
	}										
		
	/* จบกำหนดรอบการแสดงข้อมูลรายงานสินค้า  */	
	if($pagecount+1 < $page){$mpdf->AddPage();}
//	$pagecount = $pagecount +1;		
} //while($pagecount <= $page);
/*  ข้อมูลท้ายกระดาษ */

$txt21 = ($totalall * 1) / 100;  //ค่าภาษี 1 % ของสินค้าทั้งหมด
$txt22 =($totalall+$total_rate_type2)-$txt21; //ยอดที่ต้องชำระ
$txt20 = baht_text($txt22);

$mpdf->WriteFixedPosHTML(number_format(($totalall),2)."  บาท", 175, 209, 100, 120, 'auto'); // รวมทั้งสิ้น
$mpdf->WriteFixedPosHTML(number_format($txt21,2)."  บาท", 175, 215, 100, 120, 'auto'); // ภาษี ณ ที่จ่าย 1%
$mpdf->WriteFixedPosHTML(number_format($total_rate_type2,2)."  บาท", 175, 222, 100, 120, 'auto'); // ค่าขนส่งเพิ่ม
$mpdf->WriteFixedPosHTML(number_format($txt22,2)."  บาท", 175, 230, 100, 120, 'auto'); // ยอดที่ต้องชำระ
$mpdf->WriteFixedPosHTML('   ( '.$txt20.' )   ', 25, 230, 100, 120, 'auto'); // ข้อความรวมภาษาไทย
$mpdf->WriteFixedPosHTML($txtpayment, 25, 239, 200, 120, 'auto'); // ชื่อบัญชีธนาคาร



/*  จบข้อมูลท้ายกระดาษ */


/*
เพิ่มหน้าเอกสารรรวมยอดทั้งหมด
*/
	$mpdf->SetDocTemplate('templatebilling-2.pdf', 1);
	$mpdf->AddPage();

	//พิมพ์หัวกระดาษ
	$mpdf->WriteFixedPosHTML($txt1, 37, 56, 100, 90, 'auto'); // ชื่อผู้ซื้อ
	$mpdf->WriteFixedPosHTML($txt2, 37, 62, 200, 30, 'auto'); // ที่อยู่ผู้ซื้อ
	$mpdf->WriteFixedPosHTML($txt24, 37, 68, 200, 10, 'auto'); // เลขผู้เสียภาษี
	$mpdf->WriteFixedPosHTML($txt245, 37, 74, 200, 10, 'auto'); // หมายเลขโทรศัพท์

	$mpdf->WriteFixedPosHTML(' '.$txt4, 175, 27, 100, 120, 'auto'); // เลขที่เอกสารใบแจ้งหนี้
	$mpdf->WriteFixedPosHTML(' '.$txt26, 175, 34, 100, 120, 'auto'); // วันที่ออกใบแจ้งหนี้
	$mpdf->WriteFixedPosHTML(' '.$txt25, 175, 41, 100, 120, 'auto'); // เงื่อนไข
	$mpdf->WriteFixedPosHTML(' '.$txt27, 175, 48, 100, 120, 'auto'); // วันครบกำหนด
	//จบพิมพ์หัวกระดาษ
	
	/*	แสดงข้อมูลใบส่งสินค้า  6 7 18*/
	$mpdf->WriteFixedPosHTML("ค่าขนส่งสินค้า", 40, 90, 100, 120, 'auto'); // ชื่อรายการ
	$mpdf->WriteFixedPosHTML($txt_date, 40, 95, 100, 120, 'auto'); // รอบวันที่ขนส่ง
	$mpdf->WriteFixedPosHTML(number_format($totalall-$txt21,2), 155, 90, 100, 120, 'auto'); // ราคารวม
//	$mpdf->WriteFixedPosHTML("ค่าจ้างขนส่งเพิ่มเติม", 165, 90, 100, 120, 'auto'); // รายละเอียดการจ้างเพิ่ม
	$mpdf->WriteFixedPosHTML(number_format($total_rate_type2,2), 192, 90, 100, 120, 'auto'); // ค่าจ้างเพิ่ม
	/*   จบแสดงข้อมูลใบส่งสินค้า  */	
	
	$mpdf->WriteFixedPosHTML(number_format($totalall-$txt21,2)."  บาท", 175, 209, 100, 120, 'auto'); // รวมทั้งสิ้น
//	$mpdf->WriteFixedPosHTML($txt21."  บาท", 175, 215, 100, 120, 'auto'); // ภาษี ณ ที่จ่าย 1%
	$mpdf->WriteFixedPosHTML(number_format($total_rate_type2,2)."  บาท", 175, 222, 100, 120, 'auto'); // ค่าขนส่งเพิ่ม
	$mpdf->WriteFixedPosHTML(number_format($txt22,2)."  บาท", 175, 230, 100, 120, 'auto'); // ยอดที่ต้องชำระ
	$mpdf->WriteFixedPosHTML('   ( '.$txt20.' )   ', 25, 230, 100, 120, 'auto'); // ข้อความรวมภาษาไทย
	$mpdf->WriteFixedPosHTML($txtpayment, 25, 239, 200, 120, 'auto'); // ชื่อบัญชีธนาคาร


/*
จบเพิ่มหน้าเอกสารรรวมยอดทั้งหมด
*/

$mpdf->Output('../shipment/fileupload/'.$picturestatus3,'F');
$mpdf->Output();

?>

</body>
</html>
<?php
mysql_free_result($search_shipment);

mysql_free_result($search_drivermember);

mysql_free_result($search_customer);
?>