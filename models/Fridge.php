<?php
/**
 * Singleton class for the Fridge instance
 * 
 * @author David Ogilo
 */
class Fridge {
	
	private static $_instance;
	private $items;
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	private function __construct()
	{
		$this->items = array();	
	}
	
	/**
	 * Adds an item to the fridge
	 * 
	 * @param Item $item
	 */
	public function addItem( Item $item )
	{
		$name = $item->getName();
		
		//replace previous added item with new instance
		if ( array_key_exists( $name, $this->items ) )
			unset( $this->items[$name] );
		
		$this->items[$name] = $item;
	}
	
	/**
	 * Returns an item from the fridge
	 * 
	 * @param string $name
	 * @return Item|null
	 */
	public function getItem( $name )
	{
		return ( array_key_exists( $name, $this->items ) )? $this->items[$name] : null;
	}
	
	/**
	 * Returns the items collection
	 * 
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}
	
	/**
	 * Import items from a CSV file
	 * 
	 * @param string $file
	 * @return boolean
	 */
	public function importItemsFromCSV( $file )
	{
		if ( !is_file( $file ) || !is_readable( $file ) || ( $handle = fopen( $file, 'r' ) ) === false )
			return false;
		
		$items = array();
		
		while( ( $data = fgetcsv( $handle, 1000 ) ) !== false )
		{
			$data[3] = DateTime::createFromFormat( 'd/m/Y', $data[3] )->getTimestamp();
			
			new Item( $data[0], $data[1], $data[2], $data[3] );
			
			$items[] = $data;
		}
		
		return ( !empty( $items ) );
	}
	
	/**
	 * Clears the items in the Fridge
	 * 
	 * @return void
	 */
	public function clear()
	{
		$this->items = array();
	}
	
	/**
	 * Returns the singleton instance of the class
	 * 
	 * @return Fridge
	 */
	public static function getInstance()
	{
		if ( empty( self::$_instance ) )
			self::$_instance = new Fridge();
		
		return self::$_instance;
	}
} 
?>