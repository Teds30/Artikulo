<?php

if (!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['uid'])) {
    header('Location: ../auth/login.php');
}

$uid = $_SESSION['uid'];

if(isset($_POST['btnArticle'])) {
    header('Location: ./articles.php');
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

    <!-- CSS -->
	<link rel="stylesheet" href="../css/welcome.css">
    <title>Document</title>
</head>
<body>
    <div class="d-flex flex-row-reverse bd-highlight">
        <div class="p-2 mt-3 me-5">
            <form action="../auth/function/logout.php" method="POST">
                <button class="logout-btn" name="logout" type="submit">Logout</button>
            </form>
        </div>
      </div>
    <div class="container">
        <div class="row">
            <img class="mt" id="welcome_svg" src="../img/welcome/welcome_svg.svg">
            <h1 class="text-center mt-md-5">Welcome to our page!</h1>
            <form action="" method="post">
                <button class="primarybutton" name="btnArticle">Read Articles</button>
            </form>
        </div>
    </div>
</body>
</html>