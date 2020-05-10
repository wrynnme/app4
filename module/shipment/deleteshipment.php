<?php require_once("../../Connections/ml.php"); ?>
<?php
		$updateSQL = "UPDATE shipment SET status=".$_GET['status']."  WHERE id=".$_GET['id'];
		mysql_select_db($database_ml, $ml);
		$Result1 = mysql_query($updateSQL, $ml) or die(mysql_error());
		
		$updateGoTo = "detelcustomer.php?".$_GET['id'];
		  if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  header(sprintf("Location: %s", $updateGoTo));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>