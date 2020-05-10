<?php require_once('../../Connections/ml.php'); ?>
<?php
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = "DELETE FROM member WHERE id=".$_GET['id'];


  mysql_select_db($database_ml, $ml);
  $Result1 = mysql_query($deleteSQL, $ml) or die(mysql_error());

//  $deleteGoTo = "listcustomer.php";
  $deleteGoTo = "../../index.php?pagename=listmember";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
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