<?php
require("include/CApp.php");
$app->renderHeader("Bokning");

class CBooking
{
    public function __construct(CApp &$app)
    {
        $this->m_app = $app;
    }

    public function __destruct()
    {

    }

	private function renderAvailableTimes()
	{
		$usersTable = $this->m_app->db()->query("SELECT time FROM users");
		$timesTable = $this->m_app->db()->query("SELECT time FROM available_times");
		$usersTimeString;
		while($usersRow = $usersTable->fetch_Assoc())
		{
			$usersTimeString .= $usersRow["time"];
		}
		while($row = $timesTable->fetch_assoc())
		{
			if (strpos($row["time"], $usersTimeString) == false)
				echo('<option value="'. $row["time"] .'" label="'. $row["time"] .'">'. $row["time"] .'</option>');
		}
	}

    public function renderBooking()
    {
        ?>
        
        <div id="formdiv">
            <h2 class="booking-title">Bokning</h2>
            <form id="bookingForm" name="bookingForm" onsubmit="return validateForm(this);" method="post">
            
            <div id="firstnamediv">
            <label for="text">Förnamn:</label><br/>
	    	<input type="text" name="firstname" id="firstname"/><br/>
            </div>

            <div id="lastnamediv">
            <label for="text">Efternamn:</label><br/>
	    	<input type="text" name="lastname" id="lastname"/><br/>
            </div>

            <div id="phonenumberdiv">
	    	<label for="text">Telefonnummer:</label><br/>
	    	<input type="tel" name="phonenumber" id="phonenumber"/><br/>
            </div>

            <div id="amountpeoplediv">
	    	<label for="text">Antal Personer:</label><br/>
		    <input type="number" name="amountpeople" id="amountpeople"/><br/>
            </div>

            <div id="datediv">
    		<label for="text">Datum:</label><br/>
    		<input type="date" name="date" id="date"/><br/>
            </div>

            <div id="timediv">
	    	<label for="text">Tid:</label><br/>
			<select type="time" name="time" id="time">
			<?php
				$this->renderAvailableTimes();
			?>
            </select><br/>
            </div>

            <div id="bokadiv">      
		    <input type="submit" value="Boka" id="boka" ><br>
            </div>
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
        /*
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
        */
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

?>

<?php
$booking->renderBooking();
?>

<?php
$app->renderFooter();
?>