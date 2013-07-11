<?php 

require_once("../libs/common.php");

$mysqli = getDB();

if (!($res = $mysqli -> query("SELECT email FROM mailinglist")))
 {
	echo " CALL failed: (" . $mysqli ->errno . ") " . $mysqli ->error;
 }
else
{
	$sSubject =$mysqli->real_escape_string($_POST["subject"]);
	$sBody = $mysqli ->real_escape_string($_POST["body"]);
	$sSuccess ="";
	$sFailure = "";
	while($row = $res ->fetch_assoc())
	{
		$sEmail = $row["email"];
		// actually mailing to the current email here
		if(mail($sEmail,$sSubject,$sBody))
		{
			//mail accepted for delivery
			if($sSuccess != "") $sSuccess .= ",";
			$sSuccess .= $sEmail;
		}
		else
		{
			// mail rejected for delivery
			if($sFailure != "") $sFailure .= ",";
		     $sFailure .= $sEmail;
		}
	
	}
}

?>
<p>email successfully sent to  <?php echo $sSuccess?> </p>
<p>email not sent to <?php  echo $sFailure ?></p>
