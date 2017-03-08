<?php

class Build implements Render
{
    private $page;
    private $header;
    private $content;
    private $footer;

    public function __construct($page)
    {
        $this->page = $page;
        $this->header = new Header();
        $this->content = new Content($this->page);
        $this->footer = new Footer();
    }

    public function render()
    {
        echo '<!DOCTYPE html>';

        echo '<html lang="en">';

        echo '<head>';
        $this->renderHead();
        echo '</head>';

        echo '<body>';
        $this->renderBody();
        echo '</body>';

        echo '</html>';
    }

    private function renderHead()
    {
        echo '<head>';
        echo '<title>'.$this->page.'</title>';
        $this->renderMetadata();
        $this->linkCss();
        echo '</head>';
    }

    private function renderMetadata()
    {
        foreach (MetadataConfig::METADATA as $metadata => $value) {
            if (!is_array($value)) {
                echo '<meta ' . $metadata . '="' . $value . '">';
                continue;
            }

            foreach ($value as $internalMetadata => $internalValue) {
                echo '<meta ' . $metadata . '="' . $internalMetadata . '" content="' . $internalValue . '">';
            }
        }
    }

    private function linkCss()
    {
        foreach (CssConfig::CSS as $filename) {
            echo '<link rel="stylesheet" href="../Css/'. $filename .'.css">';
        }
    }

    private function renderBody()
    {
        echo '<body>';
        $this->header->render();
        $this->content->render();
        $this->footer->render();
        echo '</body>';
    }
}
