<?php

$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'signupform';

$con= mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE , 3307);

if(!$con){
    die(mysqli_error($con));
}

?>