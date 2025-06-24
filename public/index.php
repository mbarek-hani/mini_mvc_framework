<?php

require_once "../app/init.php";

Router::get("/test", "TestController", "show");
Router::get("/test/add", "TestController", "add");
Router::get("/test/update", "TestController", "update");
Router::get("/test/delete", "TestController", "delete");
