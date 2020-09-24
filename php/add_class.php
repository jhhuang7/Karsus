<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Class</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.5.1.js"></script>
    </head>

    <body>
        <?php
            session_start();
            $id = $_SESSION["id"];
        ?>
        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
            <div>
                <a class="navbar-brand" href="home2.php">
                    <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
                </a>
            </div>

            <div class="col" style="color:white">
                <h2>Add Class</h2>
            </div>

            <div class="col text-right">
                <a href="profile.php">
                    <img src="../images/profile.png" alt="profile" width=40 height=40 />
                </a>
            </div>
        </div>

        <div class="container" style="margin-top: 50px;">
            <form action="append_class.php" method="POST">
                <label for="code">Course Code</label>
                <input type="text" class="form-control" id="code" name="code" required />

                <label for="sem">Semester</label>
                <input type="date" class="form-control" id="sem" name="sem" required />

                <label for="title">Course Title</label>
                <input type="text" class="form-control" id="title" name="title" required />

                <label for="id">Coordinator Id</label>
                <?php
                    echo '<input type="text" class="form-control" id="id" name="id" value="' . $id . '" readonly />';
                ?>

                <br>
                <button type="submit" class="btn btn-success float-right">Submit</button>
            </form>

            <div
                class="form-group"
                id="errorDiv"
                style="visibility:hidden;"
            >
                <p style="color: red">
                    Unable to add your class, please check and try again!
                </p>
            </div>
        </div>

        <script>
            let params = {};

            window.location.search
                .slice(1)
                .split("&")
                .forEach((elm) => {
                    if (elm === "") return;
                    let spl = elm.split("=");
                    const d = decodeURIComponent;
                    params[d(spl[0])] = spl.length >= 2 ? d(spl[1]) : true;
                });

            if (params["status"] === "badadd") {
                document.getElementById('errorDiv').style.visibility
                    = "visible";
            }
        </script>
    </body>
</html>
