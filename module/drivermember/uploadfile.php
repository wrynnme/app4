<?php
$fileupload = $_REQUEST['fileupload']; //รับค่าไฟล์จากฟอร์ม	
//$fileupload2 = $_REQUEST['fileupload2']; //รับค่าไฟล์จากฟอร์ม	

//ฟังก์ชั่นวันที่
//    date_default_timezone_set('Asia/Bangkok');
//	$date = date("Ymd");	
//ฟังก์ชั่นสุ่มตัวเลข
//    $numrand = (mt_rand());
//เพิ่มไฟล์
$upload=$_FILES['fileupload'];
if($upload <> '') {   //not select file
//โฟลเดอร์ที่จะ upload file เข้าไป 
$path="fileupload/";  

//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
 $type = strrchr($_FILES['fileupload']['name'],".");

//กรณีมีการส่งไฟล์มาให้ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
if ($type <> "")
{
	$newname = $filename.$type;
}
else
{
//กรณีไม่มีการส่งไฟล์มา ให้ตั้งเป็นต่าว่าง
		$newname = "";
}

//ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
//	$newname = $filename.$type;


//$newname = $date.$numrand.$type;
$path_copy=$path.$newname;
$path_link="fileuploads/".$newname;

//คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
$result = move_uploaded_file($_FILES['fileupload']['tmp_name'],$path_copy);  	
	}
	// javascript แสดงการ upload file
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Upload File Succesfuly  $newname');";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to upload again');";
	echo "</script>";
}
?>