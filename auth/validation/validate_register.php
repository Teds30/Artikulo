<?php



function validateRegister(
    $firstname,
    $lastname,
    $email,
    $password,
) {
    $has_error = 0;

    if (!isset($firstname) || strlen(trim($firstname)) == 0) {
        $has_error = 1;
    }

    if (!isset($lastname) || strlen(trim($lastname)) == 0) {
        $has_error = 1;
    }

    if (!isset($email) || strlen(trim($email)) == 0) {
        $has_error = 1;
    }

    if (!isset($password) || strlen(trim($password)) == 0) {
        $has_error = 1;
    }

    return $has_error;
}

function validateField($field)
{
    if (!isset($field) || strlen(trim($field)) == 0) {
        return true;
    }
}
