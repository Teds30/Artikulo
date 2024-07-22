<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['uid'])) {

    header('Location: ../auth/login.php');
}
include_once("../connection/connection.php");

$pdo = pdo();

$sql = "SELECT * FROM articles ORDER BY `id` DESC";
$res = $pdo->prepare($sql);
$res->execute();


function getAccountName($uid)
{
    $pdo = pdo();
    $sql = "SELECT * FROM accounts WHERE `uid` = '$uid'";
    $res = $pdo->prepare($sql);
    $res->execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);

    if ($row > 0) {
        $author = $row['first_name'] . ' ' . $row['last_name'];

        return $author;
    }
}

function formatDate($date)
{

    $time = strtotime($date);
    $myFormatForView = date("F j \, Y", $time);
    return $myFormatForView;
}

if (isset($_POST['create-btn'])) {
    header('Location: ./new_article.php');
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
    <link rel="stylesheet" href="../css/article.css">

    <title>Articles</title>
</head>

<body>
    <?php
    include '../layout/header.php';
    header_component('articles');
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 p-5" id="leftDiv">
                <!-- <a href="./welcome.php" style="color: black; font-weight: 700"> <span><i class="bi bi-arrow-left"></i></span> Go Back</a> -->
            </div>
            <div class="col-6 pt-5" id="midDiv">
                <div>
                    <h2>Articles</h2>
                </div>
                <form action="" method="post">
                    <button class="btn btn-primary" name="create-btn">Create new Article</button>
                </form>

                <div class="w-100 mt-4">
                    <?php while ($row = $res->fetch(PDO::FETCH_ASSOC)) : ?>
                        <div class="row mt-3 article-card">
                            <div class="col-4 article-img-container">
                                <div class="article-img">
                                    <img src="../assets/articles/<?php echo $row['photo_headline'] ?>" alt="">
                                </div>
                            </div>

                            <div class="col-8 article-content">
                                <h4><?php echo $row['title'] ?></h4>
                                <div>
                                    <p><?php echo getAccountName($row['author_uid']) ?> </p>
                                    <p class="article-date">
                                        <?php echo formatDate($row['date_created']) ?>
                                    </p>
                                </div>
                                <div class="mt-2">
                                    <a href="./read_article.php?article_id=<?php echo $row['id'] ?>">Read Article
                                        <span>
                                            <i class="bi bi-arrow-right"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php endwhile ?>



                </div>





            </div>
            <div class="col-3" id="rightDiv"></div>
        </div>
    </div>
</body>

</html>