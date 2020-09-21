<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Class Info</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.5.1.js"></script>
    </head>

    <body>
        <?php
            $course = $_GET["course"];

        ?>

        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
            <div>
                <a class="navbar-brand" href="home2.php">
                    <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
                </a>
            </div>

            <div class="col" style="color:white">
                <h2><?php echo $course; ?></h2>
            </div>

            <div class="col text-right">
                <a href="profile.php">
                    <img src="../images/profile.png" alt="profile" width=40 height=40 />
                </a>
            </div>
        </div>

        <div class="container" style="margin-top: 50px;">
            <h3>
                Class Members
            </h3>
            <form action="add_students.php" method="POST">
                <label>
                    <input name="students" class="form-control" placeholder="Students to be added" required />
                </label>
                <button  class="btn btn-success">Add +</button>
            </form>
            <p>List of members...</p>

            <h3>
                Tasks
            </h3>
            <a href="add_task.php">
                <button class="btn btn-success">Create Task &#8680;</button>
            </a>
            <br>
            <p>List of tasks...</p>
        </div>
    </body>
</html>
