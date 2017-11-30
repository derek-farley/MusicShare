<?php
	require_once 'meekrodb.2.3.class.php';

	function dbConfig() {
		/*
		 * function to call before using meekroDB operations; configures for musicshare db
		 */
		DB::$host = DatabaseConfig::HOST;
		DB::$dbName = DatabaseConfig::DATABASE;
		DB::$password = DatabaseConfig::PASSWORD;
		DB::$user = DatabaseConfig::USER;
	}

	/*
	 * loops thru Constants folder including all files for use in db ops
	 */
	function includeConstants($relativepath = "") {
		foreach(glob($relativepath."Constants/*.php") as $filename) {
			require_once $filename;
		}
	}

	function generatePage($body, $title="Example") {
	    $page = <<<EOPAGE
	<!doctype html>
	<html> 
	    <head>
	        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	        <title>$title</title>
	    </head>

	    <body>
	            $body
	    </body>
	</html>
EOPAGE;

	    return $page;
	}
	?>
