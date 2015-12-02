<?php
/**
 * Created by PhpStorm.
 * User: Manjesh
 * Date: 19-10-2015
 * Time: 16:42
 */



define('DEVELOPMENT', 'localhost');
define('PRODUCTION', 'abc.com');

/**
 * Creates database table, users and database connection.
 *
 * @return \PDO
 */


function getConnection() {
    switch ($_SERVER['SERVER_NAME']) {
        case DEVELOPMENT:
            $dbhost="localhost";
			$dbuser="root";
            $dbpass="";
            $dbname="abc";
            break;

        default:
            // live server
            // header('Access-Control-Allow-Origin: http://beatle.par-ken.com');
            $dbhost="localhost";
            $dbuser="root";
            $dbpass="";
            $dbname="eastwest";
            break;
    }

    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    return $dbh;
}

