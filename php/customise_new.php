<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customise</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../js/jquery-3.5.1.min.js"></script>
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
            min-height: 300px;
        }

        .shop-item {
            width: 150px;
            height: 150px;
            padding: 5px;
            display: inline-block;
            border: 3px solid white;
            border-radius: 5px;
            margin-bottom: 5px;
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

<body>
    <h1>
        Customise
    </h1>

    <div class="container">
        <div class="row">
            <div class="col-md">
                <div class="avatar">
                    <img id='hat' src='../images/hat/hat-christmas.png'>
                    <img id='hair' src='../images/hair/hair-female-normal-pale.png'>
                    <img id='eyes' src='../images/eyes/eyes-normal.png'>
                    <img id='mouth' src='../images/mouth/mouth-smile.png'>
                    <img id='body_img' src='../images/body/body-female-grey.png'>
                    <img id='arms' src='../images/arms/arms-female-grey-pale.png'>
                    <img id='pants' src='../images/pants/pant-female-black.png'>
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

                <div class="tab-content" style="background-color: #dcdcdc; padding:15px; border: 0px; border-radius:10px;">
                    <div id="tab-arms" class="tab-pane active">
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/arms/arms-female-grey-pale.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-body" class="tab-pane fade">
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/body/body-female-black.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/body/body-female-grey.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/body/body-female-white.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/body/body-male-black.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/body/body-male-grey.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/body/body-male-white.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-eyes" class="tab-pane fade">
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/eyes/eyes-confuse.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/eyes/eyes-normal.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/eyes/eyes-smile.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-hair" class="tab-pane fade">
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hair/hair-female-blue-pale.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hair/hair-female-brown-pale.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hair/hair-female-normal-pale.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hair/hair-male-normal-pale.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hair/hair-male-wave-pale.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hair/hair-male-waveBrown-pale.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-hat" class="tab-pane fade">
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hat/hat-christmas.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/hat/hat-graduate.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-mouth" class="tab-pane fade">
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/mouth/mouth-normal.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/mouth/mouth-serious.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/mouth/mouth-smile.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/mouth/mouth-surprise.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-pants" class="tab-pane fade">
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/pants/pant-female-black.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/pants/pant-female-grey.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/pants/pant-female-white.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/pants/pant-male-black.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/pants/pant-male-grey.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                        <div class='shop-item'>
                            <img class='shop-item mx-auto' src='../images/pants/pant-male-white.png'>
                            <div class="text-center">
                                <a class="btn btn-primary" href="#" role="button">Buy 100KC</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>