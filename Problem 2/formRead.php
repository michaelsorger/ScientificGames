<?php
/*
echo "hello world 2!";
echo "<br>";
echo "hash " . htmlspecialchars($_POST['hash']);
echo "<br>";
echo "coins_won " . htmlspecialchars($_POST['coins_won']);
echo "<br>";
echo "coins_bet " . htmlspecialchars($_POST['coins_bet']);
echo "<br>";
echo "player_id " . htmlspecialchars($_POST['player_id']);
echo "<br>";

echo "hash " . ($_POST['hash']);
echo "<br>";
echo "coins_won " . ($_POST['coins_won']);
echo "<br>";
echo "coins_bet " . ($_POST['coins_bet']);
echo "<br>";
echo "player_id " . ($_POST['player_id']);
echo "<br>";
echo "JSON = " . json_encode($_POST);
*/

//Grab values set from formView using superGlobal $_POST
$hash = $_POST['hash'];
$coins_won = $_POST['coins_won'];
$coins_bet = $_POST['coins_bet'];
$player_id = $_POST['player_id'];

//PLAYER DB
//index (auto-incremented mysql magic value)
//player_id long
//name string
//credits long
//lifetime spins long
//salt value char[256]
//long won_total
//long bet_total

//load player from db
//convert returned row to local variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "player_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT player_id, name, credits, lifetime_spins, salt_value, won_total, bet_total FROM player_table WHERE player_id = $player_id";
$result = $conn->query($sql);

if($result == NULL){
	$message  = 'Invalid query: ' . mysqli_error($conn) . "\n";
    die($message);
}
else if($result->num_rows == 1) {
    // output data of each row into local variables
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $credits = $row['credits'];
    $lifetime_spins = $row['lifetime_spins'];
    $salt_value = $row['salt_value'];
    $won_total = $row['won_total'];
    $bet_total = $row['bet_total'];

} else {
    echo "should not get here";
}

//validation
define("MAX_WIN_MULTIPLIER", 10000);
define("MAX_BET_SET", 10000);

//validate hash 
if($hash != $salt_value)
{
	//don't update, but still close connection
	echo "<br>";
	echo "hash error 1";
	$conn->close();
}

//validate coins won
if(($coins_won > ($coins_bet * MAX_WIN_MULTIPLIER)) || ($coins_won < 0) || ($coins_won == NULL))
{
	//don't update, and close connection
	echo "<br>";
	echo "coins won error 2";
	$conn->close();
}

//validate coins bet
if(($coins_bet > MAX_BET_SET) || $coins_bet < 0 || $coins_bet == NULL)
{
	//don't update, and close connection
	echo "<br>";
	echo "coins bet error 3";
	$conn->close();
}

//validate player_id
if(($player_id < 0) || ($player_id  == NULL))
{
	//don't update, and close connection
	echo "<br>";
	echo "player_id error 4"; 
	$conn->close();
}

//made it through the gauntlet - update player based on $post vals (coins_bet/won)
$credits += ($coins_won - $coins_bet);
$lifetime_spins++;
$won_total += $coins_won;
$bet_total += $coins_bet;

//store back into db -  UPDATE DB
echo "<br>";
$sql = "UPDATE player_table SET credits='$credits', lifetime_spins='$lifetime_spins',
won_total='$won_total', bet_total='$bet_total' WHERE player_id = $player_id";

echo "update sql = $sql";
echo "<br>";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}


$conn->close();

//build response
$response = array();
$response['player_id'] = $player_id;
$response['name'] = $name;
$response['credits'] = $credits;
$response['lifetime_spins'] = $lifetime_spins;
$response['lifetime_average_return'] = $won_total/$bet_total;
echo "<br>";
echo "response json= " . json_encode($response);
echo "<br>";
?>
