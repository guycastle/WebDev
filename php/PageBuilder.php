<?php
/**
 * Created by PhpStorm.
 * User: guill
 * Date: 20/05/2016
 * Time: 00:23
 */
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
setlocale(LC_ALL, 'Belgian');
include_once "Storage.php";
include_once "Mobile_Detect.php";
session_start();

class PageBuilder
{

    function addLineupCarousel()
    {
        include ROOT_PATH . "views/partials/lineupCarousel.php";
    }

    function addShowContent($show)
    {
        include ROOT_PATH . "views/partials/showContent.php";
    }

    function addRegisterForm($emailAlreadyInUse)
    {
        include ROOT_PATH . "views/partials/registerForm.php";
    }

    function buildErrorPage($message)
    {
        $this->addHead("Foutmelding");
        $this->addNavBar(null);
        $this->addError($message);
        $this->addFooter();
    }

    function addHead($title)
    {
        include ROOT_PATH . "views/partials/head.php";
    }

    function addNavBar($currentPage)
    {
        include ROOT_PATH . "views/partials/nav.php";
    }

    function addError($message)
    {
        include ROOT_PATH . "views/partials/error.php";
    }

    function addFooter()
    {
        include ROOT_PATH . "views/partials/footer.php";
    }

    function addContactForm($sessionEmail, $sessionName)
    {
        include ROOT_PATH . "views/partials/contactForm.php";
    }

    function addNewsList()
    {
        include ROOT_PATH . "views/partials/newsList.php";
    }

    function addCreateNews()
    {
        include ROOT_PATH . "views/partials/admin/newsForm.php";
    }

    function addNewsComments($newsItem)
    {
        include ROOT_PATH . "views/partials/newsComments.php";
    }

    function buildLoginPage()
    {
        $this->addHead("Login");
        $this->addNavBar("login");
        include ROOT_PATH . "views/partials/loginForm.php";
        $this->addFooter();
    }

    function addLoginForm()
    {
        include ROOT_PATH . "views/partials/loginForm.php";
    }

    function addShowForm()
    {
        include ROOT_PATH . "views/partials/admin/showForm.php";
    }
    
    function addAboutContent() {
        include ROOT_PATH . "views/partials/aboutContent.php";
    }
}