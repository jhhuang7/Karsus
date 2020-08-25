<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body>
        <h1>Profile</h1>
        <a href="../index.html?status=loggedout">Log out</a>
        <hr>

        <?php
            session_start();
            $id = $_SESSION["id"];

            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
                "Database" => "Karsus", "LoginTimeout" => 30,
                "Encrypt" => 1, "TrustServerCertificate" => 0);

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                // Connection problem
                header("Location: home.php");
                exit();
            }

            $tsql = 'select * from Students where id = ' . $id;
            $getResults = sqlsrv_query($conn, $tsql);

            if ($getResults == FALSE) {
                // Query problem
                header("Location: home.php");
                exit();
            }

            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);

            echo "<form action='update.php' method='POST'>";

            echo "<label onclick='lockedParam()'>Student ID: " .
                $row["id"] ."</label> <br>";

            echo "<label>First Name</label> <br>";
            echo "<input type='text' class='form-control' id='first' 
                name='first' value='" . $row["FirstName"] . "' /> <br>";

            echo "<label>Last Name</label> <br>";
            echo "<input type='text' class='form-control' id='last' 
                name='last' value='" . $row["LastName"] . "' /> <br>";

            echo "<label>Email</label> <br>";
            echo "<input type='email' class='form-control' id='email' 
                name='email' value='" . $row["email"] . "' /> <br>";

            echo "<label>Phone Number</label> <br>";
            echo "<input type='number' class='form-control' id='phone'
                name='phone' value=" . $row["phone"] . " /> <br>";

            echo "<label>Password</label> <br>";
            echo "<input type='password' class='form-control' id='pw' 
                name='pw' placeholder='Your Password' /> <br>";

            echo "<label onclick='lockedParam()'>Score: "
                . $row["score"] . "</label> <br>";

            echo "<button>Update Details</button> </form>"
        ?>

        <form action="home.php">
            <button>Back to Home</button>
        </form>

        <script>
            function lockedParam() {
                alert("You can't change this detail, as it is locked up!");
            }
        </script>
    </body>
</html>
