<?php

/**
  * Configuration for database connection
  *
  */

$host       = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "test"; // will use later
$dsn        = "mysql:host=$host;dbname=$dbname"; // will use later


$connection = mysqli_connect($host,$username,$password,$dbname);
$db=$connection;
