<?php
class CApp
{
    public function __construct()
    {

    }
    public function renderHeader(string $title)
    {
        ?>
        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo($title)?></title>
            <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
            <link rel="stylesheet" href="styles/general.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous"/>
        </head>
        <body>
            <div id="header">
                <h1 class="title"><?php echo($title)?></h1>
            </div>
            <div id="menu">
                <a href="index.php">Hem</a> 
                <a href="bokning.php">Bokning</a>
                <a>Om Oss</a>
                <a>pog</a>
                <a>pog</a>
            </div>
    <?php
    }
    public function renderFooter()
    {
        ?>
            <div id="footer">
                <div id="leftFooter">
                </div>
                <div id="rightFooter">
                </div>
            </div>
            <script src="main.js"></script>
        </body>
    </html>
    <?php
    }
};

$app = new CApp();
?>