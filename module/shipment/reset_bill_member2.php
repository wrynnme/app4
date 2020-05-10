<?php require_once('../../Connections/ml.php'); ?>
<?php //require_once('Connections/ml.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
//ค้นหาข้อมูลใบเสร็จคนขับรถที่จะยกเลิก
$receipt_member_no = $_GET['receipt_member_no'];

mysql_select_db($database_ml, $ml);
$query_delete_reset_bill = "SELECT * FROM receipt_member WHERE receipt_member_no LIKE '".$receipt_member_no."'";
$search_reset_member_bill = mysql_query($query_delete_reset_bill, $ml) or die(mysql_error());
$row_search_reset_member_bill = mysql_fetch_assoc($search_reset_member_bill);
$totalRows_search_reset_member_bill = mysql_num_rows($search_reset_member_bill);
//$product_payment_id = $row_search_reset_member_bill['product_payment_id'];

$i = 1;
do {
		
		$product_payment_id[$i] = $row_search_reset_member_bill['product_payment_id'];			
		$i++;
		
} while ($row_search_reset_member_bill = mysql_fetch_assoc($search_reset_member_bill));


for ($i =1;$i<=$totalRows_search_reset_member_bill;$i++)
{
	mysql_select_db($database_ml, $ml);		
	$query_edit_shipment_pictureststus = "UPDATE shipment SET picturestatus5 ='' WHERE product_payment_id LIKE '".$product_payment_id[$i]."'";
	$edit_shipment_pictureststus = mysql_query($query_edit_shipment_pictureststus, $ml) or die(mysql_error());
}


mysql_select_db($database_ml, $ml);
$query_delete_reset_bill = "DELETE FROM receipt_member WHERE receipt_member_no LIKE '".$receipt_member_no."'";
mysql_query($query_delete_reset_bill, $ml) or die(mysql_error());

?>
			<table width=100% align=center>
						<tr>
							<td align=center>
								<a href="closewindows.php">ยกเลิกเอกสารใบจ่ายเงินคนขับรถเรียบร้อย</a>
							</td>
						</tr>
			
			</table>
</body>
</html>