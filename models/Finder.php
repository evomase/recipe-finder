<?php
/**
 * Singleton class for the Finder instance
 * 
 * @author David Ogilo
 */
class Finder {
	
	private static $_instance;
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	private function __construct()
	{
		$this->init();
	}
	
	/**
	 * Initiates the program
	 * 
	 * @return void
	 */
	private function init()
	{
		
	}
	
	/**
	 * Returns the Finder instance
	 * 
	 * @return Finder
	 */
	public static function getInstance()
	{
		if ( empty( self::$_instance ) )
			self::$_instance = new Finder();
		
		return self::$_instance;
	}
}
?>