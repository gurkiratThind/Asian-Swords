<?php

require_once 'global_define.php';
if (!isset($index_loaded)) {
    die('Direct acces to this file is forbidden');
}

/**
 * class web_page is  used to output the html/css web page.
 */
class web_page
{
    public $title = PAGE_DEFAULT_TITLE;
    public $description = PAGE_DEFAULT_DESCRIPTION;
    public $author = PAGE_DEFAULT_AUTHOR;
    public $lang = PAGE_DEFAULT_LANG;
    public $icon = PAGE_DEFAULT_ICON;

    public $content = '';

    /**
     * the constructor.
     */
    public function __construct()
    {
    }

    /**
     * displays the web page.
     */
    public function render()
    {
        if ($this->content == '') {
            //error, no content was set
            http_response_code(500); // 500 repersents Internal server error

            //send email to server admin
            //mail(ADMIN_EMAIL, 'Error in web_page.php', 'No content set in web_page.com');
            die('Sorry we have a problem'); // stop program with message
        }
        if ($this->lang == 'en-CA') {
            require_once 'template.php';
        } elseif ($this->lang == 'fr-CA') {
            require_once 'template_fr.php';
        } else {
            die('language not supported');
        }

        die(); //stop program here
    }

    // end of render
}// end of class
