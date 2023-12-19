<?php
include_once('config.php');
   

// Function to fetch detailed information about a specific country by name
function getCountryInfo($name) {
    $url = "https://restcountries.com/v3.1/name/$name"."?fullText=true"; 

    // curl to make the API request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (!$response) {
        // Handle error if the REST Countries API request fails
        return ["error" => "Failed to fetch country information"];
    }

    // Parse the response and return JSON
    return json_decode($response, true);
}

// Function to retrieve a list of countries based on filters, sorting, and pagination
function getCountriesList($filter, $sort, $page, $perPage) {
	
	//Apply filtering (name,population/area/language)
    $url = "https://restcountries.com/v3.1/all?fields=".$filter;
	
	
    // Fetch data from REST Countries API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (!$response) {
        // Handle error if the REST Countries API request fails
        return ["error" => "Failed to fetch countries list"];
    }

    // Parse the response and apply filters/sorting
    $countries = json_decode($response, true);
	
	
	//Applying sorting according to json object name section and then country common name. It can be changed //according to any other variable.
	if($sort=='asc'){
		//echo $sort;
		usort($countries, function($a, $b) {
			return strcmp($a['name']['common'], $b['name']['common']);
		});
	}else{
		usort($countries, function($a, $b) {
			return strcmp($b['name']['common'], $a['name']['common']);
		});
	}


    //pagination
    $start = ($page - 1) * $perPage;
    $paginatedCountries = array_slice($countries, $start, $perPage);

    // Return the paginated data
    return $paginatedCountries;
}

// Check if the auth token is present
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if (!isTokenValid($token)) {
        // Authentication error if the token is invalid or missing
        header('Content-Type: application/json');
        echo json_encode(["error" => "Authentication error"]);
        exit;
    }
	//else{
	//	echo "hello world";
	//}
} else {
    // Authentication error if the token is missing
    header('Content-Type: application/json');
    echo json_encode(["error" => "Authentication token is missing"]);
    exit;
}

// Protecting API endpoints by valid tokens 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch detailed information about a specific country by providing its name
    if (isset($_GET['country'])) {
        $countryName = $_GET['country'];
        $countryInfo = getCountryInfo($countryName);
        header('Content-Type: application/json');
        echo json_encode($countryInfo);
        exit;
    }

    // Retrieve a list of countries names based on filters, sorting, and pagination
    if (isset($_GET['filter']) || isset($_GET['sort']) && isset($_GET['page']) && isset($_GET['perPage'])) {
        $filter = $_GET['filter'];
        $sort = $_GET['sort'];
        $page = $_GET['page'];
        $perPage = $_GET['perPage'];
        $countriesList = getCountriesList($filter, $sort, $page, $perPage);
        header('Content-Type: application/json');
        echo json_encode($countriesList);
        exit;
    }
}

// Returning an error for invalid method
header('Content-Type: application/json');
echo json_encode(["error" => "Invalid endpoint or method"]);
?>
