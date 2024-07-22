<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['uid'])) {
    header('Location: ../pages/welcome.php');
}


$email = $_POST['email'] ?? null;
$pass = $_POST['pass'] ?? null;

$error = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $error = 0;

    include_once('../connection/connection.php');
    $con = connection();
    $pdo = pdo();

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM `accounts` WHERE `email_address` = :email AND `password` = :password";
    $res = $pdo->prepare($sql);
    $res->bindValue(':email', $email);
    $res->bindValue(':password', md5($pass));
    $res->execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);


    if ($row > 0) {
        $error = 0;
        $_SESSION['uid'] = $row['uid'];
        header('Location: ../pages/welcome.php');
    } else {
        $error = 1;
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../public/preset.css">

    <title>Document</title>
</head>

<body>

    <div class="container d-flex justify-content-center">
        <div class="card">
            <div class="card-contents">
                <div class="row">

                    <div class="col-6 left">
                        <div class="row d-flex justify-content-center">
                            <img id="people_svg" class="people_svg_brown" src="../img/people-brown.svg" alt="" srcset="">
                            <!-- <img id="people_svg" class="people_svg_blue" src="../img/people-blue.svg" alt="" srcset=""> -->
                            <h1 class="text-center">This is a website</h1>
                            <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras euismod, enim nec vehicula rhoncus, mi ipsum egestas nulla, a finibus arcu velit eu dui. Ut consectetur in mauris sit amet ultrices. Nulla sed pharetra lorem. Integer a erat quis turpis maximus bibendum. </p>
                        </div>
                    </div>

                    <div class="col-6 right">
                        <div class="row">
                            <h1>Login</h1>
                            <p>Enter your credentials to access our website</p>
                            <?php if ($error) : ?>
                                <div class="alert alert-error" role="alert" id="">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span>Incorrect email or passswords</span>

                                </div>
                            <?php endif ?>

                            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="mb-3">
                                    <input class="form-control p-3" name="email" type="email" value="<?php echo $email ?>" placeholder="Email Address" required>
                                </div>
                                <div class="mb-3 mt-4">
                                    <input class="form-control p-3" name="pass" type="password" value="<?php echo $pass ?>" placeholder="Password" required>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Remember Me
                                    </label>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <button class="login-btn" type="submit">Login</button>
                                </div>

                                <hr class="mt-4">
                                <p class="mb-0 text-center">Don't have an account?</p>
                                <div class="d-flex justify-content-center">
                                    <a href="register.php">Sign up</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>