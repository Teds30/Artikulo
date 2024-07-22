<?php


function getAccountName($uid)
{
    $pdo = pdo();
    $sql = "SELECT * FROM accounts WHERE `uid` = :uid";
    $res = $pdo->prepare($sql);
    $res->bindValue(':uid', $uid);
    $res->execute();

    $row = $res->fetch(PDO::FETCH_ASSOC);

    if ($row > 0) {
        $author = $row['first_name'] . ' ' . $row['last_name'];

        return $author;
    }
}

function getAccountPhoto($uid)
{
    $pdo = pdo();
    $sql = "SELECT * FROM accounts WHERE `uid` = :uid";
    $res = $pdo->prepare($sql);
    $res->bindValue(':uid', $uid);
    $res->execute();

    $row = $res->fetch(PDO::FETCH_ASSOC);

    if ($row > 0) {

        return $row['profile_pic'];
    }
}

function getCategoryName($id)
{
    $pdo = pdo();
    $sql = "SELECT * FROM articles_category WHERE `id` = :id";
    $res = $pdo->prepare($sql);
    $res->bindValue(':id', $id);
    $res->execute();

    $row = $res->fetch(PDO::FETCH_ASSOC);
    if ($row > 0) {

        return $row['category'];
    }
}

