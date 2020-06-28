<?php
#PHP Info:
#phpinfo();

/**
 *
 * LOGIN SYSTEM
 *
 * Parameters: 'user', 'password'
 *
**/

# Database connection
$host = 'db';
$port = '5432';
$dbname = 'login';
$dbuser = 'postgres';
$dbpassword = 'postgres-admin';

# PDO
$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $dbuser, $dbpassword);

$invalidParametersMessage = "Parameters not valid.";
$userNotFoundMessage = "User not found.";
$invalidPasswordMessage = "Invalid password.";

# Parameters validation. Expecting 'user' and 'password'
if (empty($_POST['user']) || empty($_POST['password'])) {
	throw new \Exception($invalidParametersMessage);
}

$user = $_POST['user'];
$password = $_POST['password'];

# Define queries
$getUser = "SELECT * FROM USERS WHERE USERNAME = '$user'";

# Find user
$rs = $pdo->query($getUser);
$searchedUser = $rs->fetchAll(PDO::FETCH_ASSOC);
$searchedUser = empty($searchedUser) ? null : $searchedUser[0];

if (empty($searchedUser)) {
	throw new \Exception($userNotFoundMessage);
}

# Verify password. Add hash methods later
if ($password != $searchedUser['password']) {
	throw new \Exception($invalidPasswordMessage);
}

return true;
