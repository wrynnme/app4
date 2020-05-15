<?php require_once('Connections/ml.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
	session_start();
}
//

if ($_GET["pagename"] <> "") {
	$pagename = $_GET["pagename"];
} else {
	$pagename = 0;
}
if ($_GET["id"] = null) {
	$id = $_GET["id"];
} else {
	$id = 0;
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
	$logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
	//to fully log out a visitor we need to clear the session varialbles
	$_SESSION['MM_Username'] = NULL;
	$_SESSION['MM_UserGroup'] = NULL;
	$_SESSION['PrevUrl'] = NULL;


	unset($_SESSION['MM_Username']);
	unset($_SESSION['MM_UserGroup']);
	unset($_SESSION['PrevUrl']);


	$logoutGoTo = "login/index.php";
	if ($logoutGoTo) {
		header("Location: $logoutGoTo");
		exit;
	}
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}

		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double":
				$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}
}

$colname_searchmember = "-1";
if (isset($_SESSION['MM_Username'])) {
	$colname_searchmember = $_SESSION['MM_Username'];
}
mysql_select_db($database_ml, $ml);
$query_searchmember = sprintf("SELECT * FROM member WHERE username LIKE %s", GetSQLValueString($colname_searchmember, "text"));
$searchmember = mysql_query($query_searchmember, $ml) or die(mysql_error());
$row_searchmember = mysql_fetch_assoc($searchmember);
$totalRows_searchmember = mysql_num_rows($searchmember);

