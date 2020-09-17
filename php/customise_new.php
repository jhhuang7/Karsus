<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customise</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
    <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
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
            min-height: 620px;
            min-width: 600px;
        }

        .shop-item {
            width: 150px;
            height: 150px;
            padding: 5px;
            display: inline-block;
            border: 3px solid white;
            border-radius: 5px;
            margin-bottom: 5px;
            margin-right: 5px;
        }

        .shop-item img {
            width: 90px;
            height: 90px;
            display: block;
            border: none;
        }

        #arms {
            position: absolute;
            top: 16px;
            left: 0;
            z-index: 98;
        }

        #body_img {
            position: absolute;
            top: 16px;
            left: 0;
        }

        #eyes {
            position: absolute;
            top: 5px;
            left: 0;
        }

        #hair {
            position: absolute;
            top: 5px;
            left: 0;
        }

        #hat {
            position: absolute;
            top: 0px;
            left: 0;
            z-index: 99;
        }

        #mouth {
            position: absolute;
            top: 6px;
            left: 0;
        }

        #pants {
            position: absolute;
            top: 14px;
            left: 0;
        }
    </style>
</head>

<?php

class ShopItem
{
    public string $imgsrc = "Default";
    public bool $purchased = false;
    public bool $amWearing = false;
    public int $cost = 0;
}

$items = array(
    "arms" => array(),
    "body" => array(),
    "eyes" => array(),
    "hair" => array(),
    "hat" => array(),
    "mouth" => array(),
    "pants" => array()
);

// Default avatar look, replaced with items the user is wearing
$wearing = array(
    "arms" => 'arms-female-normal-pale.png',
    "body" => 'body-female-normalBlack.png',
    "eyes" => 'eyes-normal.png',
    "hair" => 'hair-female-normalBrown-pale.png',
    "hat" => 'hat-christmas.png',
    "mouth" => 'mouth-smile.png',
    "pants" => 'pant-female-normalBlack.png'
);

session_start();
$id = $_SESSION["id"];

$SQL_GET_PURCHASED = "select * from Purchase p inner join Inventory i on p.item = i.name where p.student=" . $id;
$SQL_GET_NOT_PURCHASED = "select * from Inventory p where p.name not in
(select item from Purchase p inner join Inventory i on p.item = i.name where student = " . $id . ")";

$serverName = "tcp:karsus.database.windows.net,1433";
$connectionOptions = array(
    "UID" => "karsus", "PWD" => "K@rth0us",
    "Database" => "Karsus", "LoginTimeout" => 30,
    "Encrypt" => 1, "TrustServerCertificate" => 0
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

$query = sqlsrv_query($conn, $SQL_GET_PURCHASED);
while ($row = sqlsrv_fetch_array(
    $query,
    SQLSRV_FETCH_ASSOC
)) {
    $shopItem = new ShopItem;
    $shopItem->purchased = true;
    $shopItem->imgsrc = $row['imgsrc'];
    $shopItem->cost = $row['cost'];
    if ($row['wearing'] == 'Y') {
        $shopItem->amWearing = true;
        $wearing[$row['type']] = $row['imgsrc'];
    }
    array_push($items[$row['type']], $shopItem);
}

$query = sqlsrv_query($conn, $SQL_GET_NOT_PURCHASED);
while ($row = sqlsrv_fetch_array(
    $query,
    SQLSRV_FETCH_ASSOC
)) {
    $shopItem = new ShopItem;
    $shopItem->imgsrc = $row['imgsrc'];
    $shopItem->cost = $row['cost'];
    array_push($items[$row['type']], $shopItem);
}

function getItemPanel($type)
{
    global $items;
    $itemList = $items[$type];
    for ($i = 0; $i < count($itemList); $i++) {
        $currentItem = $itemList[$i];
        echo
            "<div class='shop-item'>" .
                "<img class='shop-item mx-auto' src='../images/" . $type . "/icon-" . $currentItem->imgsrc . "'>
            <div class='text-center'>";
        if ($currentItem->purchased) {
            if ($currentItem->amWearing) {
                echo "<a class='btn btn-primary disabled' href='#' role='button'>Equipped</a>";
            } else {
                echo "<a class='btn btn-success' href='#' role='button'>Equip</a>";
            }
        } else {
            echo "<a class='btn btn-primary' href='#' role='button'>Buy " . $currentItem->cost . "KC</a>";
        }
        echo "</div></div>";
    }
}

?>

<body>

    <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
        <div>
            <a class="navbar-brand" href="home.php">
                <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
            </a>

        </div>

        <div class="col" style="color:white">
            <h2>Customise</h2>
        </div>

        <div class="col text-right">

            <a href="profile.php">
                <img src="../images/profile.png" alt="profile" width=40 height=40 />
            </a>';

        </div>
    </div>

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-md">
                <div class="avatar">
                    <?php
                        echo "<img id='hat' src='../images/hat/600-" . $wearing['hat'] ."'>
                        <img id='hair' src='../images/hair/600-" . $wearing['hair'] ."'>
                        <img id='eyes' src='../images/eyes/600-" . $wearing['eyes'] ."'>
                        <img id='mouth' src='../images/mouth/600-" . $wearing['mouth'] ."'>
                        <img id='body_img' src='../images/body/600-" . $wearing['body'] ."'>
                        <img id='arms' src='../images/arms/600-" . $wearing['arms'] ."'>
                        <img id='pants' src='../images/pants/600-" . $wearing['pants'] ."'>";
                    ?>
                </div>
            </div>
            <div class="col-md">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-arms">Arms</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-body">Outfit</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-eyes">Eyes</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-hair">Hair</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-hat">Hat</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-mouth">Mouth</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-pants">Pants</a></li>
                </ul>

                <div class="tab-content" style="background-color: #dcdcdc; padding:15px; border: 0px; border-radius:0 0 10px 10px;">
                    <div id="tab-arms" class="tab-pane active">
                        <?php
                        getItemPanel("arms")
                        ?>
                    </div>
                    <div id="tab-body" class="tab-pane fade">
                        <?php
                        getItemPanel("body")
                        ?>
                    </div>
                    <div id="tab-eyes" class="tab-pane fade">
                        <?php
                        getItemPanel("eyes")
                        ?>
                    </div>
                    <div id="tab-hair" class="tab-pane fade">
                        <?php
                        getItemPanel("hair")
                        ?>
                    </div>
                    <div id="tab-hat" class="tab-pane fade">
                        <?php
                        getItemPanel("hat")
                        ?>
                    </div>
                    <div id="tab-mouth" class="tab-pane fade">
                        <?php
                        getItemPanel("mouth")
                        ?>
                    </div>
                    <div id="tab-pants" class="tab-pane fade">
                        <?php
                        getItemPanel("pants")
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
