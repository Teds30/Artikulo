<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['uid'])) {
    header('Location: ../pages/welcome.php');
}

include_once('../connection/connection.php');

$firstname = $_POST['firstname'] ?? null;
$lastname = $_POST['lastname'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

$bday = $_POST['bday'] ?? null;
$gender = $_POST['gender'] ?? null;

$street = $_POST['street'] ?? null;
$city = $_POST['city'] ?? null;
$state = $_POST['state'] ?? null;
$zipcode = $_POST['zipcode'] ?? null;

$has_error = 0;
$error_msg = '';
$isInvalid = 0;


$upload_errors = '';
$upload_success_msg = '';

$noSelected = ($gender == 'none') ? 'selected' : '';
$maleSelect = ($gender == 'male') ? 'selected' : '';
$femaleSelect = ($gender == 'female') ? 'selected' : '';

$passed = 0; // CHECKS IF TEXT INPUTS AND UPLOADED PHOTO HAS NO ERRORS


function checkEmail($email)
{

    $pdo = pdo();
    $sql = 'SELECT * FROM accounts WHERE `email_address` = :email';
    $res = $pdo->prepare($sql);
    $res->bindValue(':email', $email);
    $res->execute();

    $row = $res->fetch(PDO::FETCH_ASSOC);

    if ($row > 0) {
        return true;
    }
    return false;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    include './validation/validate_register.php';

    $has_error = validateRegister(
        $firstname,
        $lastname,
        $email,
        $password
    );

    $isTaken = checkEmail($email);


    if ($gender) {
        $noSelected = 'selected';
    } else if ($gender == 'male') {
        $maleSelect = 'selected';
    } else {
        $femaleSelect = 'selected';
    }

    if (
        !$has_error &&
        !$isTaken
    ) {
        $passed = 1;
    }

    $pic = null;
    $photo = $_FILES["fileToUpload"]["name"] ?? '';

    if (strlen($photo) > 0 && !$has_error && !$isTaken) {


        $target_dir = "../assets/uploads/";
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));  // gets file extension

        $time_stamp = time();

        $pic = "user_{$time_stamp}.{$imageFileType}";
        $target_file = $target_dir . "user_{$time_stamp}.{$imageFileType}"; // this is the target file on upload

        $check = filesize($_FILES["fileToUpload"]["tmp_name"]);  // gets file size

        if ($check) { // checks if file is an image
        } else {
            $uploadOk = 0;
        }


        if ($_FILES["fileToUpload"]["size"] > 3000000) { // checks file if more than 3MB, if not file goes upload
            $upload_errors .= "<br />Sorry, your file is too large.";
            $uploadOk = 0;
        }


        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $upload_errors .= "<br />Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Allow certain file formats

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $upload_errors .= "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {

            $result = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

            if ($result) {
                $upload_success_msg .= "<br /><br />The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                $upload_errors .= "<br /><br />Sorry, there was an error uploading your file.";
            }
        }

        if (strlen($upload_errors) > 0) {
            echo $upload_errors;
        }

        if ($uploadOk) {
            $passed = 1;
        } else {
            $passed = 0;
        }

        // echo $upload_success_msg;
    }

    if ($passed) {
        include_once('./function/create_account.php');

        createAccount($firstname, $lastname, $email, $password, $bday, $gender, $street, $city, $state, $zipcode, $pic);
        // echo "<script> alert('You are now Registered!') </script>";

        header("Location: ./login.php");
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

    <!-- CSS -->
    <link rel="stylesheet" href="../css/register.css">

    <title>Document</title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="card">
            <div class="card-contents">

                <form class="row needs-validation" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">


                    <h1>Set up your account</h1>
                    <p class="secondary-text">It all starts here. Fill up all required fields to continue</p>

                    <div class="mt-3 ms-1 row">
                        <div class="col-6 ps-0 pe-4 basic-credentials">

                            <div class="mb-3 row">
                                <label for="upload" class="form-label mt-2">Upload Photo</label>

                                <?php
                                if (strlen($upload_errors) > 0) {
                                    $isPhotoInvalid = 1;
                                }
                                ?>
                                <div class="input-group">
                                    <input type="file" title="test" name="fileToUpload" class="form-control" id="fileToUpload" accept="image/*" required />
                                </div>
                                <div class="row">
                                    <p class="<?php echo ($isPhotoInvalid ? 'p_error' : 'p_hide') ?>"><?php echo $upload_errors; ?></p>
                                </div>

                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="form-label">User name *</label>

                                <?php
                                $isInvalid = $_SERVER['REQUEST_METHOD'] === 'POST' && validateField($firstname);
                                ?>

                                <div class="col <?php echo ($isInvalid ? 'has_error' : '') ?>">
                                    <input class="form-control p-3" type="text" class="form-control" name="firstname" value="<?php echo $firstname ?>" placeholder="First Name">
                                    <p class="<?php echo ($isInvalid ? 'p_error' : 'p_hide') ?>">Please enter your first name</p>
                                </div>

                                <?php
                                $isInvalid = $_SERVER['REQUEST_METHOD'] === 'POST' && validateField($lastname);
                                ?>

                                <div class="col <?php echo ($isInvalid ? 'has_error' : '') ?>">
                                    <input class="form-control p-3" type="text" class="form-control" name="lastname" value="<?php echo $lastname ?>" placeholder="Last Name">
                                    <p class="<?php echo ($isInvalid ? 'p_error' : 'p_hide') ?>">Please enter your last name</p>
                                </div>

                            </div>

                            <?php
                            $isInvalid = $_SERVER['REQUEST_METHOD'] === 'POST' && validateField($email);
                            ?>
                            <?php
                            $isTaken = $_SERVER['REQUEST_METHOD'] === 'POST' && checkEmail($email);
                            ?>

                            <div class="mb-3 <?php echo ($_SERVER['REQUEST_METHOD'] === 'POST' && validateField($email) ? 'has_error' : '') ?>">
                                <label for="exampleFormControlInput1" class="form-label">Email Address *</label>
                                <input class="form-control p-3" type="email" class="form-control" name="email" value="<?php echo $email ?>" placeholder="Email Address">
                                <p class="<?php echo ($isInvalid ? 'p_error' : 'p_hide') ?>">Please enter a valid email address</p>
                                <p class="<?php echo ($isTaken ? 'p_error' : 'p_hide') ?>">This email address is already taken!</p>
                            </div>

                            <?php
                            $isInvalid = $_SERVER['REQUEST_METHOD'] === 'POST' && validateField($password);
                            ?>
                            <div class="mb-3 <?php echo ($_SERVER['REQUEST_METHOD'] === 'POST' && validateField($password) ? 'has_error' : '') ?>">
                                <label for="exampleFormControlInput1" class="form-label">Create a password *</label>
                                <input class="form-control p-3" type="password" class="form-control" name="password" id="password" value="<?php echo $password ?>" placeholder="Password">
                                <p class="<?php echo ($isInvalid ? 'p_error' : 'p_hide') ?>">Please enter a password</p>
                            </div>
                        </div>


                        <div class="col-6 ps-5 personal-information">
                            <div class="mb-3 row">
                                <label for="exampleFormControlInput1" class="form-label">Address</label>

                                <div class="col">
                                    <input class="form-control p-3" type="text" class="form-control" name="street" value="<?php echo $street ?>" placeholder="Street Address">
                                </div>
                                <div class="col">
                                    <input class="form-control p-3" type="text" class="form-control" name="city" value="<?php echo $city ?>" placeholder="City">
                                </div>

                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <input class="form-control p-3" type="text" class="form-control" name="state" value="<?php echo $state ?>" placeholder="State / Province">
                                </div>
                                <div class="col">
                                    <input class="form-control p-3" type="text" class="form-control" name="zipcode" value="<?php echo $zipcode ?>" placeholder="Zip Code">
                                </div>

                            </div>

                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="exampleFormControlInput1" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="form_birthdate" name="bday" value="<?php echo $bday ?>">
                                </div>
                                <div class="col">
                                    <label for="exampleFormControlInput1" class="form-label">Gender</label>

                                    <select class="form-select" aria-label="Default select example" name="gender" value="<?php echo $gender ?>">
                                        <option value="none" <?php echo  $noSelected ?>>--Select a gender--</option>
                                        <option value="male" <?php echo  $maleSelect ?>>Male</option>
                                        <option value="female" <?php echo  $femaleSelect ?>>Female</option>
                                    </select>
                                </div>

                            </div>

                        </div>
                    </div>
                    <!--COL-->

                    <p class="mt-4 text-center secondary-text">By signing up, You are agreeing to our <strong>Terms</strong> and <strong>Conditions</strong></p>

                    <div class="row d-flex justify-content-center">
                        <!-- <a href="../welcome.html" class="signup-btn" role="button">Create an Account</a> -->
                        <button class="signup-btn" type="submit">Create an Account</button>
                        <hr class="mt-4 mb-4" style="width: 80% !important">
                    </div>

                    <p class="text-center">Already have an account? <span><a href="login.php">Login here</a></span></p>

                </form>
                <!--ROW-->
            </div>
        </div>
    </div>
</body>

</html>