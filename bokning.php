<?php
require("include/CApp.php");
require("include/CForm.php");
$app->renderHeader("Booking");
?>
    <div id="main">
        <?php
        $form->renderBooking();
        ?>
    </div>
<?php
$app->renderFooter();
?>