<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

require 'Noder.php';

$xml = new Noder('<root></root>');
var_dump($xml);
var_dump($xml->asXml());

$xml->importString('<a>toto<b>h"h"</b></a>');
var_dump($xml);
var_dump($xml->asXml());



$xml->importNode(new Noder('<foo>bar</foo>'));
var_dump($xml);
var_dump($xml->asXml());

var_dump($xml->foo->asXml());
var_dump($xml->foo->addTextNode('&baz'));
var_dump($xml->foo->asXml());
var_dump($xml->foo->addChild('baz', 'to&to'));
$xml->foo->jo = 'f&rite';
var_dump($xml->foo->asXml());
var_dump($xml->foo);
