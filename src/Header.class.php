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
        echo '<nav>';
        $this->navigationBar->render();
        echo '</nav>';
    }
}