<?php

/**
 * Created by PhpStorm.
 * User: guillaumevandecasteele
 * Date: 25/05/16
 * Time: 17:27
 */
include_once "Mobile_Detect.php";

//Deprecated class, wanted to do it myself, but there are better and simpler options available online
class SocMediaLinkBuilder
{

    private $hashtag = "IndieGent";
    private $fbURL;
    private $twitterURL;
    private $gplusURL;
    private $whatsappURL;
    private $mobileDetect;


    public function __construct()
    {
        $this->fbURL = "http://www.facebook.com/sharer.php?u=" . urlencode(htmlspecialchars($this->getPageURL()));
        $this->twitterURL = "https://twitter.com/share?url=" . urlencode(htmlspecialchars($this->getPageURL())) . "&hashtags=$this->hashtag";
        $this->gplusURL = "https://plus.google.com/share?url=" . urlencode(htmlspecialchars($this->getPageURL()));
        $this->whatsappURL = "whatsapp://send?text=" . urlencode(htmlspecialchars($this->getPageURL()));
        //Need this to detect whether or not the device is mobile. Could've written my own code, but why reinvent the wheel
        $this->mobileDetect = new Mobile_Detect();
    }


    private function getPageURL()
    {
        return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function getSocialMediaLinks()
    {
        $socMed = "<div class='row'>\n<ul class='soc-med col-lg-2'>\n";
        $socMed .= "<li><a href='$this->fbURL' target='_blank'><img src='img/fb.png' alt='Share on FaceBook'></a></li>\n";
        $socMed .= "<li><a href='$this->twitterURL' target='_blank'><img src='img/tw.png' alt='Share on Twitter'></a></li>\n";
        $socMed .= "<li><a href='$this->gplusURL' target='_blank'><img src='img/gp.png' alt='Share on Google+'></a></li>\n";
        $socMed .= "<a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=http%3A//macbook/artists.php?id=1\'>Share on Facebook</a>";
        //Whatsapp link won't work on non-mobile devices (or most tablets) so don't create the button
        if ($this->mobileDetect->isMobile() && !$this->mobileDetect->isTablet()) {
            $socMed .= "<li><a href='$this->whatsappURL' target='_blank'><img src='img/ws.png' alt='Share on Twitter'></a></li>\n";
        }
        $socMed .= "</ul>\n</div>";
        return $socMed;
    }


}