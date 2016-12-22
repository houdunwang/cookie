<?php
require 'vendor/autoload.php';
$obj = new \houdunwang\cookie\Cookie();
$obj->bootstrap('houdunwang.com');
$obj->set('a',33);
