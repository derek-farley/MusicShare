<?php
require_once "meekrodb.2.3.class.php";
require_once "support.php";

includeConstants();
dbConfig();

switch ($_GET["operation"]) {
    case "like" :
        DB::insert()
}
