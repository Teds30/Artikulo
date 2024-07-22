<?php

function createAccount($fname, $lname, $email, $password, $bday, $gender, $street, $city, $state, $zip, $pic)
{

    include_once('../connection/connection.php');
    $pdo = pdo();

    $sql = "INSERT INTO accounts (
        `first_name`,
        `last_name`, 
        `email_address`, 
        `password`,
        `bday`,
        `gender`,
        `street`,
        `city`,
        `state`,
        `zip_code`,
        `profile_pic`
        ) VALUES (
            :fname,
            :lname,
            :email,
            :password,
            :bday,
            :gender,
            :street,
            :city,
            :state,
            :zip,
            :pic)";


    $res = $pdo->prepare($sql);

    $res->bindValue(':fname', $fname);
    $res->bindValue(':lname', $lname);
    $res->bindValue(':email', $email);
    $res->bindValue(':password', md5($password));
    $res->bindValue(':bday', $bday);
    $res->bindValue(':gender', $gender);
    $res->bindValue(':street', $street);
    $res->bindValue(':city', $city);
    $res->bindValue(':state', $state);
    $res->bindValue(':zip', $zip);
    $res->bindValue(':pic', $pic);

    $res->execute();
}
