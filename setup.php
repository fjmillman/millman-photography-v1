<?php

require_once($root . 'bootstrap.php');

$class = strtoupper($page);

$$page = new Build(Page::$class);
$$page->render();
