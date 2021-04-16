<?php

session_start();
require_once("CDatabase.php");
require_once("CUser.php");

function print_r_pre($data)
{
    echo('<pre>');print_r($data);echo('</pre>');
}

function dd($data)
{
    print_r_pre($data);
    die();
}

function redirect(string $url)
{
    header("location: $url");
    die();
}

class CApp
{
    public function __construct()
    {
        $this->m_db = new CDatabase();
        $this->m_user = new CUser($this);
    }
    public function renderHeader(string $title)
    {
        ?>
        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo($title)?></title>
            <link href="https://fonts.googleapis.com/css2?family=Antonio" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
            <link rel="stylesheet" href="styles/general.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous"/>
        </head>
        <body>
        <div id="menu">
                <a href="index.php">Hem</a> 
                <a href="bokning.php">Bokning</a>
                <a>Om Oss</a>
                <a>pog</a>
                <a href="text.php">InfoBattles.org (Join us)</a>
            </div>
            <div id="header">
                <h1 class="title"><?php echo($title)?></h1>
            </div>
            <div id="main">
    <?php
    }
    public function renderFooter()
    {
        ?>
            </div>
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

    //--->Get Member Variables<---//
    public function &db()   { return $this->m_db; }
    public function &user() { return $this->m_user; }

    //--->Member Variables<---//
    private $m_db = null;
    private $m_user = null;
};

$app = new CApp();
?>