<html lang="en">
     <head>
        <title>PHP-Database-Test</title>
     </head>

     <body>
        <?php
            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
                    "Database" => "Karsus", "LoginTimeout" => 30,
                    "Encrypt" => 1, "TrustServerCertificate" => 0);

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                echo "Connection failed :(";
                die(print_r( sqlsrv_errors(), true));
            }
            echo "Connected!" . "<br>";

            $tsql = "SELECT * FROM Users;";
            $getResults = sqlsrv_query($conn, $tsql);

            echo "Reading id data from table Users:" . "<br>";
            if ($getResults == FALSE) {
                die(print_r(sqlsrv_errors(), true));
            }

        	while ($row = sqlsrv_fetch_array($getResults,
                    SQLSRV_FETCH_ASSOC)) {
        		echo $row["id"] . "<br>";
        	}
        ?>
     </body>
</html>
