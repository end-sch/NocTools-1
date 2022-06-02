<?php

include('../libs/ClassLoader.php');

$loader = new \Composer\Autoload\ClassLoader();
$loader->addPsr4('phpseclib\\', '../libs/phpseclib-2.0.21');
$loader->register();

use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;

$ssh_bng_a = new SSH2('192.168.109.33');
if (!$ssh_bng_a->login('username', 'password')) {
    exit('Login Failed');
}

$ssh_bng_b = new SSH2('192.168.109.46');
if (!$ssh_bng_b->login('username', 'password')) {
    exit('Login Failed');
}


?>