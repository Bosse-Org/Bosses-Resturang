<?php
require("include/CApp.php");

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
		$userTimeTable;
		while($usersRow = $usersTable->fetch_Assoc())
		{
			$userTimeTable .= $usersRow["time"];
		}
		while($row = $timesTable->fetch_assoc())
		{
			if (strpos($userTimeTable, $row["time"]) == false)
			{
				echo('<option value="'. $row["time"] .'" label="'. $row["time"] .'">'. $row["time"] .'</option>');
			}
		}
	}

    public function renderBooking()
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
                <a>pog</a>
            </div>
            
            <div id="main">
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
		    <input type="number" name="amountpeople" id="amountpeople" min="1" max="8"/><br/>
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