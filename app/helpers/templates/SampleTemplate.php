<?php

namespace helpers\templates;

class SampleTemplate {

  private $title;


  public function __construct(string $title) {
    $this->title = $title;
  }

  public function html() {

    return '
    <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $this->title . '</title>
      </head>
      <body>
        
      </body>
      </html>
    ';
  }
}
