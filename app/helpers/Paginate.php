<?php

namespace helpers;

/**
 *A USEFUL HELPER CLASS TO PERFORM PAGINATION
 */
class Paginate {

  function __construct(string $link, int $pageNumber, int $totalRows, int $resultsPerPage = 20) {
    $this->page($link, $pageNumber, $totalRows, $resultsPerPage);
  }

  public function page(string $link, int $pageNumber, int $totalRows, int $resultsPerPage = 20) {
    $centerLeft = $nextBtn = $previousBtn = $centerRight = $center = $open = $close = '';
    $last = ceil($totalRows / $resultsPerPage);
    $pageNumber = $pageNumber == 0 ? 1 : $pageNumber;

    if ($last < 1) {
      $last = 1;
    }

    if ($last != 1) {
      $open = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center mb-0">
            <li class="page-item"><a class="page-link" href="' . $link . "1" . '">FIRST</a></li>';
      $close = '<li class="page-item"><a class="page-link" href="' . $link . $last . '">LAST</a></li></ul></nav>';
      if ($pageNumber > 1) {
        // $previous = $pageNumber - 1;
        // $previousBtn = '<li class="page-item"><a class="page-link" href="'. $link . $previous.'">BACK</a></li>';

        for ($i = $pageNumber - 2; $i < $pageNumber; $i++) {
          if ($i > 0) {
            $centerLeft  .= '<li class="page-item"><a class="page-link" href="' . $link . $i . '">' . $i . '</a></li>';
          }
        }
      } else {
        $center = '<li class="page-item active"><a class="page-link" href="#" onclick="return false;">' . $pageNumber . '</a></li>';
        // $previousBtn = '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">BACK</a></li>';
      }
      $center = '<li class="page-item active"><a class="page-link" href="#" onclick="return false;">' . $pageNumber . '</a></li>';
      $nextCount = $pageNumber + 2 > $last ? $last : $pageNumber + 2;
      for ($i = $pageNumber + 1; $i <= $nextCount; $i++) {
        $centerRight .= '<li class="page-item"><a class="page-link" href="' . $link . $i . '">' . $i . '</a></li>';
        if ($i > $pageNumber + 4) {
          break;
        }
      }
      if ($pageNumber != $last) {
        // $next = $pageNumber + 1;
        // $nextBtn = '<li class="page-item"><a class="page-link" href="'.$link.$next.'">NEXT</a></li>';
      } else {
        // $nextBtn = '<li class="page-item disabled"><a class="page-link" href="#" onclick="return false;" tabindex="+1">NEXT</a></li>';
      }
    }
    echo  $open . $previousBtn . $centerLeft . $center . $centerRight . $nextBtn . $close;
  }
}
