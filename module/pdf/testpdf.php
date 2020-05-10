<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php 
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

$mpdf->SetDocTemplate('templateshipment.pdf', 1);
$mpdf->AddPage('L');

$txt1 = $row_search_shipment['customer_name'];
//$txt2 = 'ที่อยู่ 555 ถนนพิชัยรณรงค์สงคราม ต.ปากเพรียว อ.เมือง จ.สระบุรี';
//$txt3 = 'โทรศัพท์ 0XXXXXXXXX โทรสาร 0XXXXXXXXXX';
//$txt4 = 'วันที่ '.$row_search_shipment['product_dateout'];
//$txt5 = 'เลขที่เอกสาร '.$row_search_shipment['product_payment_id'];
//$txt6 = $row_search_shipment['ref_product_payment_id'];
//$txt7 = $row_search_shipment['type_product'];
//$txt8 = '';
//$txt9 = $row_search_shipment['product_amount'];
//$txt10 = $row_search_shipment['customer_destination'];


//$mpdf->WriteFixedPosHTML($txt1, 15, 42, 100, 90, 'auto');
///$mpdf->WriteFixedPosHTML($txt1, 155, 42, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt2, 15, 48, 100, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt2, 155, 48, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt3, 15, 55, 100, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt3, 155, 55, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt10, 15, 62, 100, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt10, 155, 62, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt4, 103, 62, 100, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt4, 245, 62, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt5, 103, 67, 50, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt5, 245, 67, 50, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt6, 32, 90, 20, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt6, 172, 90, 20, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt7, 55, 90, 100, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt7, 195, 90, 100, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt8, 115, 90, 10, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt8, 255, 90, 10, 90, 'auto');

//$mpdf->WriteFixedPosHTML($txt9, 135, 90, 10, 90, 'auto');
//$mpdf->WriteFixedPosHTML($txt9, 275, 90, 10, 90, 'auto');

$mpdf->Output();
?>


</body>
</html>