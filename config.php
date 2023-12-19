<?php
//Hardcoded username and password
$validUsername = "deepak";
$validPassword = "deepak@123";

// Function to check if the provided auth token is valid
function isTokenValid($token) {
	global $validUsername,$validPassword;       

	$valid_token = hash('sha256', $validUsername.$validPassword);
	//echo $valid_token;
    return $valid_token==$token;
}
?>
