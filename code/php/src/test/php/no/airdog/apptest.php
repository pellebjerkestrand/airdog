<?php
require_once 'PHPUnit/Framework.php';
require_once str_replace('.','/','no.airdog').'/app.php';
class AppTest extends PHPUnit_Framework_TestCase {
    function testDoSomehting() {
    	$app = new App();
        $this->assertEquals('something', $app->doSomething());
    }
}
?>