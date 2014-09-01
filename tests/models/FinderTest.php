<?php 
class FinderTest extends PHPUnit_Framework_TestCase {
	
	public function testStart()
	{
		$options = $_options = array(
			Finder::OPTION_RECIPES => BASE_PATH . '/tests/files/recipes.json',
			Finder::OPTION_FRIDGE => BASE_PATH . '/tests/files/items.csv'
		);
		
		$this->expectOutputRegex( '/Please provide the files/i' );
		Finder::getInstance()->start();
		
		//test for invalid fridge csv file
		$_options[Finder::OPTION_FRIDGE] = null;
		Finder::getInstance()->setOptions( $_options );
		
		$this->expectOutputRegex( '/a valid fridge/i' );
		Finder::getInstance()->start();
		
		//test for invalid recipes json file
		$_options = $option;
		$_options[Finder::OPTION_RECIPES] = null;
		Finder::getInstance()->setOptions( $_options );
		
		$this->expectOutputRegex( '/a valid recipes/i' );
		Finder::getInstance()->start();
		
		//test return of valid recipe
		Finder::getInstance()->setOptions( $options );
		$this->expectOutputRegex( '/^((?!Order Takeout).)*$/i' );
		Finder::getInstance()->start();
		
		//test no recipe found
		$_options = $options;
		$_options[Finder::OPTION_FRIDGE] = BASE_PATH . '/tests/files/items_expired.csv';
		Finder::getInstance()->setOptions( $_options );
		
		$this->expectOutputRegex( '/Order Takeout/i' );
		Finder::getInstance()->start();
	}
}
?>