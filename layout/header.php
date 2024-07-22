<?php

if (!isset($_SESSION)) {
    session_start();
}


$isAuthenticated = true;

if (!isset($_SESSION['uid'])) {
    $isAuthenticated = false;
}

$activePage = 123;

function header_component($page)
{
    $activePage = $page;


    $form = "<form action='../auth/function/logout.php' method='POST'>
    <button class='logout' name='logout' type='submit'> Logout </button>
    </form>";

    echo "
<section class='navbar'>
    <header>
        <h4>Artikulo</h4>
        <ul>
            <li class='" . ($activePage == 'home' ? 'active-page' : '') . "'>
                <a href='../pages/welcome.php'>Home</a>
            </li>
            <li>
            " . $form . "
    
            </li>

        </ul>
    </header>
</section>";


    // <li class='" . ($activePage == 'articles' ? 'active-page' : '') . "'>
    // <a href='../pages/articles.php'>Articles</a>
    // </li>
}


?>

<style>
    <?php include_once('../layout/header.css') ?>
</style>