<?php

require_once($root . 'bootstrap.php');

if (isset($page)) {
    $$page = new Build($page);
    $$page->render();
}
