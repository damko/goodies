# CodeIgniter Goodies

It's a very simple collection of functions. Some of them were found in internet and adjusted, some are written by me. 

## Download

https://github.com/damko/goodies

## Usage

	$this->load->spark('goodies/0.0.1');

When loading the spark it autoloads the helpers so there is no need to load them manually.
After loading the spark you can simply call any of the functions included in the helpers.

## Example

	$this->load->spark('goodies/0.0.1');
	
	$arr = array("breed" => "dog");
	
	if(is_associative_array($arr)) {
		//do something		
	}