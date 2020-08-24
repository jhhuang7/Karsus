<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script>
        function switchHat(h) {
            document.getElementById('hat').src = '../images/avatars/' + h;
        }

        function switchOutfit(o) {
            document.getElementById('outfit').src = '../images/avatars/' + o;
        }
    </script>
    <style>
        .avatar {
            position: relative;
            top: 0;
            left: 0;
        }

        #baseAvatar {
            position: relative;
            top: 0;
            left: 0;
        }

        #hat {
            position: absolute;
            top: -10px;
            left: 0;

        }
        #outfit {
            position: absolute;
            top: 240px;
            left: 0;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="avatar">
            <img id="baseAvatar" src="../images/avatars/base2.png">
            <img id="hat" src="../images/avatars/witch-hat.png">
            <img id="outfit" src="../images/avatars/suit.png">
        </div>
    </div>
    <div class="container">
        <p class="h2">Hats</p>
        <button onclick="switchHat('cap_student.png')">Graduation Cap 1</button>
        <button onclick="switchHat('cap_student2.png')">Graduation Cap 2</button>
        <button onclick="switchHat('tophat.png')">Top Hat</button>
        <button onclick="switchHat('witch-hat.png')">Witch Hat</button>
    </div>
    <div class="container">
        <p class="h2">Outfits</p>
        <button onclick="switchOutfit('coat.png')">Coat</button>
        <button onclick="switchOutfit('jacket.png')">Jacket</button>
        <button onclick="switchOutfit('suit.png')">Suit</button>
    </div>
</body>

</html>