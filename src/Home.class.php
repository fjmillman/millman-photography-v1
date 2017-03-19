<?php

class Home implements Render
{
    private $parallax;

    public function __construct()
    {
        $this->parallax = new Parallax();
    }

    public function render()
    {
        echo '<div class="home">';
        $this->processPage();
        echo '</div>';
    }

    public function processPage()
    {
        $this->parallax->render();
    }
}