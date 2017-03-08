<?php

class Header implements Render
{
    private $navigationBar;

    public function __construct()
    {
        $this->navigationBar = new NavigationBar();
    }

    public function render()
    {
        echo '<div id="header">';
        $this->navigationBar->render();
        echo '</div>';
    }
}