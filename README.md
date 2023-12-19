# Country Data Backend API Service (PHP)
This project is a backend API service developed in PHP that provides useful information about countries using the REST Countries API.

## Getting Started

### Prerequisites

- XAMPP installed or PHP installed on the server

### Installation

1. Clone the repository:
  
git clone https://github.com/yourusername/countryApi.git

if XAMPP is installed, place this folder in htdocs and start the XAMPP.
  
if php and apache2 is installed on the server, place this folder inside /var/html/ and restart apache2


2. Using cURL 
   
 curl --location 'http://localhost/countryApi/authenticate.php' --form 'username="deepak"' --form 'password="deepak@123"' 

 After getting links:
 1. curl --location 'http://localhost/{link1}'
 2. curl --location 'http://localhost/{link2}' 

 Using Browser
 Open the login page and fill the details.
 username - deepak
 Password - deepak@123

 username and password can be changed in config.php file.
 After submitting the form, You will get two api links
 
3.Configure the php file(country.php) to change the default values.

