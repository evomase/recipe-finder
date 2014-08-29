<?php 
class Finder {
	
	private static $_instance;
	
	private function __construct()
	{
		$this->init();
	}
	
	private function init()
	{
		
	}
	
	public static function getInstance()
	{
		if ( empty( self::$_instance ) )
			self::$_instance = new Finder();
		
		return self::$_instance;
	}
}
?>