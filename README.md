This is a simple configuration parser. It will read a test file, and parse each line, making each property available in code

Configuration samples:

# Lines beginning with hashtags are comments and are ignored.

# whitespace lines are also ignored
property_name = value
property_int = 2
property_boolean = yes

property names must be alpha-numeric and are allowed to contain underbar(_) and dash(-) charactes. Values may contain any characters. Leading and trailing whitespace will be trimmed.


Using the Configuration class:
Creating a new instance of the configuration class will load and parse the config file specified

$my_config = new Configuration( 'filename.config' );

Access a specific property:
$property = $my_config->property_name

Get all available properties:
$property_array = $my_config->get_all_properties();

Additional notes:
For security puropses, I recommend keeping the config files somewhere other than the webroot, and change permissions so that it is not writable by the web web user.