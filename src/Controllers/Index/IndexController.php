<?php

namespace TaskTracker\Controllers\Index;

use Lib\Controller\AuthorizedController;

class IndexController extends AuthorizedController {
    public function run() {
        echo 'Мой id: ' . $this->getUserId();
    }
}
