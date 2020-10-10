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
    <style>
        .delete_btn {
            color: white;
            background-color: red;
            text-align: center;
            margin-left: 10px;
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            box-sizing: border-box;
            cursor: pointer;
            text-decoration: none;
        }

        .delete_btn:hover {
            text-decoration: none;
            color: white;
            background-color: darkred;
        }

        .question_div {
            margin-bottom: 10px;
        }

        .question_input {
            height: 30px;
            box-sizing: border-box;
            padding-left: 10px;
            width: 50%  ;
        }
    </style>
</head>

<body>
    <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
        <div>
            <a class="navbar-brand" href="home2.php">
                <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
            </a>
        </div>

        <div class="col" style="color:white">
            <h2>Add Task For <?php $course = $_GET["course"];
                                echo $course; ?></h2>
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
        <form action="append_task.php" method="POST" onsubmit="return fillInQuestions()">
            <?php echo '<input type="hidden" name="course" value="' . $course . '"/>'; ?>

            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required />

            <label for="due">Due Date</label>
            <input type="date" class="form-control" id="due" name="due" required />

            <label for="des">Description</label>
            <input type="text" class="form-control" id="des" name="des" required />

            <label for="qs">Questions</label>
            <div id="questions"></div>
            <a id="add_text_box_btn" class="btn btn-primary">Add Question</a>
            <textarea type="text" class="form-control" id="qs" name="qs" required style="visibility: hidden;">
                    Placeholder for now, need to handle multiple questions.
                </textarea>

            <br>
            <button type="submit" class="btn btn-success float-right" id="submit_btn">Submit</button>
        </form>
    </div>
</body>
<script>
    let i = 0;

    document
        .getElementById("add_text_box_btn")
        .addEventListener("click", () => {
            add_text_box();
        });


    function add_text_box() {
        let id = "textquestion_" + i;
        i++;
        let div = document.createElement("div");
        div.id = id;
        div.classList.add("question_div");

        let text = document.createElement("input");
        text.setAttribute("type", "text");
        text.classList.add("question_input");

        let delete_btn = document.createElement("a");
        let delete_text = document.createTextNode("X");
        delete_btn.appendChild(delete_text);
        delete_btn.classList.add("delete_btn");
        delete_btn.addEventListener("click", () => {
            document.getElementById(id).remove();
            return false;
        });

        div.appendChild(text);
        div.appendChild(delete_btn);

        document.getElementById("questions").appendChild(div);
    }

    function fillInQuestions() {
        let question_div = document.getElementById("questions");
        let questions = [];

        for (let j = 0; j < question_div.childNodes.length; j++) {
            let node = question_div.childNodes[j];
            let textbox = node.getElementsByTagName("input")[0];
            let question = textbox.value;
            question.trim();
            question = question.replace('|', '/');
            if (question != "") {
                questions.push(question);
            }
        }


        document.getElementById('qs').value = questions.join('|');
        return true;
    }
</script>

</html>