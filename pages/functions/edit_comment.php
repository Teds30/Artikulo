<?php

$id = $_POST['edit-comment__id'];
$new_comment = $_POST['edit-comment__text'];
$article_id = $_POST['edit-comment__articleid'];

include_once('../../connection/connection.php');

$pdo = pdo();
$sql = "UPDATE articles_comments SET `comment` = '$new_comment', `is_edited` = '1' WHERE `id` = :id";
$res = $pdo->prepare($sql);
$res->bindValue(':id', $id);
$res->execute();

header("Location: ../read_article.php?article_id=$article_id");
