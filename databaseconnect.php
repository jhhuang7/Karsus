<html>
 <head>
  <title>PHP-Test</title>
 </head>
 <body>
	<?php

	$serverName = "tcp:karsus.database.windows.net,1433";
	$connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us", 
			"Database" => "Karsus", "LoginTimeout" => 30, "Encrypt" => 1,
			"TrustServerCertificate" => 0);
	$conn = sqlsrv_connect($serverName, $connectionOptions);
	if($conn == false) {
		echo "Connection failed";
		die( print_r( sqlsrv_errors(), true));
	}
		
	echo "Connected" . '<br>';

	$tsql= "SELECT id FROM Karsus.dbo.Test;";
	$getResults= sqlsrv_query($conn, $tsql);
	echo ("Reading data from table" . '<br>');
	if ($getResults == FALSE)
		die(print_r( sqlsrv_errors(), true));
	while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
		echo $row['id'] . '<br>';
	}

	?>
 </body>
</html>