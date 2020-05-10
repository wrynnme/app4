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
//ค้นหาจำนวนใบสั่งสินค้าที่อยูาในใบแจ้งหนี้ที่จะยกเลิก
$billing_id = $_GET['billing_id'];

mysql_select_db($database_ml, $ml);
$query_search_reset_bill = "SELECT * FROM receipt WHERE billing_id LIKE '".$billing_id ."'";
$search_reset_bill = mysql_query($query_search_reset_bill, $ml) or die(mysql_error());
$row_search_reset_bill = mysql_fetch_assoc($search_reset_bill);
$totalRows_search_reset_bill = mysql_num_rows($search_reset_bill);
$i = 1;
do {
		$id[$i] = $row_search_reset_bill['id'];
		$shipment_id[$i] = $row_search_reset_bill['shipment_id'];
		$transaction_date[$i] = $row_search_reset_bill['transaction_date'];
		$receipt_id = $row_search_reset_bill['receipt_id'];		

//		echo $i."  ";
//		echo $id[$i]."  ";
//		echo $shipment_id[$i]."  ";
//		echo $transaction_date[$i]."  ";
		
//		echo "<br>";
		$i++;
		
} while ($row_search_reset_bill = mysql_fetch_assoc($search_reset_bill));


if ($receipt_id  == "")
{
	for ($i =1;$i<=$totalRows_search_reset_bill;$i++)
	{	
	//			echo $i."<br>";
				mysql_select_db($database_ml, $ml);
				$query_delete_reset_bill = "DELETE FROM receipt WHERE id = ".$id[$i];
	//			echo $query_delete_reset_bill."<br>";
				mysql_query($query_delete_reset_bill, $ml) or die(mysql_error());
				
				mysql_select_db($database_ml, $ml);
				$query_add_new_bill = "INSERT INTO `receipt` (`id`, `receipt_id`, `receipt_date`, `customer_id`, `shipment_id`, `billing_id`, `transaction_date`, `amount`, `amount2`, `amount3`, `vat`, `total`, `round_shipment`)
				VALUES (NULL, NULL, NULL, NULL,".$shipment_id[$i].", NULL,'".$transaction_date[$i]."', NULL, NULL, NULL, NULL, NULL, NULL)";		
	//			echo $query_add_new_bill."<br>";
				$add_new_bill = mysql_query($query_add_new_bill, $ml) or die(mysql_error());
				
				mysql_select_db($database_ml, $ml);		
				$query_edit_shipment_pictureststus = "UPDATE shipment SET picturestatus3 ='', picturestatus4 ='' , status = '1' WHERE id = ".$shipment_id[$i];
				$edit_shipment_pictureststus = mysql_query($query_edit_shipment_pictureststus, $ml) or die(mysql_error());
	//			echo $query_edit_shipment_pictureststus."<br>";
							
	}
	echo	"<table width=100% align=center>
						<tr>
							<td align=center>
								<a href=closewindows.php>ยกเลิกเอกสารเรียบร้อยแล้ว</a>
							</td>
						</tr>
			
			</table>";
}
else
{
echo "<table width=100% align=center>
						<tr>
							<td align=center>
								<font color=#FF0000><p>ไม่สามารถยกเลิกเอกสารได้เนื่องจากพิมพ์ใบเสร็จรับเงินเรียบร้อยแล้ว</p>
								<p> หากต้องการยกเลิกเอกสารนี้ กรุณายกเลิกใบเสร็จรับเงินให้เรียบร้อยก่อน<p></font>
								<p><a href=closewindows.php>คลิกเพื่อปิดหน้าต่าง</a></p>
							</td>
						</tr>			
			</table>";
}
?>
			


</body>
</html>