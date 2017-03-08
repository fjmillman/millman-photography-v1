<?php

class Footer implements Render
{
    public function render()
    {
        echo '<div id="footer">';
        $this->renderFooter();
        echo '</div>';
    }

    private function renderFooter()
    {
        echo 'Photography by Freddie John Millman
            | <a style="display:inline" href="https://www.facebook.com/millmanphotography" target="_blank">Facebook</a>
            | <a style="display:inline" href="https://instagram.com/millmanphotography" target="_blank">Instagram</a>';
    }
}