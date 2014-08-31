<?php
class RecipeTest extends PHPUnit_Framework_TestCase {
	
	public function testPopulateItems()
	{
		Fridge::getInstance()->importItemsFromCSV( BASE_PATH . '/tests/files/items.csv' );
		
		$ingredients = array(
			array(
				Item::FIELD_NAME => 'bread',
				Item::FIELD_AMOUNT => 2
			),
			
			array(
				Item::FIELD_NAME => 'cheese',
				Item::FIELD_AMOUNT => 2
			)
		);
		
		$recipe = new Recipe( 'test recipe', $ingredients );
		$this->assertNotEmpty( $recipe->getItems() );
		
		//test for not enough quantity of item
		$ingredients[0][Item::FIELD_AMOUNT] += Fridge::getInstance()->getItem( $ingredients[0][Item::FIELD_NAME] )->getAmount();
		
		$recipe = new Recipe( 'test recipe 2', $ingredients );
		$this->assertEmpty( $recipe->getItems() );
		$this->assertFalse( $recipe->isValid() );
		
		//test for out of date item (mixed salad)
		$ingredients = array(
			array(
				Item::FIELD_NAME => 'bread',
				Item::FIELD_AMOUNT => 2
			),
			
			array(
				Item::FIELD_NAME => 'mixed salad',
				Item::FIELD_AMOUNT => 200
			)
		);
		
		$recipe = new Recipe( 'test recipe 3', $ingredients );
		$this->assertFalse( $recipe->isValid() );
	}
}
?>