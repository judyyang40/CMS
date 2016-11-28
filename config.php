<?php
    // Display errors in the browser
    ini_set("display_errors", true);
    // Set the timezone
    date_default_timezone_set("America/Los_Angeles");
    // Set the database access details
    define("DB_DSN", "mysql:host=localhost;dbname=phpmywind_db");
    define('DB_SERVER', 'localhost');
    define('DB_DATABASE', 'phpmywind_db');
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "root");
    // Set the paths
    define("CLASS_PATH", "classes");
    define("TEMPLATE_PATH", "templates");
    // Set the number of articles to display on the homepage
    define("HOMEPAGE_NUM_GOODS", 10);
    // Set the image-related constants
    define("GOOD_IMAGE_PATH", "uploads");
    define("IMG_TYPE_FULLSIZE", "fullsize");
    define("IMG_TYPE_THUMB", "thumb");
    define("GOOD_THUMB_WIDTH", 120);
    define("JPEG_QUALITY", 85);
    // Include the Good class
    require(CLASS_PATH."/Good.php");
    // Create an exception handler
    function handleException($exception) {
    	echo "Sorry, a problem occurred. Please try later.";
    	error_log($exception->getMessage());
    }

    set_exception_handler('handleException');
?>