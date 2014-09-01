<?php
/**
 * Singleton class for the Finder instance
 * 
 * @author David Ogilo
 */
class Finder {
	const MESSAGE_ERROR = 0;
	const MESSAGE_NOTICE = 1;
	
	const OPTION_FRIDGE = 'fridge';
	const OPTION_RECIPES = 'recipes';
	
	private static $_instance;
	private $options;
	private $terminalColumns;
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	private function __construct()
	{
		$this->options = getopt( '', array(
			self::OPTION_FRIDGE . ':',
			self::OPTION_RECIPES . ':'
		) );
		
		$this->terminalColumns = ( strtoupper( substr( PHP_OS, 0, 3 ) ) !== 'WIN' )? exec( 'tput cols' ) : null;
	}
	
	/**
	 * Starts the program
	 * 
	 * @return void
	 */
	public function start()
	{
		if ( !$this->options )
			return $this->printf( 'Please provide the files using the options --fridge and --recipes', self::MESSAGE_ERROR );
		
		if ( empty( $this->options[self::OPTION_FRIDGE] ) || !Fridge::getInstance()->importItemsFromCSV( $this->options[self::OPTION_FRIDGE] ) )
			return $this->printf( 'Please provide a valid fridge CSV file', self::MESSAGE_ERROR );
		
		if ( empty( $this->options[self::OPTION_RECIPES] ) || !RecipeCollection::getInstance()->importFromJSON( $this->options[self::OPTION_RECIPES] ) )
			return $this->printf( 'Please provide a valid recipes CSV file', self::MESSAGE_ERROR );
		
		return $this->printf( ( $recipe = RecipeCollection::getInstance()->getValidRecipe() )? $recipe->getName() : 'Order Takeout', self::MESSAGE_NOTICE );
	}
	
	/**
	 * Sets the CLI options
	 * 
	 * @param array $options
	 * @return void
	 */
	public function setOptions( Array $options )
	{
		$this->options = $options;
	}
	
	/**
	 * Prints message to stdout
	 * 
	 * @param string $message
	 * @param string $status
	 * @return void
	 */
	private function printf( $message, $status = self::MESSAGE_NOTICE )
	{
		$colors = array( 
			'red' => "\033[1;31m%s\033[0m",
			'green' => "\033[1;32m%s\033[0m"
		);
		
		switch( $status )
		{
			case self::MESSAGE_ERROR:
				$color = 'red';
				$status = '[error]';
				break;
				
			default:
				$color = 'green';
				$status = '[notice]';
				break;
		}
		
		$_status = sprintf( $colors[$color], $status );
		
		if ( $this->terminalColumns )
		{
			$columns = ( $this->terminalColumns - strlen( $message ) ) + strlen( $status );
			$message .= sprintf( "%" . $columns . "s", $_status );
		}
		else //@codeCoverageIgnoreStart
			$message .= ' ' . $_status;
		//@codeCoverageIgnoreEnd
		
		print $message . PHP_EOL;
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