<?php
require 'vendor/autoload.php';
\houdunwang\cookie\Cookie::key( 'houdunwang' );
//\houdunwang\cookie\Cookie::set( 'a2', 33 );
echo \houdunwang\cookie\Cookie::get('a2');