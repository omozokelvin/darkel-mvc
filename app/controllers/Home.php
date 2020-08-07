<?php

use libraries\Controller;
use models\HomeModel;

class Home extends Controller {
  public function __construct() {
    $this->homeModel = new HomeModel('Welcome');
  }

  public function index() {
    $data = [
      'title' => $this->homeModel->getWelcomeMessage(),
    ];

    $this->view('pages/index', $data);
  }
}
