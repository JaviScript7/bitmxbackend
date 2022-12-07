<?php
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");



if (file_exists('vendor/autoload.php')) {
	// load via composer
	require_once('vendor/autoload.php');
	$f3 = \Base::instance();
} elseif (!file_exists('lib/base.php')) {
	die('fatfree-core not found. Run `git submodule init` and `git submodule update` or install via composer with `composer install`.');
} else {
	// load via submodule
	/** @var Base $f3 */
	$f3=require('lib/base.php');
}

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<8.0)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config.ini');
$f3->config('routes.ini');

//Vamos a realizar la conexion de la base de datos
$f3->set('DB', new DB\SQL('mysql:host='.$f3->get('database.host'). ';port=3306;dbname='.$f3->get('database.dbname'),$f3->get('database.name'),$f3->get('database.pass')));
$options = array(
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // generic attribute
    \PDO::ATTR_PERSISTENT => TRUE,  // we want to use persistent connections
    \PDO::MYSQL_ATTR_COMPRESS => TRUE, // MySQL-specific attribute
);

//Nos muestra un mensaje que nos muestra la conexion con la DB
/*
echo"<pre>";
print_r($f3->get('DB'));
echo"</pre>";*/

//Esto nos permita hacer una validacion de nuestros modelos (CREACION DE UNA RUTA)
/*
$f3->route('GET /prueba-1', function($f3){
	$M_Alumnos = new M_Alumnos();
	$result = $M_Alumnos->find();
	foreach($result as $alumno){
		echo "<pre>";
		print_r($alumno->cast());
		echo "</pre>";
	}


});*/

//Vamos a crear la(s) ruta(s) 
/*
$f3->route('POST /crear-alumno', 'Alumnos_ctrl->crear');
$f3->route('GET /consultar-alumno/@alumno_id', 'Alumnos_ctrl->consultar');
$f3->route('POST /eliminar-alumno/@alumno_id', 'Alumnos_ctrl->eliminar');
$f3->route('GET|POST /listado-alumno', 'Alumnos_ctrl->listado');
*/



$f3->route('GET /',
	function($f3) {
		$classes=array(
			'Base'=>
				array(
					'hash',
					'json',
					'session',
					'mbstring'
				),
			'Cache'=>
				array(
					'apc',
					'apcu',
					'memcache',
					'memcached',
					'redis',
					'wincache',
					'xcache'
				),
			'DB\SQL'=>
				array(
					'pdo',
					'pdo_dblib',
					'pdo_mssql',
					'pdo_mysql',
					'pdo_odbc',
					'pdo_pgsql',
					'pdo_sqlite',
					'pdo_sqlsrv'
				),
			'DB\Jig'=>
				array('json'),
			'DB\Mongo'=>
				array(
					'json',
					'mongo'
				),
			'Auth'=>
				array('ldap','pdo'),
			'Bcrypt'=>
				array(
					'openssl'
				),
			'Image'=>
				array('gd'),
			'Lexicon'=>
				array('iconv'),
			'SMTP'=>
				array('openssl'),
			'Web'=>
				array('curl','openssl','simplexml'),
			'Web\Geo'=>
				array('geoip','json'),
			'Web\OpenID'=>
				array('json','simplexml'),
			'Web\OAuth2'=>
				array('json'),
			'Web\Pingback'=>
				array('dom','xmlrpc'),
			'CLI\WS'=>
				array('pcntl')
		);
		$f3->set('classes',$classes);
		$f3->set('content','welcome.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->route('GET /userref',
	function($f3) {
		$f3->set('content','userref.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->run();
