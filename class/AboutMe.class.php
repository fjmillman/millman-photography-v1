<?php

class AboutMe implements Render
{
    public function render()
    {
        echo '<div class="aboutme">';
        $this->processPage();
        echo '</div>';
    }

    public function processPage()
    {
        echo '<p>';
        echo 'Fred Millman is a Yorkshire-born student of Computer Science based in the UNESCO world heritage city of Bath in the United Kingdom.';
        echo '</p>';
        echo '<p>';
        echo '<img src="' . Config::BASE_URL . 'serve.php?image=fred.jpg" alt="Fred" width="300" height="400" align:"middle"/>';
        echo '</p>';
        echo '<p>';
        echo 'He began his path into photography by picking up a DSLR and joining up with the University of Bath\'s Photography Society in his first year.';
        echo '</p>';
        echo '<p>';
        echo 'Over the next few years, he would begin to explore a new way of seeing the world around him and take advantage of the opportunities that the Photography Society had to offer.';
        echo '</p>';
        echo '<p>';
        echo 'Fred\'s main interests in photography lie firmly in Landscapes, although he has dabbled in Portraits, and Architecture.';
        echo '</p>';
        echo '<p>';
        echo 'Check out his work in the Gallery.';
        echo '</p>';
    }
}