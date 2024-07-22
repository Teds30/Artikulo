<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['uid'])) {

    header('Location: ../auth/login.php');
}

$uid = $_SESSION['uid'];

include_once("../connection/connection.php");
include_once('./functions/add_comment.php');
include_once('./functions/fetch_data.php');

$pdo = pdo();

$article_id = $_GET['article_id'];
$urlValid = false;

$sql = "SELECT * FROM articles WHERE id = :article_id";
$res = $pdo->prepare($sql);
$res->bindValue(':article_id', $article_id);
$res->execute();
$row = $res->fetch(PDO::FETCH_ASSOC);


$sql_comments = "SELECT * FROM articles_comments WHERE article_id = '$article_id' ORDER BY id DESC";
$res_comments = $pdo->prepare($sql_comments);
$res_comments->execute();

$comments = null;

while ($row_comments = $res_comments->fetch(PDO::FETCH_ASSOC)) {
    $comments[] = $row_comments;
}


function formatDate($date)
{
    date_default_timezone_set('Asia/Manila');
    $datetime = strtotime($date);
    $date = date("F j \, Y", $datetime);
    $time = date('h:i A e', $datetime);
    $myFormatForView = $date . ' at ' . $time;
    return $myFormatForView;
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $commentor = $uid;
    $user_comment = $_POST['addcomment'];
    addComment($article_id, $commentor, $user_comment);

    echo "<meta http-equiv='refresh' content='0'>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/read_article.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="../js/editComment.js"></script>
    <script src="../js/deleteComment.js"></script>

    <title>Articles</title>
</head>

<body>
    <?php
    include '../layout/header.php';
    echo header_component('article');
    ?>
    <?php
    if ($row == 0) : ?>
        <div class="pagenotfound">
            <h2 class="text-center">Page not found!</h1>
                <a href="./articles.php">Go Back </a>
        </div>
    <?php endif; ?>

    <?php if ($row > 0) : ?>
        <div class="container-fluid ">
            <div class="row">
                <div class="col-3 p-5" id="leftDiv">
                    <a href="./articles.php"> <span><i class="bi bi-arrow-left"></i></span> Go Back</a>
                </div>
                <div class="col-6 pt-5" id="midDiv">
                    <div>
                        <!-- <h2>Articles</h2> -->
                    </div>

                    <div class="w-100">

                        <div>
                            <div class="author">

                                <img src="../assets/uploads/<?php echo getAccountPhoto($row['author_uid']) ?>">
                                <div class="author-details">
                                    <p class="author"> <?php echo getAccountName($row['author_uid']) ?></p>
                                    <p class="date"><?php echo formatDate($row['date_created']) ?></p>
                                </div>
                            </div>
                            <div class="category mt-4"><?php echo getCategoryName($row['category_id']) ?></div>
                            <h1 class="mt-3"><?php echo $row['title'] ?></h1>
                            <div class="mt-4">
                                <img src="../assets/articles/<?php echo $row['photo_headline'] ?>" alt="">
                            </div>

                            <div class="mt-5">
                                <p><?php echo nl2br($row['contents']) ?></p>
                            </div>
                        </div>

                    </div>



                    <hr>
                    <div class="comments-col">
                        <h5>Add Comment</h5>

                        <div class="addcomment">
                            <div class="user-container">
                                <div class="user-pic me-1">
                                    <img src="../assets/uploads/<?php echo getAccountPhoto($uid) ?>" alt="img">
                                </div>
                                <p><?php echo getAccountName($uid) ?></p>
                            </div>

                            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">

                                <div class="mb-3">
                                    <textarea class="form-control" name="addcomment" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <div class="button-container">
                                    <button class="btn" type="submit">Add Comment</button>
                                </div>
                            </form>
                        </div>

                        <hr>
                        <div class="comments mt-4">
                            <h5>Comments</h5>
                            <?php if (!$comments) : ?>
                                <p class="text-center">No Comments yet!</p>
                            <?php endif; ?>
                            <?php if ($comments) : ?>
                                <?php foreach ($comments as $com) : ?>
                                    <div class="comment">
                                        <div class="comment-block">
                                            <div class="comment-author">

                                                <div class="comment-author-pic">
                                                    <img src="../assets/uploads/<?php echo getAccountPhoto($com['commentor_id']) ?>" alt="img">
                                                </div>
                                                <div>
                                                    <p><?php echo getAccountName($com['commentor_id']) ?></p>
                                                    <p class="time-ago"><?php echo time_elapsed_string($com['date_created']) ?></p>
                                                </div>
                                            </div>
                                            <div class="comment-action">
                                                <?php if ($com['commentor_id'] == $uid) : ?>
                                                    <div class="dropdown">
                                                        <button type="button" id="_comment-action" data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">

                                                            <li><button class="dropdown-item" onclick="editComment(<?php echo $com['id'] ?>, '<?php echo $com['comment'] ?>')" data-bs-toggle="modal" data-bs-target="#editCommentModal">Edit Comment</button>
                                                            </li>
                                                            <li><button class="dropdown-item" onclick="deleteComment(<?php echo $com['id'] ?>)" style="color: red !important" data-bs-toggle="modal" data-bs-target="#deleteCommentModal">Delete Comment</button></li>
                                                        </ul>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <div class="comment-box">
                                            <div class="comment-content">
                                                <?php //echo $com['comment']  
                                                ?>
                                                <?php if ($com['is_edited'] == 1) : ?>
                                                    <?php echo $com['comment']  ?>
                                                    <span class='comment-edited-label'> (edited) </span>
                                                <?php elseif ($com['is_edited'] == 0) : ?>
                                                    <?php echo $com['comment']  ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <br />
                    <br />
                    <br />

                </div>
                <div class="col-3" id="rightDiv"></div>
            </div>
        </div>
    <?php endif ?>


    <!-- Modal -->
    <div class="modal fade" id="editCommentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./functions/edit_comment.php" method="POST">
                    <input type="hidden" value="<?php echo $article_id ?>" name="edit-comment__articleid">
                    <input type="hidden" id="_edit-comment__id" name="edit-comment__id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="_edit-comment__text" name="edit-comment__text" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submit_editComment" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./functions/delete_comment.php" method="POST">
                    <input type="hidden" value="<?php echo $article_id ?>" name="delete-comment__articleid">
                    <input type="hidden" id="_delete-comment__id" name="delete-comment__id">
                    <div class="modal-body">
                        <div class="mb-3">
                            Do you want to delete this comment?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submit_deleteComment" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>


</html>