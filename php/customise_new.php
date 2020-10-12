<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Customise</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/style1.css"/>
        <link rel="stylesheet" href="../css/style3.css"/>
        <link rel="stylesheet" href="../css/style4.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
        <script src="../js/jquery-3.5.1.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
    </head>

    <?php
        class ShopItem {
            public string $imgsrc = "Default";
            public string $itemName = "Default";
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
            "pants" => array(),
            "legs" => array(),
            "background" => array()
        );

        // Default avatar look, replaced with items the user is wearing
        $wearing = array(
            "arms" => 'arms-female-normal-pale.png',
            "body" => 'body-female-normalBlack.png',
            "eyes" => 'eyes-normal.png',
            "hair" => 'hair-female-normalBrown-pale.png',
            "hat" => 'hat-christmas.png',
            "mouth" => 'mouth-smile.png',
            "pants" => 'pant-female-normalBlack.png',
            "legs" => 'legs-chicken.png',
            "background" => 'background-stage1.png'
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
            $shopItem->itemName = $row['name'];
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
            $shopItem->itemName = $row['name'];
            array_push($items[$row['type']], $shopItem);
        }

        $goldSql = "select  SUM(score)/COUNT(*) - SUM(cost)
                        as [Balance]
                        from Users
                        inner join Purchase on Users.id = Purchase.student
                        inner join Inventory on Purchase.item = Inventory.name
                        where Users.id = " . $id;
        $getResults = sqlsrv_query($conn, $goldSql);
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $gold = $row["Balance"];

        function getItemPanel($type) {
            global $items;
            $itemList = $items[$type];
            for ($i = 0; $i < count($itemList); $i++) {
                $currentItem = $itemList[$i];
                $item_id = $type . '_' . $i;
                $js_img_src = "../images/" . $type . "/600-" . $currentItem->imgsrc;
                $change_outfit_function = 'change_outfit("' . $type . '", "' . $item_id . '", "' . $js_img_src . '")';
                $purchase_outfit_function = 'purchase_outfit("' . $currentItem->itemName . '", "' . $item_id . '", "' . $type . '", "' . $js_img_src . '")';
                echo
                    "<div class='shop-item'>" .
                    "<img alt='icon' class='shop-item mx-auto' src='../images/" . $type . "/icon-" . $currentItem->imgsrc . "'>
                    <div class='text-center'>";
                if ($currentItem->purchased) {
                    if ($currentItem->amWearing) {
                        echo "<a class='btn btn-primary disabled " . $type . "' 
                        id='" . $item_id . "' href='#' role='button' 
                        onclick='" . $change_outfit_function . "' 
                        data-outfit-name='" . $currentItem->itemName . "'>Equipped</a>";
                    } else {
                        echo "<a class='btn btn-success " . $type . "' 
                        id='" . $item_id . "' href='#' role='button' 
                        onclick='" . $change_outfit_function . "' 
                        data-outfit-name='" . $currentItem->itemName . "'>Equip</a>";
                    }
                } else {
                    echo "<a class='btn btn-primary " . $type . "' 
                    id='" . $item_id . "' href='#' role='button' 
                    onclick='" . $purchase_outfit_function . "' 
                    data-outfit-name='" . $currentItem->itemName . "'>Buy " . $currentItem->cost . "KC</a>";
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
                <?php
                echo '<span style="color:gold; font-size:25px">' .
                    '<span id="gold_counter">' .
                    $gold . '</span> <img
                                    src="../images/Karsus_coin.png"
                                    alt="profile" width=40 height=40
                                />' .

                    '<a href="profile.php">
                                <img
                                    src="../images/profile.png"
                                    alt="profile" width=40 height=40
                                />
                                </a></span>';
                ?>

            </div>
        </div>

        <div class="container" style="margin-top: 50px;">
            <div class="customise">
                <div class="card-deck">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Your Avatar</div>
                            <div class="avatar">
                                <?php
                                echo "<img alt='background' id='background' src='../images/background/600-" . $wearing['background'] . "' style = 'padding-left:15px'>
                                                <img alt='hat' id='hat' src='../images/hat/600-" . $wearing['hat'] . "'>
                                                <img alt='hair' id='hair' src='../images/hair/600-" . $wearing['hair'] . "'>
                                                <img alt='eyes' id='eyes' src='../images/eyes/600-" . $wearing['eyes'] . "'>
                                                <img alt='mouth' id='mouth' src='../images/mouth/600-" . $wearing['mouth'] . "'>
                                                <img alt='body' id='body' src='../images/body/600-" . $wearing['body'] . "'>
                                                <img alt='arms' id='arms' src='../images/arms/600-" . $wearing['arms'] . "'>
                                                <img alt='pants' id='pants' src='../images/pants/600-" . $wearing['pants'] . "'>
                                                <img alt='legs' id='legs' src='../images/legs/600-" . $wearing['legs'] . "'>";
                                ?>
                            </div>
                            <div id= "save">
                                <a class="btn btn-primary" href='#' onclick='save_outfit()'>Save Outfit</a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Shop</div>
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-arms">Arms</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-body">Outfit</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-eyes">Eyes</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-hair">Hair</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-hat">Hat</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-mouth">Mouth</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-pants">Pants</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-legs">Legs</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-bg">Background</a></li>
                            </ul>

                            <div class="tab-content">
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
                                <div id="tab-legs" class="tab-pane fade">
                                    <?php
                                    getItemPanel("legs")
                                    ?>
                                </div>
                                <div id="tab-bg" class="tab-pane fade">
                                    <?php
                                    getItemPanel("background")
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
        function change_outfit(type, id, img) {
            let items = document.getElementsByClassName(type);
            for (let i = 0; i < items.length; i++) {
                if (items[i].innerHTML === "Equipped") {
                    items[i].innerHTML = "Equip";
                    items[i].classList.remove("disabled");
                    items[i].classList.remove("btn-primary");
                    items[i].classList.add("btn-success");
                }
            }
            const itemToEquip = document.getElementById(id);
            itemToEquip.innerHTML = "Equipped";
            itemToEquip.classList.add("disabled")
            itemToEquip.classList.remove("btn-success");
            itemToEquip.classList.add("btn-primary");
            const avatar = document.getElementById(type);
            avatar.src = img;
        }

        function subtract_coins(n) {
            let element = document.getElementById('gold_counter');
            let goldStr = element.innerHTML;
            let gold = parseInt(goldStr);
            gold -= n;
            element.innerHTML = gold.toString();
        }

        function show_equip_button(id, type, img, name) {
            let element = document.getElementById(id);
            element.innerHTML = "Equip";
            element.classList.remove("btn-primary");
            element.classList.add("btn-success");
            element.onclick = function() {
                change_outfit(type, id, img);
            }
        }

        function purchase_outfit(itemName, id, type, img) {
            let xhttp;

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    let response = this.responseText;
                    if (response === "-2") {
                        console.log("Purchase failed: not enough coins");
                    } else if (response === "-1") {
                        console.log("Purchase failed: unknown reason");
                    } else {
                        console.log("Purchase succeeded");
                        show_equip_button(id, type, img, itemName);
                        subtract_coins(parseInt(response));
                    }
                }
            };
            xhttp.open("GET", "purchase.php?item=" + itemName, true);
            xhttp.send();
        }

        function save_outfit() {
            let types = [
                "arms",
                "body",
                "eyes",
                "hair",
                "hat",
                "mouth",
                "pants",
                "legs",
                "background"
            ]

            let equipped = [];

            for (let i = 0; i < types.length; i++) {
                let type = types[i];
                let items = document.getElementsByClassName(type);
                let equippedItem = "";
                for (let j = 0; j < items.length; j++) {
                    if (items[j].innerHTML === "Equipped") {
                        equippedItem = items[j].getAttribute("data-outfit-name");
                    }
                }
                if (equippedItem !== '') {
                    equipped.push(equippedItem);
                }
            }

            let equipped_str = equipped.join(",");

            let xhttp;

            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    let response = this.responseText;
                    if (response === "1") { // Success
                        console.log("Equipping succeeded");
                    } else {
                        console.log("Equipping failed");
                    }
                }
            };
            if (equipped.length > 0) {
                xhttp.open("GET", "save_customisation.php?equipped=" + equipped_str, true);
                xhttp.send();
            }
        }
    </script>
</html>
