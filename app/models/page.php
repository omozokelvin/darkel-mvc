<?php

namespace models;

class Page {

  private $welcome;
  public function __construct(string $welcome) {
    $this->welcome = $welcome;
  }

  public function getWelcomeMessage() {
    return $this->welcome;
  }
}
