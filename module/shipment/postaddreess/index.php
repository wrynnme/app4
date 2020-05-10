<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ajax Dropdown List Box - ข้อมูล Address ประเทศไทย</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css" />

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../02/js/jquery-1.9.2.ui.jsxx"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-en.js"></script>
<script>
$().ready(function() {
	jQuery(".frmInsert").validationEngine();
});
</script>
</head>

<body>
<div class="col-md-4 container" style="margin:20px auto">
<form action="" method="post" name="frmInsert form-inline">

<table class="table table-bordered">
<tr>
	<td width="20%">จังหวัด</td>
    <td><select name="Province" onchange="getAddress(this.name, 'District', 'a')" class="form-control">
    <option value=""> เลือกจังหวัด </option>
    <?php
	include_once 'inc/config.php'; 
	include_once 'inc/database.class.php'; 
	
	$juice = new MY_SQL; 
	$juice->fncConnectDB();
	$juice->fncSelectDB();
	$juice->set_char_utf8();
	
	$province = $juice->fncSelect("PROVINCE_ID,PROVINCE_NAME","province","ORDER BY PROVINCE_NAME ASC");
	foreach($province as $read){ ?><option value="<?=$read['PROVINCE_ID']?>,<?=$read['PROVINCE_NAME']?>"><?=$read['PROVINCE_NAME']?></option><? } ?>
    </select></td>
</tr>

<tr>
	<td>อำเภอ/เขต</td>
    <td><select name="District" onchange="getAddress(this.name, 'SubDistrict', 't')" class="form-control"><option value="">เลือก</option></select></td>
</tr>

<tr>
	<td>ตำบล/แขวง</td>
    <td><select name="SubDistrict" onchange="getAddress(this.name, 'Zipcode', 'z')" class="form-control"><option value="">เลือก</option></select></td>
</tr>

<tr>
	<td>รหัสไปรษณีย์</td>
    <td><input name="Zipcode" type="text" value="" class="validate[custom[zip]] form-control" /></td>
</tr>

</table>
</form>

<script type="text/javascript">
function getAddress(iSelect, toSelect, iMode){
	$.ajax({type : "GET",
		url :"get_address.php",
		data : { find: iMode, fvalue:$('select[name='+ iSelect+']').val()  },
		success : function(data){
			if (iMode=="z"){
				$('input[name='+ toSelect+']').val(data);
			} else {
				$('select[name='+ toSelect+']').empty().append(data);
				$('input[name=Zipcode]').val('');
			}

			  if(iMode=="a"){
				  var sname="select[name=SubDistrict]";
				  $(sname).empty().append("<option value=\"\" selected=\"selected\">:::::&nbsp;เลือก&nbsp;:::::</option>");
			  }
		}
	});
}
</script>

</body>
</html>