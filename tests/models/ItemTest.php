<?php
class ItemTest extends PHPUnit_Framework_TestCase {
	
	public function testItem()
	{
		$item = new Item( 'test test', 5, 'slices', REQUEST_TIME );
		$this->assertInstanceOf( 'Item', $item );
	}
}
?>