<?php

class Status404 implements Render
{
    public function render()
    {
        echo '<div class="404">';
        $this->processPage();
        echo '</div>';
    }

    public function processPage()
    {
        echo 'Status 404: This page could not be found.';
    }
}