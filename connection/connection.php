<?php

function connection(){
    $host = "localhost";
    $username = "root";
    $password = "12345";
    $database = "article_app";

    $con = new mysqli($host, $username, $password, $database);
    
    if($con ->connect_error){
        echo $con->connect_error;
    }else{
        return $con;
    }
}

function pdo() {
    
    $host = "localhost";
    $username = "root";
    $password = "12345";
    $port = "3306";
    $database = "article_app";

    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

}
