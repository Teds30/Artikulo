<?php

$article_id = $_POST['delete-comment__articleid'];
$id = $_POST['delete-comment__id'];

echo $id;
include_once('../../connection/connection.php');

$pdo = pdo();
$sql = "DELETE FROM articles_comments WHERE `id` = :id";
$res = $pdo->prepare($sql);
$res->bindValue(':id', $id);
$res->execute();

header("Location: ../read_article.php?article_id=$article_id");
