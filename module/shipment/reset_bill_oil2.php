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
//ค้นหาจำนวนใบบันทึกน้ำมันที่จะยกเลิก
$product_payment_id = $_GET['product_payment_id'];

mysql_select_db($database_ml, $ml);
$query_search_reset_bill_oil = "SELECT * FROM receipt_member WHERE product_payment_id LIKE '".$product_payment_id ."'";
$search_reset_bill_oil = mysql_query($query_search_reset_bill_oil, $ml) or die(mysql_error());
$row_search_reset_bill_oil = mysql_fetch_assoc($search_reset_bill_oil);
$totalRows_search_reset_bill_oil = mysql_num_rows($search_reset_bill_oil);
//เช็คข้อมูลว่าทีมากกว่า 1 รายการใหม ถ้ามีจะทำการลบทั้งหมดที่เจอ
echo $totalRows_search_reset_bill_oil."<br>";
if ($totalRows_search_reset_bill_oil != 1)
{
	mysql_select_db($database_ml, $ml);
	$query_delete_reset_bill_oil = "DELETE FROM receipt_member WHERE product_payment_id LIKE '".$product_payment_id."'";
	mysql_query($query_delete_reset_bill_oil, $ml) or die(mysql_error());
	echo "<table width=100% align=center>
						<tr>
							<td align=center>
								<font color=#FF0000><p>ตรวจพบข้อมูลหลายรายการ...ยกเลิกเอกสารใบเบิกค่าน้ำมันทุกรายการที่ตรวจพบ</p>
								<p>กรุณากรอกข้อมูลใบเบิกน้ำมันใหม่</p></font>
								<p><a href=closewindows.php>คลิกเพื่อปิดหน้าต่าง</a></p>
							</td>
						</tr>			
			</table>";
}
else
{
	$i = 1;
	do {
			$id[$i] = $row_search_reset_bill_oil['id'];
			$shipment_id[$i] = $row_search_reset_bill_oil['product_payment_id'];
			$receipt_member_no[$i] = $row_search_reset_bill_oil['receipt_member_no'];
		
//			echo $i."  ";
//			echo $id[$i]."  ";
//			echo $receipt_member_no[$i]."  ";	
//			echo "<br>";

			if ($receipt_member_no[$i] == "")
			{
				mysql_select_db($database_ml, $ml);
				$query_delete_reset_bill_oil = "DELETE FROM receipt_member WHERE id  LIKE '".$id[$i]."'";
				mysql_query($query_delete_reset_bill_oil, $ml) or die(mysql_error());
				
				mysql_select_db($database_ml, $ml);
				$query_update_statusreset_bill_oil = "UPDATE shipment SET status_oil='0',status='3' WHERE product_payment_id LIKE '".$shipment_id[$i]."'";
				mysql_query($query_update_statusreset_bill_oil, $ml) or die(mysql_error());
				
				echo "<table width=100% align=center>
							<tr>
								<td align=center>
									<font color=#000000><p>ยกเลิกเอกสารใบเบิกค่าน้ำมันเรียบร้อยแล้ว</p></font>
									<p><a href=closewindows.php>คลิกเพื่อปิดหน้าต่าง</a></p>
								</td>
							</tr>			
						</table>";
					
			}
			else
			{	
				echo "<table width=100% align=center>
									<tr>
										<td align=center>
											<font color=#FF0000><p>ไม่สามารถยกเลิกเอกสารได้เนื่องจากพิมพ์ใบเสร็จรับเงินคนขับรถเรียบร้อยแล้ว</p>
											<p> หากต้องการยกเลิกเอกสารนี้ กรุณายกเลิกใบเสร็จค่าจ้างคนขับรถให้เรียบร้อยก่อน<p></font>
											<p><a href=closewindows.php>คลิกเพื่อปิดหน้าต่าง</a></p>
										</td>
									</tr>			
						</table>";			
				

			}
			
			$i++;
		} while ($row_search_reset_bill_oil = mysql_fetch_assoc($search_reset_bill_oil));
}

/*
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
*/
?>
			


</body>
</html>