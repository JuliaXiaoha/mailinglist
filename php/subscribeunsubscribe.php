<?php 

require_once("../libs/common.php");

$mysqli = getDB();

$sEmail = $mysqli->real_escape_string($_POST["email"]);

if($_POST["action"] == "subscribe")
{
	$stmt = $mysqli->prepare("INSERT INTO mailinglist(email) VALUES(?)");
	
	$stmt->bind_param("s", $sEmail);
	
	$stmt->execute();
	
	$sResult = "thank-you for subscribing";
	if($stmt->affected_rows != 1)
	{
		if($mysqli->errno == 1062)
		{
			$sResult = "you already have a subscription with this email address";
		}
		else
		{
			$sResult =  "Error: " . $mysqli->errno . " " . $mysqli->error;
		}
	}
}
else 
{
	$stmt = $mysqli->prepare("DELETE FROM mailinglist WHERE email = ?");
	
	$stmt->bind_param("s", $sEmail);
	
	$stmt->execute();
	
	$sResult = "thank-you for subscribing ... sorry to see you go";
	if($stmt->affected_rows != 1)
	{
		if($mysqli->errno)
		{
			$sResult =  "Error: " . $mysqli->errno . " " . $mysqli->error;
		}
		else
		{
			$sResult = "no subscription found with this email address";
		}
	}
}
?>

<?php echo $sResult ?>