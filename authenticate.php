<?php
//This file is for the authentication of the user and get api's 
include_once('config.php');

// Retrieve username and password from the login form
$inputUsername = $_POST['username'];
$inputPassword = $_POST['password'];

// Function to generate an auth token based on credentials
function generateAuthToken($username, $password) {
    global $validUsername, $validPassword;

    if ($username === $validUsername && $password === $validPassword) {
        
        $token = hash('sha256', $username . $password);
		//echo $token;
        return $token;
    } else {
        return null;
    }
}

// Getting auth token
$authToken = generateAuthToken($inputUsername, $inputPassword);

if ($authToken) {
	
	//set this variable to fetch detailed information about a specific country by country common name, the 
	//default value is India.
	
	$country="India";
	/////////////////////////////
	
	//set these variable to retrieve a list of all countries based on filters, sorting, and pagination
	$filter="name,population,area,languages";
	$sort = "desc";
	$page="3";
	$perPage = "10";
	////////////////////////////
	
	
	$url1 = "country.php?country=" .$country. "&token=" .$authToken;
	$url2= "country.php?filter=" .$filter."&sort=".$sort."&page=".$page."&perPage=".$perPage. "&token=".$authToken;
	
	header('Content-Type: application/json');
     echo json_encode(["URL1" => $url1,"URL2" => $url2]);
     //echo json_encode(["URL2" => $url2]);
	
    // Redirect to a page with the auth token in the URL query parameter
    //header("Location: $url2");
} else {
    // Redirect back to the login page with an error message
    header("Location: login.html?error=invalid_credentials");
}
?>
