<?php
require("include/CApp.php");
$app->renderHeader("Booking");

class CBooking
{
    public function __construct(CApp &$app)
    {
        $this->m_app = $app;
    }

    public function __destruct()
    {

    }

    public function renderBooking()
    {
        ?>
        <div class="form">
            <h2 class="booking-title">Bokning</h2>
            <form name="bookingForm" onsubmit="return validateForm(this);" method="post">

            <label for="text">Förnamn:</label><br/>
	    	<input type="text" name="firstname" id="firstname"/><br/>
	
	    	<label for="text">Efternamn:</label><br/>
	    	<input type="text" name="lastname" id="lastname"/><br/>
	
	    	<label for="text">Telefonnummer:</label><br/>
	    	<input type="tel" name="phonenumber" id="phonenumber"/><br/>
	
	    	<label for="text">Antal Personer:</label><br/>
		    <input type="number" name="amountpeople" id="amountpeople"/><br/>
	
    		<label for="text">Datum:</label><br/>
    		<input type="date" name="date" id="date"/><br/>
	
	    	<label for="text">Tid:</label><br/>
    		<select type="time" name="time" id="time">
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
                    <option value="21:00" label="21:00">21:00</option>§
            </select><br/>
	
		    <input type="submit" value="Boka" id="Boka" ><br>
            </form>
        </div>
        <?php
    }

    private function validateForm(array $data)
	{
        if(strlen($data["firstname"]) < 1)
		{
			$this->m_validationErrors[] = "Förnamnet är inte ifyllt.";
			return false;
		}
        if(strlen($data["lastname"]) < 1)
		{
			$this->m_validationErrors[] = "Efternamnet är inte ifyllt.";
			return false;
		}
        if(strlen($data["phonenumber"]) < 5 || strlen($data["phonenumber"]) > 15)
		{
			$this->m_validationErrors[] = "Telefonnummret är för kort eller långt. Det måste vara minst 5 siffror och störst 15 siffror.";
			return false;
		}
        if(strlen($data["amountpeople"]) < 1)
		{
			$this->m_validationErrors[] = "Antal personer är inte ifyllt.";
			return false;
		}
        if(strlen($data["date"]) < 1)
		{
			$this->m_validationErrors[] = "Datumet är inte ifyllt.";
			return false;
		}
        if(strlen($data["time"]) < 1)
		{
			$this->m_validationErrors[] = "Tiden är inte ifyllt.";
			return false;
		}
		$this->m_validationErrors = [];
		return true;
	}

    private function insert(array $data)
	{	
		$this->m_app->db()->insert("users", $data);
	}

	public function validateAndInsertForm()
	{
		if(empty($_POST))
			return;
		
		if($this->validateForm($_POST))
		{
			$this->insert($_POST);
            Header('Location: '.$_SERVER['PHP_SELF']);
		}
		else
		{
			echo("Det finns fel i inmatningen:");
			print_r($this->m_validationErrors);
		}
	}

    public function renderUserItem(array $bookingTime)
	{
		?>
		<div class="bookingTime">
			<h2><?php echo($bookingTime["id"]); ?></h2>
			<div><?php echo($bookingTime["firstname"]); ?></div>
            <div><?php echo($bookingTime["lastname"]); ?></div>
            <div><?php echo($bookingTime["phonenumber"]); ?></div>
            <div><?php echo($bookingTime["amountpeople"]); ?></div>
            <div><?php echo($bookingTime["date"]); ?></div>
            <div><?php echo($bookingTime["time"]); ?></div>
		</div>
		<?php
	}

    public function selectAndRenderAllUserItems()
	{
		$result = $this->m_app->db()->selectAll("users");

		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				$this->renderUserItem($row);
			}
		}
		else
		{
			echo("Det finns inga användare");
		}
	}
    //--->Member Variables<---//
    private $m_validationErrors = []; 
	private $m_app = null;
};

$booking = new CBooking($app);
$booking->validateAndInsertForm();
$booking->selectAndRenderAllUserItems();

print_r($_POST);
?>

<?php
$booking->renderBooking();
?>

<?php
$app->renderFooter();
?>