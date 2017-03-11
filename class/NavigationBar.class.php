<?php

class NavigationBar implements Render
{
    public function render()
    {
        echo '<ul class="navigation">';
        $this->renderElements();
        echo '</ul>';
    }

    private function renderElements()
    {
        foreach (Page::PARENT as $element) {
            echo '<li>';
            $this->processElement($element);
            echo '</li>';
        }
    }

    private function processElement($element)
    {
        switch ($element) {
            case Page::HOME:
                $this->renderHomeElement();
                break;
            case Page::ABOUT_ME:
                $this->renderAboutMeElement();
                break;
            case Page::GALLERY:
                $this->renderGalleryElement();
                break;
            case Page::BLOG_POSTS:
                $this->renderBlogPostsElement();
                break;
            case Page::PRINTS:
                $this->renderPrintsElement();
                break;
            case Page::CONTACT_ME:
                $this->renderContactMeElement();
                break;
        }
    }

    private function renderHomeElement()
    {
        echo '<a href="' . Config::BASE_URL .'"><image src="./img/signature.png" width="120" height="50" alt="Millman Photography"/></a>';
    }
    private function renderAboutMeElement()
    {
        echo '<a href="' . Config::BASE_URL . 'aboutme">About Me</a>';
    }
    private function renderGalleryElement()
    {
        echo '<a href="' . Config::BASE_URL . 'gallery">Gallery</a>';
    }
    private function renderBlogPostsElement()
    {
        echo '<a href="' . Config::BASE_URL . 'blogposts">Blog Posts</a>';
    }
    private function renderPrintsElement()
    {
        echo '<a href="' . Config::BASE_URL . 'prints">Prints</a>';
    }
    private function renderContactMeElement()
    {
        echo '<a href="' . Config::BASE_URL . 'contactme">Contact Me</a>';
    }
}