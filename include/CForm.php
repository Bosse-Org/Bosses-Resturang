<?php
class CForm
{
    public function __construct()
    {

    }
    public function renderBooking()
    {
        ?>
        <div class="form">
            <h2 class="booking-title">Bokning</h2>
            <form name="bookingForm" onsubmit="return validateForm(this);">
                Förnamn:<br><input type="text" name="fName"><br>
                Efternamn:<br><input type="text" name="lName"><br>
                Telefonnummer:<br><input type="tel" name="pNumber"><br>
                Datum:<br><input id="Date" type="date" name="Date"><br>
                Tid:<br><select id="Time" type="time" name="Time" step="1800" min="16:00" max="20:00">
                    <option value="16:00" label="16:00">16:00</option>
                    <option value="16:30" label="16:30">16:30</option>
                    <option value="17:00" label="17:00">17:00</option>
                    <option value="17:30" label="17:30">17:30</option>
                    <option value="18:00" label="18:00">18:00</option>
                    <option value="18:30" label="18:30">18:30</option>
                    <option value="19:00" label="19:00">19:00</option>
                    <option value="19:30" label="19:30">19:30</option>
                    <option value="20:00" label="20:00">20:00</option>
                    <option value="20:30" label="20:30">20:30</option>
                    <option value="21:00" label="21:00">21:00</option>
                    </select><br>
                Antal personer:<br><input id="aPeople" type="text" name="aPeople"><br>
                <input id="Boka" type="submit" value="Boka"><br>
            </form>
        </div>
        <?php
    }
}

$form = new CForm();
?>