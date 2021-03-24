<?php
require("header.php");
renderHeader("Booking");
?>
    <div id="main">
        <div class="form">
            <h2 class="booking-title">Bokning</h2>
            <form name="bookingForm" onsubmit="return validateForm(this);">
                Förnamn:<br><input type="text" name="fName"><br>
                Efternamn:<br><input type="text" name="lName"><br>
                Telefonnummer:<br><input type="tel" name="pNumber"><br>
                Antal personer:<br><input type="text" name="aPeople"><br>
                <input type="submit" value="Submit"><br>
            </form>
        </div>
    </div>
    <div id="footer">
        <div id="leftFooter">
            
        </div>
        <div id="rightFooter">
            
        </div>
    </div>
    <script src="scripts/main.js"></script>
</body>
</html>