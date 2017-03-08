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
        if (in_array($this->page, PAGE::PARENT)) {
            $content = new $this->page();
            $content->render();
        }
    }
}