$userstatus = $row_searchmember['status'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once './head.php'; ?>
</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?pagename=0">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas fa-laugh-wink"></i>
				</div>
				<?
				switch ($userstatus) {
					case 0:
						$statustype = "ผู้ดูแลระบบ";
						break;
					case 1:
						$statustype = "เจ้าหน้าที่บัญชี";
						break;
					case 2:
						$statustype = "เจ้าหน้าที่คีย์ข้อมูล";
						break;
				}
				?>
				<div class="sidebar-brand-text mx-3">สวัสดีคุณ<br><?php echo $row_searchmember['firstname']; ?></div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- Nav Item - Dashboard -->
			<li class="nav-item active">
				<a class="nav-link" href="index.php?pagename=0">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
			</li>

			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Heading -->
			<div class="sidebar-heading">
				จัดการข้อมูล
			</div>

			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					<i class="fas fa-fw fa-cog"></i>
					<span>ระบบงานจัดส่งสินค้า</span>
				</a>
				<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<?php
					if ($userstatus == 0 or $userstatus == 2 or $userstatus == 1) {
						echo "				
				  <div class='bg-white py-2 collapse-inner rounded'>
					<h6 class='collapse-header'>จัดส่งสินค้า</h6>
					<a class='collapse-item' href='index.php?pagename=listshipment'>ใบส่งสินค้า</a>
					<a class='collapse-item' href='index.php?pagename=listshipment-select'>พิมพ์ใบส่งสินค้า</a>                      
				  </div>";
					}
					?>

					<?php
					if ($userstatus == 0 or $userstatus == 1) {
						echo "
			  <div class='bg-white py-2 collapse-inner rounded'>
				<h6 class='collapse-header'>เรียกเก็บเงิน</h6>
				<a class='collapse-item' href='index.php?pagename=listbilling'>พิมพ์ใบตั้งเบิก</a>            
				<a class='collapse-item' href='index.php?pagename=listbilling-select'>พิมพ์ใบตั้งเบิกรวม</a> 
				<a class='collapse-item' href='index.php?pagename=receipt'>พิมพ์ใบเสร็จรับเงิน</a>
			  </div>";
					}
					?>

					<?php
					if ($userstatus == 0 or $userstatus == 2) {
						echo "	
			  <div class='bg-white py-2 collapse-inner rounded'>
				<h6 class='collapse-header'>ค่าแรงคนขับรถ</h6>
				<a class='collapse-item' href='index.php?pagename=listbilloil'>บันทึกการใช้น้ำมันรถ</a>
				<a class='collapse-item' href='index.php?pagename=slipmember-select'>สลิปค่าจ้างคนขับรถ</a>
			  </div>";
					}
					?>

				</div>
			</li>



			<!--     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>ระบบงานจัดส่งสินค้า</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">จัดส่งสินค้า</h6>
            <a class="collapse-item" href="index.php?pagename=listshipment">ใบส่งสินค้า</a>
            <a class="collapse-item" href="index.php?pagename=listshipment-select">พิมพ์ใบส่งสินค้า</a>                      
          </div>
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">เรียกเก็บเงิน</h6>
            <a class="collapse-item" href="index.php?pagename=listbilling">พิมพ์ใบตั้งเบิก</a>            
            <a class="collapse-item" href="index.php?pagename=listbilling-select">พิมพ์ใบตั้งเบิกรวม</a> 
            <a class="collapse-item" href="index.php?pagename=receipt">พิมพ์ใบเสร็จรับเงิน</a>
          </div>
		  <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">ค่าแรงคนขับรถ</h6>
            <a class="collapse-item" href="index.php?pagename=listbilloil">บันทึกการใช้น้ำมันรถ</a>
            <a class="collapse-item" href="index.php?pagename=slipmember-select">สลิปค่าจ้างคนขับรถ</a>
          </div>
        </div>
      </li>
 -->
			<!-- Nav Item - Utilities Collapse Menu -->

			<li class='nav-item'>
				<a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseThree' aria-expanded='true' aria-controls='collapseThree'>
					<i class='fas fa-fw fa-wrench'></i>
					<span>ยกเลิกเอกสาร</span>
				</a>
				<?php
				if ($userstatus == 0) //เมนูสำหรับ ยกเลิกเอกสาร
				{
					echo "
        <div id='collapseThree' class='collapse' aria-labelledby='headingUtilities' data-parent='#accordionSidebar'>
          <div class='bg-white py-2 collapse-inner rounded'>
            <h6 class='collapse-header'>ยกเลิกเอกสาร</h6>
			<a class='collapse-item' href='index.php?pagename=reset_bill'>ยกเลิกใบแจ้งหนี้</a>
			<a class='collapse-item' href='index.php?pagename=reset_receipt'>ยกเลิกใบเสร็จรับเงิน</a>            
            <!-- <a class='collapse-item' href='#'>จัดการข้อมูลสินค้า</a> -->
            <!-- <a class='collapse-item' href='#'>จัดการข้อมูลแหล่งรับสินค้า</a> -->
			<a class='collapse-item' href='index.php?pagename=reset_bill_oil'>ยกเลิกใบบันทึกน้ำมัน</a>
            <a class='collapse-item' href='index.php?pagename=reset_bill_member'>ยกเลิกใบเสร็จคนขับรถ</a>
          </div>         
       </div>";
				}
				?>
			</li>
			<!--//// เมนูสำหรับรายงานผลข้อมูลต่างๆ //// -->
			<li class='nav-item'>
				<a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapsefour' aria-expanded='true' aria-controls='collapseThree'>
					<i class='fas fa-fw fa-wrench'></i>
					<span>รายงานและดาวน์โหลด</span>
				</a>
				<?php
				if ($userstatus == 0) //เมนูสำหรับ ยกเลิกเอกสาร
				{
					echo "
        <div id='collapsefour' class='collapse' aria-labelledby='headingUtilities' data-parent='#accordionSidebar'>
          <div class='bg-white py-2 collapse-inner rounded'>
            <h6 class='collapse-header'>รายงานและดาวน์โหลดข้อมูล</h6>
			<a class='collapse-item' href='module/report/report1.php' target='report'>ใบสั่งซื้อ</a>	
			<a class='collapse-item' href='module/report/report2.php' target='report'>ใบจ่ายสินค้า</a>            
			<a class='collapse-item' href='module/report/report3.php' target='report'>ใบวางบิล</a>
            <a class='collapse-item' href='module/report/report4.php' target='report'>ใบเสร็จรับเงิน</a>
            <a class='collapse-item' href='module/report/report5.php' target='report'>ใบเสร็จค่าจ้างคนขับรถ</a>
            <a class='collapse-item' href='module/report/report6.php' target='report'>ใบเสร็จน้ำมัน</a>
            <a class='collapse-item' href='module/report/report7.php' target='report'>ข้อมูลลูกค้า</a>
            <a class='collapse-item' href='module/report/report8.php' target='report'>ข้อมูลคนขับรถ</a>			
          </div>         
       </div>";
				}
				?>
			</li>
			<!--//// จบเมนูสำหรับรายงานผลข้อมูลต่างๆ //// -->
			<?php
			if ($userstatus == 0) //เมนูสำหรับ Admin เพื่อจัดการระบบ
			{
				echo "
     <li class='nav-item'>
        <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseUtilities' aria-expanded='true' aria-controls='collapseUtilities'>
          <i class='fas fa-fw fa-wrench'></i>
          <span>จัดการระบบ</span>
        </a>
        <div id='collapseUtilities' class='collapse' aria-labelledby='headingUtilities' data-parent='#accordionSidebar'>
          <div class='bg-white py-2 collapse-inner rounded'>
            <h6 class='collapse-header'>จัดการข้อมูลระบบการส่งสินค้า</h6>
            <a class='collapse-item' href='index.php?pagename=listcustomer'>จัดการข้อมูลลูกค้า</a>
            <!-- <a class='collapse-item' href='#'>จัดการข้อมูลสินค้า</a> -->
            <!-- <a class='collapse-item' href='#'>จัดการข้อมูลแหล่งรับสินค้า</a> -->
            <a class='collapse-item' href='index.php?pagename=listdrivermember'>จัดการข้อมูลคนขับรถ</a>
          </div>
          <div class='bg-white py-2 collapse-inner rounded'>
            <h6 class='collapse-header'>จัดการข้อมูลระบบ</h6>
            <a class='collapse-item' href='index.php?pagename=listmember'>จัดการข้อมูลสมาชิก</a>
            <!-- <a class='collapse-item' href='#'>จัดการข้อมูลหน่วยงาน</a> -->
          </div>
        </div>
      </li>";
			}
			?>
			<!--      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>จัดการระบบ</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">จัดการข้อมูลระบบการส่งสินค้า</h6>
            <a class="collapse-item" href="index.php?pagename=listcustomer">จัดการข้อมูลลูกค้า</a>
            <a class="collapse-item" href="#">จัดการข้อมูลสินค้า</a>
            <a class="collapse-item" href="#">จัดการข้อมูลแหล่งรับสินค้า</a>
            <a class="collapse-item" href="index.php?pagename=listdrivermember">จัดการข้อมูลคนขับรถ</a>
          </div>
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">จัดการข้อมูลระบบ</h6>
            <a class="collapse-item" href="#">จัดการข้อมูลสมาชิก</a>
            <a class="collapse-item" href="#">จัดการข้อมูลหน่วยงาน</a>
          </div>
        </div>
      </li> -->

			<li class="nav-item active">
				<a class="nav-link" href="<?php echo $logoutAction ?>">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					<span>ออกจากระบบ</span> </a>
			</li>

			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

		</ul>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">


				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
					</div>

					<!-- Content Row -->
					<div class="row">


						<!--///////// การ์ดแสดงข้อมูลของ เจ้าหน้าที่บัญชี /////////////////////// -->
						<!-- Earnings (Monthly) Card Example -->
						<?php
						if ($userstatus == 1) //แสดงการ์ดข้อมูลูสำหรับ เจ้าหน้าที่บัญชี
						{
							//<!-- Card ข้อมูลแสดงจำนวนเอกสารใบเสร็จรับเงินที่รอพิมพ์ --> 
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT * FROM shipment WHERE status=2";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							echo "
				<div class='col-xl-6 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนเอกสารรอพิมพ์ใบเสร็จรับเงิน</div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>$totalRows_query_sql รายการ</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'><a href='index.php?pagename=0&status=2'>ดูข้อมูล</a></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";

							//<!-- Card ข้อมูลแสดงจำนวนเอกสารใบแจ้งหนี้ที่รอพิมพ์ -->
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT * FROM shipment WHERE status=1";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							echo "
				<div class='col-xl-6 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนเอกสารรอพิมพ์ใบแจ้งหนี้</div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>$totalRows_query_sql รายการ</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'><a href='index.php?pagename=0&status=1'>ดูข้อมูล</a></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";
						}
						?>


						<!--///////// การ์ดแสดงข้อมูลของ เจ้าหน้าที่คีย์ข้อมูล /////////////////////// -->
						<!-- Earnings (Monthly) Card Example -->
						<?php
						if ($userstatus == 2) //แสดงการ์ดข้อมูลูสำหรับ เจ้าหน้าที่คีย์ระบบ
						{
							//<!-- Card ข้อมูลแสดงจำนวนคนขับรถของบริษัท --> 
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT * FROM drivermember";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนคนขับรถของบริษัท</div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>" . ($totalRows_query_sql - 1) . "  คน</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";


							//<!-- Card ข้อมูลแสดงจำนวนบริษัทลูกค้า --> 
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT * FROM customer";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนบริษัทที่เป็นลูกค้า</div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>$totalRows_query_sql บริษัท</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";


							//<!-- Card ข้อมูลแสดงจำนวนเอกสารใบจ่ายงานคนขับรถรอพิมพ์ -->
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT * FROM shipment WHERE car_id LIKE '-'";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนเอกสารรอบันทึกจ่ายงานคนขับรถ</div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>$totalRows_query_sql รายการ</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'><a href='index.php?pagename=0&status=99'>ดูข้อมูล</a></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";


							//<!-- Card ข้อมูลแสดงจำนวนรายการรวมยอดที่บันทึกประจำวัน -->  transaction_date
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT * FROM shipment WHERE status=0 AND transaction_date LIKE '" . date("Y-m-d") . "'";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนเอกสารที่เปิดประจำวันที่ " . date('d-m-Y') . " </div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>$totalRows_query_sql รายการ</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'><a href='index.php?pagename=0&status=100'>ดูข้อมูล</a></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";
						}
						?>


						<!--///////// การ์ดแสดงข้อมูลของ ผู้ดูแลระบบ /////////////////////// -->
						<!-- Earnings (Monthly) Card Example -->
						<?php
						if ($userstatus == 0) //แสดงการ์ดข้อมูลูสำหรับ ผู้ดูแลระบบ
						{
							//<!-- Card ข้อมูลแสดงจำนวนรอบการวิ่งรถส่งของในเดือนปัจจุบัน --> 
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT picturestatus2 FROM shipment WHERE transaction_date LIKE '%" . date("Y-m") . "%' and status != 9";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนรอบการส่งสินค้า ประจำเดือน<br>" . date("M/Y") . "</div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>" . $totalRows_query_sql . " </div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";


							//<!-- Card ข้อมูลแสดงยอดรายได้ประจำเดือน --> 
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT total FROM receipt WHERE transaction_date LIKE '%" . date("Y-m") . "%'";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							$totalall = 0;
							do {
								$totalall = $totalall + $row_query_sql['total'];
							} while ($row_query_sql = mysql_fetch_assoc($query_sql));

							echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>รายได้ประจำเดือน<br>" . date("M-Y") . " </div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>" . number_format($totalall, 2) . "</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";


							//<!-- Card ข้อมูลแสดงจำนวนค่าจ้างที่จ่ายให้คนขับรถ -->
							mysql_select_db($database_ml, $ml);
							$sql = "SELECT receipt_member_amout FROM receipt_member WHERE date_payment_member LIKE '%" . date("Y-m") . "%'";
							$query_sql = mysql_query($sql, $ml) or die(mysql_error());
							$row_query_sql = mysql_fetch_assoc($query_sql);
							$totalRows_query_sql = mysql_num_rows($query_sql);
							$totalall_member = 0;
							do {
								$totalall_member = $totalall_member + $row_query_sql['receipt_member_amout'];
							} while ($row_query_sql = mysql_fetch_assoc($query_sql));

							echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>ค่าจ้างคนขับรถที่จ่ายออกประจำเดือน<br>" . date("M-Y") . " </div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>" . number_format($totalall_member, 2) . "</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";

							/*				
			//<!-- Card ข้อมูลแสดงจำนวนรายการรวมยอดที่บันทึกประจำวัน -->  transaction_date
			mysql_select_db($database_ml, $ml);
			$sql = "SELECT * FROM shipment WHERE status=0 AND transaction_date LIKE '".date("Y-m-d")."'";
			$query_sql = mysql_query($sql, $ml) or die(mysql_error());
			$row_query_sql = mysql_fetch_assoc($query_sql);
			$totalRows_query_sql = mysql_num_rows($query_sql);
			echo "
				<div class='col-xl-3 col-md-6 mb-4'>
				  <div class='card border-left-primary shadow h-100 py-2'>
					<div class='card-body'>
					  <div class='row no-gutters align-items-center'>
						<div class='col mr-2'>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'>จำนวนเอกสารที่เปิดประจำวันที่ ".date('d-m-Y')." </div>
						  <div class='h6 mb-0 font-weight-bold text-gray-800'>$totalRows_query_sql รายการ</div>
						  <div class='text-xl font-weight-bold text-primary text-uppercase mb-1'><a href='index.php?pagename=0&status=100'>ดูข้อมูล</a></div>
						</div>
						<div class='col-auto'>
						  <i class='fas fa-calendar fa-2x text-gray-300'></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>";
*/
						}
						?>




						<!--            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">จำนวนการส่งสินค้า (เดือนนี้)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">XXXXXXX</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
 -->
						<!-- Earnings (Monthly) Card Example -->
						<!--            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">จำนวนเงินที่เรียกเก็บ (เดือนนี้)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">XXXXXXXXX</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

						<!-- Earnings (Monthly) Card Example -->
						<!--            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">จำนวนคนขับรถ</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">10</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

						<!-- Pending Requests Card Example -->
						<!--            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">รายได้ (เดือนนี้)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

						<div class="col-xl-12 col-md-6 mb-4">
							<?php
							//echo $pagename;
							switch ($pagename) {
								case "0":
									include "module/shipment/listall.php";
									break;
								case "listshipment":
									include "module/shipment/listshipment.php";
									break;
								case "listshipment-select":
									include "module/shipment/listshipment-select.php";
									break;
								case "listshipment-select2":
									include "module/shipment/listshipment-select2.php";
									break;
								case "addshipment":
									include "module/shipment/addshipment.php";
									break;
								case "addshipment2":
									include "module/shipment/addshipment2.php";
									break;
								case "listbilling":
									include "module/shipment/listbilling.php";
									break;
								case "listbilling-select":
									include "module/shipment/listbilling-select.php";
									break;
								case "listbilling-select2":
									include "module/shipment/listbilling-select2.php";
									break;
								case "receipt":
									include "module/shipment/listreceipt.php";
									break;
								case "listcustomer":
									include "module/customer/listcustomer.php";
									break;
								case "listdrivermember":
									include "module/drivermember/listdrivermember.php";
									break;
								case "receipt":
									include "module/shipment/listreceipt.php";
									break;
								case "listreceipt2":
									include "module/shipment/listreceipt2.php";
									break;
								case "listbilloil":
									include "module/shipment/listbilloil.php";
									break;
								case "listbilloil2":
									include "module/shipment/listbilloil2.php";
									break;
								case "slipmember-select":
									include "module/shipment/slipmember-select.php";
									break;
								case "slipmember-select2":
									include "module/shipment/slipmember-select2.php";
									break;
								case "listmember":
									include "module/member/listmember.php";
									break;
								case "reset_bill":
									include "module/shipment/reset_bill.php";
									//							include "module/shipment/reset_bill_member.php";				
									break;
								case "reset_bill_member":
									include "module/shipment/reset_bill_member.php";
									break;
								case "reset_receipt":
									include "module/shipment/reset_receipt.php";
									break;
								case "reset_bill_oil":
									include "module/shipment/reset_bill_oil.php";
									break;
							}

							?>
						</div>

					</div>
					<!-- /.container-fluid -->

				</div>
				<!-- End of Main Content -->

				<!-- Footer -->
				<footer class="sticky-footer bg-white">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright &copy; THE Logistics 2019</span>
						</div>
					</div>
				</footer>
				<!-- End of Footer -->

			</div>
			<!-- End of Content Wrapper -->

		</div>
		<!-- End of Page Wrapper -->

		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>

		<!-- Bootstrap core JavaScript-->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Core plugin JavaScript-->
		<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

		<!-- Custom scripts for all pages-->
		<script src="js/sb-admin-2.min.js"></script>

		<!-- Page level plugins -->
		<script src="vendor/chart.js/Chart.min.js"></script>

		<!-- Page level custom scripts -->
		<script src="js/demo/chart-area-demo.js"></script>
		<script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
<?php
mysql_free_result($searchmember);
?>