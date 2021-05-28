<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunnyGames</title>
    <link rel="icon" href="illustrations/favicon.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<style>
    body {
        background-color: #26376D;
    }

    .header_inline {
        display: inline;
    }

    .logo_img {
        background-image: url(illustrations/funnylogo.svg);
        background-repeat: no-repeat;
        width: 38vw;
        height: 6vw;
        margin: 20px 0 0 10px;
    }

    .searchbar {
        margin-top: 40px;
        padding: 3vw 40vw 3vw 5vw;
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 12vw;
        opacity: 50%;
        border: none;
        border-radius: 5px;
    }

    ::placeholder {
        color: black;
        font-weight: bolder;
        opacity: 100;
    }

    .add_btn {
        background-image: url(illustrations/add_btn.svg);
        background-repeat: no-repeat;
        width: 6vw;
        height: 6vw;
        float: right;
        position: relative;
        top: -38vw;
        margin-right: 8px;
    }

    .profile_btn {
        background-image: url(illustrations/profile_btn.svg);
        background-repeat: no-repeat;
        width: 6vw;
        height: 6vw;
        float: right;
        position: relative;
        top: -38vw;
        margin-right: 8px;
    }

    @media screen and (min-width: 1000px) {
        .logo_img {
            width: 15vw;
            height: 3vw;
            margin: 40px 0 0 2vw;
        }

        .searchbar {
            margin-top: 40px;
            padding: 1vw 23vw 1vw 2vw;
            position: absolute;
            left: 35vw;
            top: 0vw;
        }

        .add_btn {
            width: 3vw;
            height: 3vw;
            top: -4vw;
            margin-right: 2vw;
        }

        .profile_btn {
            width: 3vw;
            height: 3vw;
            top: -4vw;
            margin-right: 2vw;
        }

        .search_btn {
            position: relative;
            top: -2.2vw;
            right: -65vw;
        }
    }

    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #2E3F72;
    }

    ::-webkit-scrollbar-thumb {
        background: #272357;
        ;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #726DAB;
    }
</style>

<?php
include_once(__DIR__ . "/classes/Database.php");

$conn = Db::Connection();

if (isset($_POST["submit"])) {
    $str = $_POST["search"];
    $sth = $conn->prepare("SELECT * FROM 'user' WHERE username = '$str'");

    $sth->setFetchMode(PDO::FETCH_OBJ);
    $sth->execute();

    // var_dump($sth);

    if ($row = $sth->fetch()) {
?>
        <br><br><br>
        <table>
            <tr>
                <th>Name</th>
            </tr>
            <tr>
                <td><?php echo $row->username; ?></td>
            </tr>
        </table>
<?php
    } else {
        //echo "Name does not exist";
    }
}
?>

<header>
    <div class="header">
        <a href="index.php">
            <div class="logo_img"></div>
        </a>

        <form method="post">
            <label for="search"></label>
            <input type="text" placeholder="Search..." class="searchbar" name="search">
            <input type="submit" name="submit" class="search_btn" value="search">
        </form>

        <a href="profile_settings.php">
            <div class="profile_btn"></div>
        </a>
        <a href="add.php">
            <div class="add_btn"></div>
        </a>
    </div>
</header>