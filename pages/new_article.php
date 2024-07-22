<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['uid'])) {

    header('Location: ../auth/login.php');
}
include_once("../connection/connection.php");

$con = connection();

$category_sql = "SELECT * FROM articles_category";
$category_res = $con->query($category_sql) or die($con->error);

$categories = null;

while ($category_row = $category_res->fetch_assoc()) {
    $categories[] = $category_row;
}

$uid = $_SESSION['uid'];

$title = $_POST['title'] ?? null;
$content = $_POST['content'] ?? null;
$category = $_POST['category'] ?? null;
$photo = $_FILES["fileToUpload"]["name"] ?? '';

$has_error = 0;
$error_msg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {



    if (!isset($title) || strlen(trim($title)) == 0) {
        $has_error = 1;
        $error_msg .= ' &bull; Title is required.<br />';
    }

    if (!isset($content) || strlen(trim($content)) == 0) {
        $has_error = 1;
        $error_msg .= ' &bull; Content is required.<br />';
    }



    if (!isset($photo) || strlen(trim($photo)) == 0) {
        $has_error = 1;
        $error_msg .= ' &bull; Photo Headline is required.<br />';
    }

    if (strlen($category) == 0) {
        $has_error = 1;
        $error_msg .= ' &bull; Category is required.<br />';
    }


    /*
    @
    @
    @
    */

    if (!$has_error) {

        $passed = 0;


        if (strlen($photo) > 0) {


            $target_dir = "../assets/articles/";
            $uploadOk = 1;

            $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));  // gets file extension

            $time_stamp = time();
            $imgName = "art_{$time_stamp}.{$imageFileType}";

            $target_file = $target_dir . $imgName; // this is the target file on upload

            $check = filesize($_FILES["fileToUpload"]["tmp_name"]);  // gets file size

            if ($check) { // checks if file is an image
            } else {
                $uploadOk = 0;
            }


            if ($_FILES["fileToUpload"]["size"] > 5000000) { // checks file if more than 5MB, if not file goes upload
                $upload_errors .= "<br />Sorry, your file is too large.";
                $uploadOk = 0;
            }


            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $upload_errors .= "<br />Sorry, only JPG, JPEG, PNG files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                $upload_errors .= "Sorry, your file was not uploaded.";
            } else {

                $result = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            }


            if ($uploadOk) {
                $passed = 1;
            } else {
                $passed = 0;
            }
        }


        if ($passed) {
            $pdo = pdo();

            $title = $_POST['title'];
            $content = $_POST['content'];
            $date = $_POST['content'];
            $category_id = $_POST['category'];

            $sql = "INSERT INTO `articles`(`title`, `contents`, `author_uid`, `photo_headline`, `category_id`) VALUES (:title,:content,:uid, :imgName, :category_id)";

            $res = $pdo->prepare($sql);
            $res->bindValue(':title', $title);
            $res->bindValue(':content', $content);
            $res->bindValue(':uid', $uid);
            $res->bindValue(':imgName', $imgName);
            $res->bindValue(':category_id', $category_id);

            $res->execute();

            header('Location: ./articles.php');
        }
    }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>


    <!-- CSS -->
    <link rel="stylesheet" href="./articles/css/new_article.css">
    <link rel="stylesheet" href="../public/preset.css">

    <title>Document</title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="card">
            <div>

                <a href="./articles.php"> <span><i class="bi bi-arrow-left"></i></span> Go Back</a>
            </div>

            <div class="card-contents">
                <?php if ($has_error == 1) : ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <strong class="">Attention!</strong>
                            <p class=""><?php echo $error_msg; ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                <form class="row needs-validation" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">


                    <h1>Create New Article</h1>
                    <p class="secondary-text">Share your thoughts</p>

                    <div class="mt-3 ms-1 row">
                        <div class="col-6 ps-0 pe-4 basic-credentials">

                            <!-- <select class="selectpicker" data-live-search="true">
                                <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                                <option data-tokens="mustard">Burger, Shake and a Smile</option>
                                <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                            </select> -->

                            <div class="col-md-6">
                                <label for="titleheadline" class="form-label">TITLE (HEADLINE) </label> <br>
                                <input placeholder="Type the title here" type="title" name="title" class="form-control" id="titleheadline" value="<?php echo $title ?>">
                                <br>
                            </div>

                            <label class="form-label" for="upload-photo"> UPLOAD PHOTO HEADLINE </label> <br>
                            <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" value="<?= $photo ?>" accept="image/*" onchange="preview_image(event)" required />
                            </br>
                        </div>
                        <select class="form-select mt-2" name="category">
                            <option selected value=""> -- Select Category --</option>
                            <?php foreach ($categories as $cat) : ?>
                                <?php if ($category == $cat['id']) : ?>
                                    <option selected value="<?php echo $cat['id'] ?>"><?php echo $cat['category'] ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $cat['id'] ?>"><?php echo $cat['category'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                        <div class="form-group mt-4">
                            <label for="exampleFormControlTextarea1">Content</label>
                            <textarea class="form-control" placeholder="Type your article's content here..." name="content" id="exampleFormControlTextarea1" rows="5"><?= $content ?></textarea>
                        </div>


                    </div>
            </div>
            <!--COL-->


            <div class="mt-5 row d-flex justify-content-center">
                <button class="primarybutton" name="article-btn" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Publish Article</button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Publish Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you done writing your article?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn btn-ligh" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="publish-btn" class="btn btn-primary">Publish</button>
                        </div>
                    </div>
                </div>
            </div>

            </form>
            <!--ROW-->
        </div>


    </div>
    </div>
</body>


</html>