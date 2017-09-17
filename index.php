<!--/////////////////////////////
// Written by: Ilan Patao //
// ilan@dangerstudio.com //
//////////////////////////-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pull-a-Part Inventory REST API Example</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="https://autotrader-api.herokuapp.com/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://autotrader-api.herokuapp.com/css/mdb.min.css" rel="stylesheet">
    <!-- BST core CSS -->
    <link href="https://autotrader-api.herokuapp.com/js/bootstrap-table.min.css" rel="stylesheet">
</head>

<body>


    <div class="container" style="margin-top:25px;">
        <div class="flex-center flex-column">
            <h1 class="animated fadeIn mb-4">Pull-A-Part Inventory REST API Example</h1>

            <h5 class="animated fadeIn mb-3"></h5>

            <p class="animated fadeIn text-muted"></p>	
			

		<div class="table-responsive" id="results">
        <table id="table"
               data-toggle="table"
			   data-height="625"
			   data-page-size="100"
               data-show-columns="true"
               data-pagination="true"
               data-search="true">
            <thead>
            <tr>
                <th data-field="date" data-sortable="true">Date</th>
				<th data-field="id" data-sortable="true">ID</th>
				<th data-field="year" data-sortable="true">Year</th>
				<th data-field="make" data-sortable="true">Make</th>
				<th data-field="model" data-sortable="true">Model</th>
				<th data-field="body" data-sortable="true">Body</th>
				<th data-field="trim" data-sortable="true">Trim</th>
				<th data-field="doors" data-sortable="true">Doors</th>
				<th data-field="drive" data-sortable="true">Drive</th>
				<th data-field="fuel" data-sortable="true">Fuel</th>
				<th data-field="cyl" data-sortable="true">Cyl</th>
				<th data-field="vin" data-sortable="true">VIN</th>
				<th data-field="location" data-sortable="true">Location</th>
				
            </tr>
            </thead>
				
			<?PHP
			// Make and loop through the request
			while($i <= 10) {
				$x = 0;
				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://externalinterchangeservice.pullapart.com/interchange/AdvancedVehicleSearch/",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "{\"Locations\":[19,27,14,6,13,22,17,8,12,10,15,18,29,30,20,11,7,24,5,16,9,4,3,21,25],\"Make\":".$i.",\"Models\":[\"-1\"],\"Years\":[\"-1\"]}",
				  CURLOPT_HTTPHEADER => array(
					"accept: application/json, text/plain, */*",
					"accept-encoding: gzip, deflate, br",
					"accept-language: en-US,en;q=0.8",
					"cache-control: no-cache",
					"connection: keep-alive",
					"content-type: application/json;charset=UTF-8",
					"origin: https://www.pullapart.com",
					"referer: https://www.pullapart.com/inventory/search/?LocationID=25^&MakeID=3^&ModelID=3",
					"user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36"
				  ),
				));
				
				$results = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
				// Decode json response and assign variables
				$jdata = json_decode($results);
				// Build the table rows
				foreach ($jdata as $key){
					$row = $jdata[$x]->row;
					if ($row > 0){
					$datet = $jdata[$x]->dateYardOn;
					$datearr = explode("T",$datet);
					$date = $datearr[0];
					$year = $jdata[$x]->modelYear;
					$make = $jdata[$x]->makeName;
					$model = $jdata[$x]->modelName;
					$body = $jdata[$x]->vinInformation->bodyType;
					$trim = $jdata[$x]->vinInformation->trim;
					$doors = $jdata[$x]->vinInformation->doors;
					$dtype = $jdata[$x]->vinInformation->driveType;
					$cylindars = $jdata[$x]->vinInformation->engineCylinders;
					$fuel = $jdata[$x]->vinInformation->fuelType;
					$vin = $jdata[$x]->vinInformation->vinNumber;
					$id = $jdata[$x]->idNumber;
					$location = $jdata[$x]->locationName;
					//$ymm = explode(" ",$title);
					//$year = $ymm[1];
					//$make = $ymm[2];
					//$model = $ymm[3];
					$x = $x + 1;
					
					echo "<tr>";
					echo "<td>" . $date . "</td>";
					echo "<td>" . $id . "</td>";
					echo "<td>" . $year . "</td>";
					echo "<td>" . $make . "</td>";
					echo "<td>" . $model . "</td>";
					echo "<td>" . $body . "</td>";
					echo "<td>" . $trim . "</td>";
					echo "<td>" . $doors . "</td>";
					echo "<td>" . $dtype . "</td>";
					echo "<td>" . $fuel . "</td>";
					echo "<td>" . $cylindars . "</td>";
					echo "<td>" . $vin . "</td>";
					echo "<td>" . $location . "</td>";
					echo "</tr>";
					}
				}
				$i = $i + 1;
			}	
			
			?>

        </table>
		</div>
		

		
		<center>
				<p class="animated fadeIn text-muted">
					This demo fetches vehicle make IDs 1 through 10; you can increase the loop; however there is a longer render time with the more vehicle information you request. All vehicles are polled in real-time directly from the PAP inventory service.
				</p>
							
			<br>Written by: <a href="mailto:ilan@dangerstudio.com" style="text-decoration:none;">Ilan Patao</a> - 09/17/2017
			
		</center>
        </div>
    </div>
    <!-- JQuery -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/mdb.min.js"></script>
    <!-- BST core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/bootstrap-table.min.js"></script>
</body>
<script>
$(document).ready(function(){
});
</script>
</html>
