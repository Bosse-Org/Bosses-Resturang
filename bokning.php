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
		//echo("CBooking Destruktor körs!");
	}

	public function renderForm()
	{
		?>
		<div class="form">
            <h2 class="booking-title">Bokning</h2>
            <form name="bookingForm" onsubmit="return validateForm(this);">

            <label for="text">Förnamn:</label><br/>
            <input type="text" name="fName" id="firstname"/><br/>

            <label for="text">Efternamn:</label><br/>
            <input type="text" name="lName" id="lastname"/><br/>

            <label for="text">Telefonnummer:</label><br/>
            <input type="tel" name="pNumber" id="phonenumber"/><br/>

            <label for="text">Antal Personer:</label><br/>
            <input type="number" name="aPeople" id="amountpeople"/><br/>

            <label for="text">Datum:</label><br/>
            <input type="date" name="Date" id="date"/><br/>

            <label for="text">Tid:</label><br/>
            <input type="time" name="Time" id="time"/><br/>

            <input id="Boka" type="submit" value="Boka"><br>
            </form>
        </div>
		<?php
	}

	private function validateForm(array $data)
	{
		$this->m_validationErrors = [];
		if(strlen($data["firstname"]) < 1)
		{
			$this->m_validationErrors[] = "Förnamnet är inte giltigt. Du måste ange mer än 1 tecken i Förnamnet.";
			return false;
		}

        if(strlen($data["lastname"]) < 1)
		{
			$this->m_validationErrors[] = "Efternamnet är inte giltigt. Du måste ange mer än 1 tecken i Efternamnet.";
			return false;
		}

        if(strlen($data["phonenumber"]) < 4 || strlen($data["phonenumber"]) > 15)
		{
			$this->m_validationErrors[] = "Telefonnummeret är inte giltigt. Du måste ange ett Telefonnummer som är större än 4 och mindre än 15.";
			return false;
		}

        if(strlen($data["amountpeople"]) < 1)
		{
			$this->m_validationErrors[] = "Du måste ange hur många som det ska bokas för.";
			return false;
		}

        if(strlen($data["date"]) < 1)
		{
			$this->m_validationErrors[] = "Du måste ange ett datum att boka.";
			return false;
		}

		if(strlen($data["time"]) < 1)
		{
			$this->m_validationErrors[] = "Du måste ange en tid att boka.";
			return false;
		}
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
		}
		else
		{
			echo("Det finns fel i inmatningen:");
			print_r($this->m_validationErrors);
		}
	}

	public function renderNewsItem(array $newsItem)
	{
		?>
		<div class="newsItem">
			<h2><?php echo($newsItem["id"]);?></h2>
			<div class="text"><?php echo($newsItem["firstname"]);?></div>
            <div class="text"><?php echo($newsItem["lastname"]);?></div>
            <div class="text"><?php echo($newsItem["phonenumber"]);?></div>
            <div class="text"><?php echo($newsItem["amountpeople"]);?></div>
            <div class="text"><?php echo($newsItem["date"]);?></div>
            <div class="text"><?php echo($newsItem["time"]);?></div><br/>
		</div>
		<?php
	}

	public function selectAndRenderAllNewsItems()
	{
		/*
		x Måste komma åt app
		x Måste komma åt db
		(Ansluta om inte det redan är gjort)
		*/


		//$query = "SELECT * FROM news";
		//$result = $this->m_app->db()->query($query);

		$result = $this->m_app->db()->selectAll("users");

		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				//var_dump($row);
				//echo("<pre>");
				//print_r($row);
				//echo("</pre>");
				$this->renderNewsItem($row);
			}
		}
		else
		{
			echo("Det finns inga nyheter");
		}

		//$this->renderNewsItem($this->getRandomizedNewsItem());
		//$this->renderNewsItem($this->getRandomizedNewsItem());
		//$this->renderNewsItem($this->getRandomizedNewsItem());
	}

	//--->Member Variables<---//
	private $m_validationErrors = []; 
	private $m_app = null;
};

$booking = new CBooking($app);
$booking->validateAndInsertForm();
$booking->selectAndRenderAllNewsItems();

print_r($_POST);
?>
    <div id="main">
        <?php
        $booking->renderForm();
        ?>
    </div>
<?php
$app->renderFooter();
?>