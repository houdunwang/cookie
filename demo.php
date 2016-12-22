<?php
require 'vendor/autoload.php';
$obj = new \houdunwang\cookie\Cookie();
//设置密钥
$obj->secureKey('houdunwang.com');
$obj->set('a',33);
