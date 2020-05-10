<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>จัดการใบเสร็จรับเงิน</title>
<link rel= "stylesheet" href="../../bootstrap/css/bootstrap.css">
<script src="https://unpkg.com/ionicons@4.5.9-1/dist/ionicons.js"></script>
</head>

<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#FFFFCC"><form name="form1" method="get" action="index.php">
      <table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" bgcolor="#FF6600"><span class="h4">จัดการเอกสารใบเสร็จรับเงิน</span></td>
        </tr>
        <tr>
          <td width="200" bgcolor="#FFFF99"><br>
            <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="157" align="center" valign="middle" bgcolor="#FFCC99">ใส่หมายเลขใบแจ้งหนี้</td>
              <td width="66" align="right" bgcolor="#66CCFF">&nbsp;</td>
              <td width="168" align="center" bgcolor="#66CCFF"><input type="text" name="billing_id" id="billing_id"></td>
              <td width="48" align="left" valign="middle" bgcolor="#66CCFF">&nbsp;</td>
              <td width="161" rowspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><input name="pagename" type="hidden" id="pagename" value="listreceipt2">                <input type="submit" name="button" id="button" value="ค้นหา"></td>
            </tr>
            <tr>
              <td height="32" align="center" valign="middle" bgcolor="#CCFFFF">ระบุวันที่ออกใบเสร็จ</td>
              <td height="35" colspan="3" align="center" valign="middle" bgcolor="#CCFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <?php 
						$d = intval(date("d"));
						$m = intval(date("m"));
						$y = intval(date("Y"));
					?>
                  <td width="30%" align="center" valign="middle" bgcolor="#CCFFFF"><label for="d_receipt">วันที่</label>
                    <select name="d_receipt" id="d_receipt">
                      <?php 
					  	for ($i=1 ; $i<=31; $i++)
						{
							if ($d == $i)
							{
								echo "<option value='".$i."' selected='selected'>".$i."</option>"; 								
							}
							else
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
						}					  
					  ?>
                      </select>
                    </td>
                  
                  <td width="45%" align="center" valign="middle" bgcolor="#CCFFFF"><label for="m_receipt">เดิอน</label>
                    <select name="m_receipt" id="m_receipt">
                      <?php
						$m_m[0]="";
						$m_m[1]="มกราคม";
						$m_m[2]="กุมภาพันธ์";
						$m_m[3]="มีนาคม";
						$m_m[4]="เมษายน";
						$m_m[5]="พฤษภาคม";
						$m_m[6]="มิถุนายน";
						$m_m[7]="กรกฏาคม";
						$m_m[8]="สิงหาคม";
						$m_m[9]="กันยายน";
						$m_m[10]="ตุลาคม";
						$m_m[11]="พฤศจิกายน";
						$m_m[12]="ธันวาคม";
						
						for ($i=1 ; $i<=12; $i++)
						{
							if ($m == $i)
							{
								echo "<option value='".$i."' selected='selected'>".$m_m[$i]."</option>"; 								
							}
							else
							{
								echo "<option value='".$i."'>".$m_m[$i]."</option>";
							}
						}			
					?>
                      </select>
                    </td>
                  <td width="25%" align="center" valign="middle" bgcolor="#CCFFFF"><label for="y_receipt">ปี</label>                    
                    <select name="y_receipt" id="y_receipt">                      
                      <?php
					   $y_y = $y-1;					   
					  	for ($i=1 ; $i<=5; $i++)
						{
							if ($y == $y_y)
							{
								echo "<option value='".$y_y."' selected='selected'>".$y_y."</option>"; 								
							}
							else
							{
								echo "<option value='".$y_y."'>".$y_y."</option>";
							}
							$y_y = $y_y + 1;
						}					  
					  ?>
                      </select>
                    </td>
                  </tr>
              </table></td>
              </tr>
            </table>
          <br></td>
        </tr>
      </table>
    </form>
</body>
</html>
