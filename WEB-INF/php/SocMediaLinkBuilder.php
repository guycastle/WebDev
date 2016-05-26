<?php

/**
 * Created by PhpStorm.
 * User: guillaumevandecasteele
 * Date: 25/05/16
 * Time: 17:27
 */
class SocMediaLinkBuilder
{
    private $hashtag = "IndieGent";
    private $fbURL;
    private $twitterURL;
    private $gplusURL;
    private $whatsappURL;


    public function __construct()
    {
        $this->fbURL = "http://www.facebook.com/sharer.php?u=" . $this->getPageURL();
        $this->twitterURL = "https://twitter.com/share?url=" . $this->getPageURL() . "&hashtags=$this->hashtag";
        $this->gplusURL = "https://plus.google.com/share?url=" . $this->getPageURL();
        $this->whatsappURL = "whatsapp://send?text=" . $this->getPageURL();
    }


    private function getPageURL()
    {
        return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function getSocialMediaLinks()
    {
        $socMed = "<div class='socialmedia'>\n\t<ul class='soc-med'>\n\t";
        $socMed .= "<li><a href='$this->fbURL'><img src='img/fb.png' alt='Share on FaceBook'></a></li>\n\t\t";
        $socMed .= "<li><a href='$this->twitterURL'><img src='img/tw.png' alt='Share on Twitter'></a></li>\n\t\t";
        $socMed .= "<li><a href='$this->gplusURL'><img src='img/gp.png' alt='Share on Google+'></a></li>\n\t\t";
        $socMed .= "<li><a href='$this->whatsappURL'><img src='img/ws.png' alt='Share on Twitter'></a></li>\n\t";
        $socMed .= "</ul>\n</div>";
        return $socMed;
    }


}