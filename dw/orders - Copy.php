<?php
	error_reporting(-1);
	ini_set('display_errors', true);
	 
	$username = "dwbi2";                  // Use your username
	$password = "dwbi2";             // and your password
	$database = "localhost/o12c";   // and the connect string to connect to your database
	
	$c = oci_connect($username, $password, $database);
	if (!$c) {
		$m = oci_error();
		trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$transport = rand(5, 25);
		$invoice = $transport + rand(5, 100);

		$query = "INSERT INTO dwbi1.INVOICE (ID_CLIENT, INVOICE_DATE, TRANSPORT_VALUE, INVOICE_VALUE) VALUES ('" . $_POST["ID_CLIENT"] . "', CURRENT_DATE, '" . $transport . "','" . $invoice . "')";
		
		$s = oci_parse($c, $query);
		if (!$s) {
			$m = oci_error($c);
			trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
		}
		
		$r = oci_execute($s);
		if (!$r) {
			$m = oci_error($s);
			trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
		}
		
		oci_free_statement($s);
		
		$query = "SELECT ID_INVOICE FROM (SELECT ID_INVOICE FROM dwbi1.INVOICE ORDER BY ID_INVOICE DESC) WHERE ROWNUM = 1";
		
		$s = oci_parse($c, $query);
		if (!$s) {
			$m = oci_error($c);
			trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
		}
		
		$r = oci_execute($s);
		if (!$r) {
			$m = oci_error($s);
			trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
		}
				
		if ($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS))
		{
			$query = "INSERT INTO dwbi1.REQUEST_ORDER (ID_CLIENT, ID_LIFT_POINT, ID_DELIVERY_POINT, ID_STATUS, ID_DRIVER_VEHICLE, ID_INVOICE) VALUES ('" . $_POST["ID_CLIENT"] . "','" . $_POST["ID_LIFT_POINT"] . "','" . $_POST["ID_DELIVERY_POINT"] . "','" . $_POST["ID_STATUS"] . "','" . $_POST["ID_DRIVER_VEHICLE"] . "','" . $row["ID_INVOICE"] . "')";
			
			$s = oci_parse($c, $query);
			if (!$s) {
				$m = oci_error($c);
				trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
			}
			
			$r = oci_execute($s);
			if (!$r) {
				$m = oci_error($s);
				trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
			}
			
			oci_free_statement($s);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>DW</title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
		
		<!--Data Tables-->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css"> 

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="index.php" class="nav-link js-scroll-trigger">Clients</a></li>
                    <li class="nav-item"><a href="orders.php" class="nav-link js-scroll-trigger">Orders</a></li>
                </ul>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <!-- About-->
            <section class="resume-section">
                <div class="resume-section-content">
                    <h1 class="mb-5">
                        Orders
                    </h1>
                    <div class="mb-5">
						<?php
							$query = 'SELECT 
										a.ORDERID, 
										a.DIMCLIENTID, 
										b.NAME "CLIENT NAME", 
										b.PHONE "CLIENT PHONE",
										b.ADDRESS "CLIENT ADDRESS", 
										b.PC "CLIENT POSTAL CODE", 
										b.EMAIL "CLIENT EMAIL", 
										a.DIMVEHICLEID, 
										c.BRAND "VEHICLE NAME", 
										c.MODEL "VEHICLE MODEL", 
										c.PLATE "VEHICLE PLATE", 
										c.VIN "VEHICLE VIN", 
										c.COLOR "VEHICLE COLOR", 
										a.DIMDRIVERID, 
										d.NAME "DRIVER NAME", 
										d.CNP "DRIVER CNP", 
										d.PHONE "DRIVER PHONE", 
										a.DIMORDERDATEID, 
										e.DATENUMBER "ORDER DATENUMBER", 
										e.DAY "ORDER DAY", 
										e.MONTH "ORDER MONTH", 
										e.YEAR "ORDER YEAR", 
										a.DIMDELIVERYDATEID, 
										f.DATENUMBER "DELIVERY DATENUMBER", 
										f.DAY "DELIVERY DAY", 
										f.MONTH "DELIVERY MONTH", 
										f.YEAR "DELIVERY YEAR", 
										a.DIMLIFTINGDATEID, 
										g.DATENUMBER "LIFTING DATENUMBER", 
										g.DAY "LIFTING DAY", 
										g.MONTH "LIFTING MONTH", 
										g.YEAR "LIFTING YEAR", 
										a.DIMDELIVERYCITYID, 
										h.CITYNAME "DELIVERY CITY", 
										h.REGIONNAME "DELIVERY REGION", 
										a.DIMLIFTINGCITYID, 
										i.CITYNAME "LIFTING CITY", 
										i.REGIONNAME "LIFTING REGION", 
										a.TRANSPORTVALUE, 
										a.INVOICEVALUE, 
										a.DELIVERYSTREET, 
										a.DELIVERYPOSTALCODE, 
										a.DELIVERYPERSONNAME, 
										a.DELIVERYPERSONPHONE, 
										a.LIFTINGSTREET, 
										a.LIFTINGPOSTALCODE, 
										a.LIFTINGPERSONNAME, 
										a.LIFTINGPERSONPHONE 
									FROM 
										FACTS_ORDERS a 
										inner join DIM_CLIENTS b on a.DIMCLIENTID = b.CLIENTID 
										left join DIM_VEHICLES c on a.DIMVEHICLEID = c.VEHICLEID 
										inner join DIM_DRIVERS d on a.DIMDRIVERID = d.DRIVERID 
										inner join DIM_DATE e on a.DIMORDERDATEID = e.DATEID 
										inner join DIM_DATE f on a.DIMDELIVERYDATEID = f.DATEID 
										inner join DIM_DATE g on a.DIMLIFTINGDATEID = g.DATEID 
										inner join DIM_CITIES h on a.DIMDELIVERYCITYID = h.CITYID 
										inner join DIM_CITIES i on a.DIMLIFTINGCITYID = i.CITYID';
							
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
														
							echo "<table id='table'>\n";
							
							$ncols = oci_num_fields($s);
							echo "<thead><tr>\n";
							for ($i = 1; $i <= $ncols; ++$i) {
								$colname = oci_field_name($s, $i);
								echo "  <th>".htmlspecialchars($colname,ENT_QUOTES|ENT_SUBSTITUTE)."</th>\n";
							}
							echo "</tr></thead>\n";
							
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<tr>\n";
								foreach ($row as $item) {
									echo "<td>";
									echo $item!==null?htmlspecialchars($item, ENT_QUOTES|ENT_SUBSTITUTE):"&nbsp;";
									echo "</td>\n";
								}
								echo "</tr>\n";
							}
							echo "</table>\n";
							oci_free_statement($s);
						?>
                    </div>
                </div>
			</section>
			
			<section class="resume-section">	
                <div class="resume-section-content">
                    <h1 class="mb-5">
                        Add order
                    </h1>
					
					<form action="orders.php" method="POST">
						<div class="mb-2">
							
						<?php							 
							$query = "select ID_CLIENT, FIRST_NAME, LAST_NAME from dwbi1.CLIENT";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							echo "<select name='ID_CLIENT' required><option disabled>Select a client</option>\n";
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<option value ='" . $row["ID_CLIENT"] . "'>" . $row["ID_CLIENT"] . " - " . $row["FIRST_NAME"] . " " . $row["LAST_NAME"] . "</option>";
							}
							echo "</select>";
							
							oci_free_statement($s);
						?>
						</div>
						<div class="mb-2">
						
						<?php							 
							$query = "select * from dwbi1.LIFT_POINT";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							echo "<select name='ID_LIFT_POINT' required><option disabled>Select a lift point</option>\n";
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<option value ='" . $row["ID_LIFT_POINT"] . "'>" . $row["STREET_NAME"] . " " . $row["STREET_NUMBER"] . "</option>";
							}
							echo "</select>";
							
							oci_free_statement($s);
						?>
						</div>
						
						<div class="mb-2">
						
						<?php							 
							$query = "select * from dwbi1.DELIVERY_POINT";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							echo "<select name='ID_DELIVERY_POINT' required><option disabled>Select a delivery point</option>\n";
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<option value ='" . $row["ID_DELIVERY_POINT"] . "'>" . $row["ID_DELIVERY_POINT"] . " - " . $row["STREET_NAME"] . " " . $row["STREET_NUMBER"] . "</option>";
							}
							echo "</select>";
							
							oci_free_statement($s);
						?>
						</div>
						
						
						<div class="mb-2">
						<?php							 
							$query = "select * from dwbi1.STATUS";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							echo "<select name='ID_STATUS' required><option disabled>Select status</option>\n";
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<option value ='" . $row["ID_STATUS"] . "'>" . $row["DESCRIPTION"] . "</option>";
							}
							echo "</select>";
							
							oci_free_statement($s);
						?>
						
						</div>
						<div class="mb-2">
						<?php							 
							$query = "select a.ID_DRIVER_VEHICLE, b.FIRST_NAME, b.LAST_NAME, d.NAME from dwbi1.DRIVER_VEHICLE a inner join dwbi1.DRIVER b on a.ID_DRIVER = b.ID_DRIVER inner join dwbi1.VEHICLE c on a.ID_VEHICLE = c.ID_VEHICLE inner join dwbi1.VEHICLE_MODEL d on c.ID_VEHICLE_MODEL = d.ID_VEHICLE_MODEL";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							echo "<select name='ID_DRIVER_VEHICLE' required><option disabled>Select a driver</option>\n";
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<option value ='" . $row["ID_DRIVER_VEHICLE"] . "'>" . $row["FIRST_NAME"] . " " . $row["LAST_NAME"] . " - " . $row["NAME"] ."</option>";
							}
							echo "</select>";
							
							oci_free_statement($s);
						?>
						</div>
						
						
						<div class="mb-5">
							<button type="submit">Add</button>
						</div>
					</form>
				</div>
				
            </section>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
     
	 <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
       
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>		

	   <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
		
		<script type="text/javascript">
			$(document).ready( function () {
				$('#table').DataTable({
					"columns": [
					
						{ "data": "ORDERID" },
						{ "data": "DIMCLIENTID" },
						{ "data": "CLIENT NAME" },
						{ "data": "CLIENT PHONE" },
						{ "data": "CLIENT ADDRESS" },
						{ "data": "CLIENT POSTAL CODE" },
						{ "data": "CLIENT EMAIL" },
						{ "data": "DIMVEHICLEID" },
						{ "data": "VEHICLE NAME" },
						{ "data": "VEHICLE MODEL" },
						{ "data": "VEHICLE PLATE" },
						{ "data": "VEHICLE VIN" },
						{ "data": "VEHICLE COLOR" },
						{ "data": "DIMDRIVERID" },
						{ "data": "DRIVER NAME" },
						{ "data": "DRIVER CNP" },
						{ "data": "DRIVER PHONE" },
						{ "data": "DIMORDERDATEID" },
						{ "data": "ORDER DATENUMBER" },
						{ "data": "ORDER DAY" },
						{ "data": "ORDER MONTH" },
						{ "data": "ORDER YEAR" },
						{ "data": "DIMDELIVERYDATEID" },
						{ "data": "DELIVERY DATENUMBER" },
						{ "data": "DELIVERY DAY" },
						{ "data": "DELIVERY MONTH" },
						{ "data": "DELIVERY YEAR" },
						{ "data": "DIMLIFTINGDATEID" },
						{ "data": "LIFTING DETANUMBER" },
						{ "data": "LIFTING DAY" },
						{ "data": "LIFTING MONTH" },
						{ "data": "LIFTING YEAR" },
						{ "data": "DIMDELIVERYCITYID" },
						{ "data": "DELIVERY CITY" },
						{ "data": "DELIVERY REGION" },
						{ "data": "DIMLIFTINGCITYID" },
						{ "data": "LIFTING CITY" },
						{ "data": "LIFTING REGION" },
						{ "data": "TRANSPORTVALUE" },
						{ "data": "INVOICEVALUE" },
						{ "data": "DELIVERYSTREET" },
						{ "data": "DELIVERYPOSTALCODE" },
						{ "data": "DELIVERYPERSONNAME" },
						{ "data": "DELIVERYPERSONPHONE" },
						{ "data": "LIFTINGSTREET" },
						{ "data": "LIFTINGPOSTALCODE" },
						{ "data": "LIFTINGPERSONNAME" },
						{ "data": "LIFTINGPERSONPHONE" }
					],
					responsive: false,
					scrollX: true
				});
			});
		</script>
    </body>
</html>
<?php 
	oci_close($c);
?>
