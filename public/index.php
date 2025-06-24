<?php

require_once "../app/init.php";

Router::get("/home", function() {
    echo "hello from home";
});