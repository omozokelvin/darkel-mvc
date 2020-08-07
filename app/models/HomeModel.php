<?php

namespace models;

use libraries\Database;

class HomeModel {

  private $welcome;

  //uncomment below line to create private variable for db connections
  // private $db;
  public function __construct(string $welcome) {
    $this->welcome = $welcome;
    //uncomment below line to create new instance of database connection
    //$this->db = Database::instance();
  }

  public function getWelcomeMessage() {
    return $this->welcome;
  }
}
