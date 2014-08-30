<?php 
class FridgeTest extends PHPUnit_Framework_TestCase {
	
	public function testGetItems()
	{
		new Item( 'fridge test', 1, ItemUnit::SLICES, REQUEST_TIME );
		$this->assertNotEmpty( Fridge::getInstance()->getItems() );
	}
	
	public function testClear()
	{
		Fridge::getInstance()->clear();
		$this->assertEmpty( Fridge::getInstance()->getItems() );
	}
	
	public function testImportItemsFromCSV()
	{
		$file = BASE_PATH . '/tests/files/items.csv';
		
		$this->assertFalse( Fridge::getInstance()->importItemsFromCSV( __DIR__ ) );
		$this->assertTrue( Fridge::getInstance()->importItemsFromCSV( $file ) );
		$this->assertCount( 5, Fridge::getInstance()->getItems() );
	}
}
?>