<?php

class Content implements Render
{
    private $page;

    public function __construct($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        echo '<div id="content">';
        $this->processContent();
        echo '</div>';
    }

    private function processContent()
    {
        switch ($this->page) {
            case PAGE::HOME:
                $content = new Home();
                break;
            case PAGE::ABOUT_ME:
                $content = new AboutMe();
                break;
            case PAGE::GALLERY:
                $content = new Gallery();
                break;
            case PAGE::BLOG_POSTS:
                $content = new BlogPosts();
                break;
            case PAGE::PRINTS:
                $content = new Prints();
                break;
            case PAGE::CONTACT_ME:
                $content = new ContactMe();
                break;
        }

        $content->render();
    }
}
