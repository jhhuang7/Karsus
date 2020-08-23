<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
        .scroll {
            max-height: 300px;
            overflow-y: auto;
        }

        .card-deck {
            margin-bottom: 30px
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $id = $_SESSION["id"];

    $serverName = "tcp:karsus.database.windows.net,1433";
    $connectionOptions = array(
        "UID" => "karsus", "PWD" => "K@rth0us",
        "Database" => "Karsus", "LoginTimeout" => 30,
        "Encrypt" => 1, "TrustServerCertificate" => 0
    );

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false) {
        // Connection problem
        header("Location: index.html");
        exit();
    }

    $tsql = "SELECT FirstName FROM Students WHERE id =" . $id . ";";
    $getResults = sqlsrv_query($conn, $tsql);

    if ($getResults == FALSE) {
        // Query problem
        header("Location: index.html");
        exit();
    }

    $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
    $name = $row["FirstName"];
    echo "<h1>Welcome $name!</h1><hr>";
    ?>

    <div class="container">
        <div class="card-deck">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Classes</h4>
                    <div class="container scroll">
                        <p class="card-text">
                            <button type="button" name="" id="" class="btn btn-primary w-100" btn-lg btn-block">DECO3801</button>
                        </p>
                        <p class="card-text">
                            <button type="button" name="" id="" class="btn btn-primary w-100" btn-lg btn-block">COMP3702</button>
                        </p>
                        <p class="card-text">
                            <button type="button" name="" id="" class="btn btn-primary w-100" btn-lg btn-block">COMS3000</button>
                        </p>
                    </div>

                </div>
            </div>
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Tasks</h4>
                    <div class="container scroll">
                        <p class="card-text">
                            <button type="button" name="" id="" class="btn btn-info w-100 text-left" btn-lg btn-block">DECO3801: Design home page for Client Dashboard</button>
                        </p>
                        <p class="card-text">
                            <button type="button" name="" id="" class="btn btn-info w-100 text-left" btn-lg btn-block">COMP3702: Develop AI controls for LaserTanks</button>
                        </p>
                        <p class="card-text">
                            <button type="button" name="" id="" class="btn btn-info w-100 text-left" btn-lg btn-block">COMS3000: Discover 2 vulnerabilities in SeedLAB</button>
                        </p>
                    </div>
                    <div class="container" style="margin-top: 18px;">
                        <p class="card-text">
                            <button type="button" name="" id="" class="btn btn-secondary w-100 text-left" btn-lg btn-block">Completed Tasks</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-deck">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Leader board</h4>
                    <div class="container scroll">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>William Fitzmaurice</td>
                                    <td><img src="images/Avatar_sml.PNG" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt=""></td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Harry Huang</td>
                                    <td><img src="images/Avatar_sml.PNG" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt=""></td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Jacob Watson</td>
                                    <td><img src="images/Avatar_sml.PNG" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt=""></td>
                                    <td>20</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title">Customise</h4>
                    <img src="images/Avatar.PNG" class="img-thumbnail w-50 mx-auto d-block" alt="Avatar">
                </div>
            </div>
        </div>
    </div>
</body>

</html>