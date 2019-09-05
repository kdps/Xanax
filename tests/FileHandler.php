<?php

use PHPUnit\Framework\TestCase;

use Xanax\Classes\FileHandler;
use Xanax\Classes\FileObject;

class FileHandlerTest extends TestCase {
	
	protected $factory;
	
    public function setUp() {
		$this->factory = new FileHandler();
	}
	
	public function testFileCount() {
		try {
			$this->assertSame("testSuccess", $this->factory->readAllContent(__DIR__."/testFile.txt"));
			$this->fail('Calling readAllContent() succeeded immediately');
		} catch (Exception $e) {
			
		}
	}
	
}