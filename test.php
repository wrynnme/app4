<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>

</head>

<body>
<?php
//	echo "วันนี้วันที่ : ".date("Y-m-d")."<br>";
//	echo "Timestmp วันนี้ : ".strtotime(date("Y-m-d"))."<br>";
//	echo "Timestmp วันพรุ่งนี้ :".strtotime(date("Y-m-d")) + (60 *60 *24)."<br>" ; 
//	echo "พรุ่งนี้คือวันที่ :".date("Y/m/d", strtotime(date("Y-m-d")) + ((60 *60 *24)*2));  
?>

<form name="frmprice" method="POST">
<table>

<tr>
    <td>
    <!-- เปลี่ยน type เป็น number  -->
    <input type="number" name="price" id="price" onkeyup="fncSum();" value="0"></td>
</tr>

<tr>
<td>
<label>Total : </label>
<input type="text" name="sumprice" readonly></td>
</tr>
</table>
</form>

<script language="JavaScript">
  function fncSum()
  {
    
    var sum = 0;
//    for(var i=0;i<document.frmprice['price'].length;i++){
      // เช็คค่าว่างเอาครับ
      if(document.frmprice['price'].value !=""){
      sum += parseFloat(document.frmprice['price'].value);
      }
//    }
    document.frmprice.sumprice.value = sum; 
            
  }

</script>


</body>
</html>