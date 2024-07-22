<?php


function addComment($article_id, $commentor, $user_comment)
{
    $pdo = pdo();

    $sql = "INSERT INTO articles_comments (article_id, commentor_id, comment) VALUES (:article_id,:commentor,:user_comment)";
    $res = $pdo->prepare($sql);
    $res->bindValue(':article_id', $article_id);
    $res->bindValue(':commentor', $commentor);
    $res->bindValue(':user_comment', $user_comment);
    $res->execute();
}
