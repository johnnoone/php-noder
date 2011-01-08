<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

require 'Noder.php';

$xml = new Noder('<root></root>');
echo $xml->asXml();
/*  <?xml version="1.0"?>
    <root/>
*/

$xml->importString('<a>123<b>456</b></a>');
echo $xml->asXml();
/*  <?xml version="1.0"?>
    <root><a>123<b>456</b></a></root>
*/

$xml->importNode(new Noder('<foo>bar</foo>'));
echo $xml->asXml();
/*  <?xml version="1.0"?>
    <root><a>123<b>456</b></a><foo>bar</foo></root>
*/

$xml->foo->addTextNode('&baz');
$xml->foo->asXml();
$xml->foo->addChild('baz', 'to&to');
$xml->foo->jo = 'f&rite';
echo $xml->foo->asXml();
/*  <foo>bar&amp;baz<baz>to&amp;to</baz><jo>f&amp;rite</jo></foo>
*/

echo $xml->foo->baz->parent()->parent()->asXml();
/*  <?xml version="1.0"?>
    <root><a>123<b>456</b></a><foo>bar&amp;baz<baz>to&amp;to</baz><jo>f&amp;rite</jo></foo></root>
*/

$foo = $xml->first('foo');
echo $foo;
/*  bar&baz
*/
echo $foo->asXml();
/*  <foo>bar&amp;baz<baz>to&amp;to</baz><jo>f&amp;rite</jo></foo>
*/