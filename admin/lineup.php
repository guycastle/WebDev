<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 04/06/2016
 * Time: 17:28
 */
include "../php/PageBuilder.php";
define("SPOTIFY_PATTERN", '^spotify:.*:.*$');
define("IMAGE_ROOT", ROOT_PATH . "img/");
$pBuilder = new PageBuilder();
$storage = new Storage();
if (!isset($_SESSION["userId"]) && !isset($_SESSION["email"])) {
    header("Location:/");
}
else {
    $user = $storage->verifyUserIdAndEmail($_SESSION["userId"], $_SESSION["email"]);
    if (isset($user) && $user->admin) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $files = $_FILES["images"];
            $artist = htmlspecialchars($_POST["artist"]);
            $spotify = $_POST["spotify"];
            $time = htmlspecialchars($_POST["time"]);
            $day = htmlspecialchars($_POST["day"]);
            $description = nl2br(htmlspecialchars($_POST["description"]));
            if (isset($files) && !empty($files) &&
                isset($artist) && !empty($artist) &&
                isset($time) && !empty($time) &&
                isset($day) && !empty($day) &&
                isset($description) && !empty($description)) {
                $newShow = $storage->createShow($artist, $description, $time, $day, isset($spotify) && preg_match("/".SPOTIFY_PATTERN."/", $spotify) ? $spotify : null);
                $originalFileNames = $files["name"];
                $tempFilePaths = $files["tmp_name"];
                $fileType = $files["type"];
                for ($i = 0; $i < sizeof($originalFileNames); $i++) {
                    if (preg_match('/^image\/.*$/', $fileType[$i])) {
                        $extension = pathinfo($originalFileNames[$i], PATHINFO_EXTENSION);
                        $newPicture = $storage->createPicture($newShow->id, $extension);
                        if (isset($newPicture)) {
                            $uploadFile = IMAGE_ROOT . $newPicture->id . "." . $extension;
                            move_uploaded_file($tempFilePaths[$i], $uploadFile);   
                        }
                    }
                }
                if (empty($storage->getPictures($newShow->id))) {
                    //If we failed to upload the pictures, delete the show and inform the user to try again.
                    $storage->deleteShow($newShow->id);
                    $pBuilder->buildErrorPage("Er is een probleem opgetreden, probeer later opnieuw");
                }
                header("Location:/artists.php?id=$newShow->id");
            }
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $pBuilder->addHead("Admin");
            $pBuilder->addNavBar("admin");
            $pBuilder->addShowForm();
            $pBuilder->addFooter();
        }
    }
    else {
        header("Location:/");
    }
}