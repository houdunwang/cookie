<?php
require 'vendor/autoload.php';
$config = [
	//cookie加密密钥
	'secureKey' => 'houdunwang88'
];

\houdunwang\config\Config::set( 'cookie', $config );
\houdunwang\cookie\Cookie::set( 'a2', 33 );