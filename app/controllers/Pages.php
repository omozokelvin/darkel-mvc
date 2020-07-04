<?php

use libraries\Controller;
use models\Page;

class Pages extends Controller {
  public function __construct() {
    $this->pageModel = new Page('Welcome');
  }

  public function index() {
    $data = [
      'title' => $this->pageModel->getWelcomeMessage(),
    ];

    $this->view('pages/index', $data);
  }
}
