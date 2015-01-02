<?php
class Configuration
{
	private $_data = array();//
	
	public function __construct( $filename = "settings.config" )
	{
		$fp = @fopen($filename, "r");
		if( $fp === FALSE ) //if we could not open the file cause a fatal erro
		{
			 trigger_error('Could not load configuration file "' . $filename . '"', E_USER_ERROR);
		}
		$line_number = 0;
		while( ( $line = fgets( $fp )) !== FALSE )
		{
			$line_number++;
			$this->_process_line( $line, $line_number );		
		}
	}
	
	public function __get( $key )
	{
		//echo 'trying to get value '.$key;
		if( array_key_exists( $key, $this->_data))
		{
			return $this->_data[$key];
		}
		else
		{
			trigger_error('Setting "'.$key.'" does not exist.', E_USER_WARNING);
			return null;
		}
	}
	
	public function get_all_settings()
	{
		return $this->_data;
	}
	
	private function _process_line( $line, $line_number )
	{
		//trim leading and trailing whitespace
		$line = trim( $line );
		
		//ignore comments and blank lines
		//if a line starts with a # then it is a comment,
		//assume that # is a valid value within a config line
		if( $line !== '' && strpos( $line, '#' ) !== 0 )
		{
			/**
			 * find the setting name and value we will expect the configuration
			 *  line to be in the format of setting_name=setting_value. 
			 *  The setting name we will allow any aplha-numeric character, "_"
			 *   and "-".
			 **/   
			$matches = array();
			if(( $found_match = preg_match( '/^([\w\-]+)\s*=(.+)$/', $line, $matches )) == 1 && sizeof( $matches ) == 3)
			{
				//remove any extra whitespace at the beginning or end of the line or around '='
				$key = trim( $matches[1] );
				$value = trim( $matches[2] );
				
				//values are all read in as strings
				//convert them to the proper data types
				if( is_numeric( $value )) //is numeric will match strings which contain only numeric values
				{
					//php is nice and will automatically cast to the right data type if we
					//try to add something to it. 
					$value = 0 + $value;
					
					/**
					 * If php did not provide that nice shot cut we would need to
					 * cast the value directly. Since we need to differentiate between
					 * floats and int, we'll cast to an int first and compare the value
					 * with the original string. Casting a float will round the number,
					 * so it will evaluate as false. If it is false, we know it is a float
					 * otherwse we can safely cast as an int. Other languages my have
					 * different ways of doing this.
					if( $value == (int)$value )
					{
						$value = (int)$value;
					}
					else 
					{
						$value = (float)$value; //PHP floats and doubles are the same
					}*/
						
				}
				// check for boolean values. 'True, yes, on' should all evaluate to TRUE
				elseif( preg_match('/^yes|on|true$/i', $value) == 1 )
				{
					$value = TRUE;
				}
				// false, no, off should all become FALSE
				elseif( preg_match('/^no|off|false$/i', $value) == 1 )
				{
					$value = FALSE;
				}
				$this->_data[$key] = $value;
			} 
			else 
			{
				trigger_error( 'Configuration line ' . $line_number . ': "' . $line.
					'" Is improperly formatted, and will be ignored',
					E_USER_NOTICE
				);
			}
		}
	}
}