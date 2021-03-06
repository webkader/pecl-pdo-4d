--TEST--
PDO Common: Bug #36428 (Incorrect error message for PDO::fetchAll())
--SKIPIF--
<?php # vim:ft=php
if (!extension_loaded('pdo')) die('skip no PDO');
if (!extension_loaded('pdo_4d')) die('skip no PDO for 4D extension');

require dirname(__FILE__) . '/../../../ext/pdo/tests/pdo_test.inc';
//PDOTest::skip();
?>
--FILE--
<?php
if (getenv('REDIR_TEST_DIR') === false) putenv('REDIR_TEST_DIR='.dirname(__FILE__) . '/../../pdo/tests/'); 
require_once getenv('REDIR_TEST_DIR') . 'pdo_test.inc';

$db = PDOTest::factory();
$db->exec("CREATE TABLE test (a VARCHAR(10))");
$db->exec("INSERT INTO test (a) VALUES ('xyz')");
$res = $db->query("SELECT a FROM test");
var_dump($res->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'SimpleXMLElement', array('<root/>')));

?>
===DONE===
--EXPECTF--
array(1) {
  [0]=>
  object(SimpleXMLElement)#%d (1) {
    ["a"]=>
    string(3) "xyz"
  }
}
===DONE===
