<?php
class Phptest {
  public static function test($param) {
    echo $param;
  }
  public function __construct() {
    $this->test("Hallo", "Walt");
  }
}

$test = new Phptest();
