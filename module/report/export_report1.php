<?php
// Database Connection
include ("Connections/mysqli.php");
  
if(isset($_GET['export'])){
if($_GET['export'] == 'true'){
$query = mysqli_query($conn, 'select * from shipment'); // Get data from Database from demo table
 
//ฟังก์ชั่นวันที่
    date_default_timezone_set('Asia/Bangkok');
	$date = date("Ymd");
 
    $delimiter = ",";
    $filename = "ข้อมูลการสั่งซื้อ_" . date('Ymd') . ".csv"; // Create file name
     
    //create a file pointer
    $f = fopen('php://memory', 'w'); 
	fputs($f,(chr(0xEF).chr(0xBB).chr(0xBF)));
     
    //set column headers
	$fields = array('ลำดับที่	','วันที่ทำรายการ	','หมายเลขใบสั่งสินค้า','ชื่อสินค้า	','สถานที่รับต้นทาง','ชื่อลูกค้า','หมายเลขติดต่อลูกค้า','วันที่ให้ไปรับสินค้า','ชื่อคนขับรถ','หมายเลขทะเบียนรถ','จำนวนที่รับสินค้า	','ราคาที่ขายให้ลูกค้า	','ราคาที่จ้างคนขับรถ','รูปใบสั่งสินค้า','สถานะบันทึกบิลน้ำมัน','สถานะใบสั่งสินค้า','เลขที่เอกสารอ้างอิง','ใบส่งสินค้า','ใบรับสินค้า','ใบแจ้งหนี้','ใบเสร็จ','สลิปค่าจ้าง','หมายเลขใบ PO','หมายเลขใบสั่งซื้อ','วันที่ส่งสินค้า','ชื่อย่อสถานที่ปลายทาง','จำนวนถุง');
	
//    $fields = array('ID', 'Country', 'State', 'City', 'Pin');
    fputcsv($f, $fields, $delimiter);
     
    //output each row of the data, format line as csv and write to file pointer
	$count = 1;
    while($row = $query->fetch_assoc()){
        switch ($row['status'])
		{
			case 0 : $status_txt = "พิมพ์ใบส่งสินค้า";
			case 1 : $status_txt = "รอเอกสารใบรับสินค้า"; 
			case 2 : $status_txt = "รอพิมพ์ใบส่งสินค้า";
			case 3 : $status_txt = "รอพิมพ์ใบเสร็จ";
			case 4 : $status_txt = "รอพิมพ์คนขับ";
			case 5 : $status_txt = "เสร็จสิ้น";
		}
		 
		  switch ($row['status_oil'])
		{
			case 1 : $status_oil_txt = "บันทึกแล้ว"; 
			case 2 : $status_oil_txt = "พิมพ์สลิปแล้ว";
		}
		
		$sql = "SELECT * FROM drivermember WHERE driver_id LIKE '".$row['drivermember_id']."'"; 
		$query2 = mysqli_query($conn,$sql);
		$result=mysqli_fetch_array($query2,MYSQLI_ASSOC);
		$drivermember_id_txt = $result["driver_first_name"]."   ".$result["driver_last_name"];						
/*
		$query_list_drivermember = "SELECT * FROM drivermember WHERE driver_id =".$row['drivermember_id'];
		$list_drivermember = mysql_query($query_list_drivermember, $ml) or die(mysql_error());
		$row_list_drivermember = mysql_fetch_assoc($list_drivermember);
		$totalRows_list_drivermember = mysql_num_rows($list_drivermember);
		$drivermember_id_txt = $row_list_drivermember['driver_first_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row_list_drivermember['driver_last_name'];
*/		
		if ($row['pictureorder'] <> "") {$pictureorder = "Y";} else {$pictureorder = "";}
		if ($row['picturestatus1'] <> "") {$pictureorder1 = "Y";} else {$pictureorder1 = "";}
		if ($row['picturestatus2'] <> "") {$pictureorder2 = "Y";} else {$pictureorder2 = "";}
		if ($row['picturestatus3'] <> "") {$pictureorder3 = "Y";} else {$pictureorder3 = "";}
		if ($row['picturestatus4'] <> "") {$pictureorder4 = "Y";} else {$pictureorder4 = "";}
		if ($row['picturestatus5'] <> "") {$pictureorder5 = "Y";} else {$pictureorder5 = "";}
				
        $lineData = array(
			$count,
			$row['transaction_date'],
			$row['product_payment_id'],
			$row['type_product'],
			$row['productsource'],
			$row['customer_name'],
			$row['customer_destination'],
			$row['product_dateout'],
			$drivermember_id_txt,
			$row['car_id'],
			$row['product_amount'],
			$row['rate_pricein_type1'],
			$row['rate_priceout_type1'],
			$pictureorder,
			$status_oil_txt,
			$status_txt,
			$row['ref_product_payment_id'],
			$pictureorder1,
			$pictureorder2,
			$pictureorder3,
			$pictureorder4,
			$pictureorder5,
			$row['po_number'],
			$row['order_number'],
			$row['date3'],
			$row['customer_destination2'],
			$row['product_amount2']		
		);
        fputcsv($f, $lineData, $delimiter);
		$count ++;
    }
     
    //move back to beginning of file
    fseek($f, 0);
     
    //set headers to download file rather than displayed
	
	header('Content-Type: text/csv; charset=utf-8');
//    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
     
    //output all remaining data on a file pointer
    fpassthru($f);
 
 }
}
mysqli_close($conn);
?>