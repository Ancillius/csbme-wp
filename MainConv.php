<?php
/**
 * Created by PhpStorm.
 * User: nils
 * Date: 17.06.15
 * Time: 08:57
 */

class MainConv {
    public function __construct() {
        $convTest = new BerufeConv();
        $convTest->main('arg');
        echo 'Hallo Welt';
    }
}

