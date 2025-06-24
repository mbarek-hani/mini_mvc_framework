<?php

require_once "../app/init.php";

Router::get("/test", "TestController", "show");
Router::get("/test/delete/[0-9]+", "TestController", "delete");