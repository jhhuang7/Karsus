<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Task</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
            <div>
                <a class="navbar-brand" href="home2.php">
                    <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
                </a>
            </div>

            <div class="col" style="color:white">
                <h2>Add Task For <?php $course = $_GET["course"]; echo $course; ?></h2>
            </div>

            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                    <img src="../images/profile.png" alt="profile" width=30 height=30 />
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">Edit Profile</a>
                    <a class="dropdown-item" href="../index.html?status=loggedout">Log Out</a>
                </div>
            </div>
        </div>

        <div class="container" style="margin-top: 50px;">
            <form action="append_task.php" method="POST">
                <?php echo '<input type="hidden" name="course" value="' . $course . '"/>'; ?>

                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required />

                <label for="due">Due Date</label>
                <input type="date" class="form-control" id="due" name="due" required />

                <label for="des">Description</label>
                <input type="text" class="form-control" id="des" name="des" required />

                <label for="qs">Questions</label>
                <textarea type="text" class="form-control" id="qs" name="qs" required>
                    Placeholder for now, need to handle multiple questions.
                </textarea>

                <br>
                <button type="submit" class="btn btn-success float-right">Submit</button>
            </form>
        </div>
    </body>
</html>
