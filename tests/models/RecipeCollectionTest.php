<?php
class RecipeCollectionTest extends PHPUnit_Framework_TestCase {
	
	public function testInstance()
	{
		$this->assertInstanceOf( 'ArrayObject', RecipeCollection::getInstance() );
		
		$this->setExpectedException( 'RuntimeException' );
		new RecipeCollection();
	}
}
?>