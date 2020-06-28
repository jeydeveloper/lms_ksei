<?php
require_once(BASEPATH . "application/libraries/PHPExcel.php");

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}

