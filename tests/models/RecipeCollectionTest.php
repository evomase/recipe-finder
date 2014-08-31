<?php
class RecipeCollectionTest extends PHPUnit_Framework_TestCase {
	
	public function testInstance()
	{
		$this->assertInstanceOf( 'ArrayObject', RecipeCollection::getInstance() );
		
		$this->setExpectedException( 'RuntimeException' );
		new RecipeCollection();
	}
	
	public function testImportFromJSON()
	{
		//load fridge up!
		Fridge::getInstance()->importItemsFromCSV( BASE_PATH . '/tests/files/items.csv' );
		
		$this->assertFalse( RecipeCollection::getInstance()->importFromJSON( __DIR__ ) );
		$this->assertTrue( RecipeCollection::getInstance()->importFromJSON( BASE_PATH . '/tests/files/recipes.json' ) );
		$this->assertNotEquals( 0, RecipeCollection::getInstance()->count() );
	}
	
	/**
	 * @depends testImportFromJSON
	 */
	public function testGetValidRecipe()
	{
		$this->assertNotNull( $recipe = RecipeCollection::getInstance()->getValidRecipe() );
		$this->assertEquals( 'butter on toast', $recipe->getName() );
	}
}
?>