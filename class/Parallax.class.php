<?php

class Parallax implements Render
{
    public function render()
    {
        echo '<div class="parallax">';
        $this->renderParallax();
        echo '</div>';
    }

    private function renderParallax()
    {
        for ($i = 1; $i <= 7; $i++) {
            echo '<div id="group' . $i . '" class="parallax_group">';
            echo '<div class="parallax_layer parallax_layer-' . $this->getParallaxLayer($i) . '" '
                . 'style="background-image: url("'. Config::ROOT . 'image/' . ImageConfig::PARALLAX[$i - 1] . '.jpg")">';
            echo '</div>';
            echo '</div>';
        }
    }

    private function getParallaxLayer($image) {
        switch ($image) {
            case 1:
            case 3:
            case 5:
            case 7:
                return 'base';
            case 2:
            case 6:
                return 'back';
            case 4:
                return 'deep';
        }
    }
}