<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Checks if the string starts with the given character or group of characters
 *
 * @access		public
 * @param		string $haystack
 * @param		string $needle
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jan 24, 2013
 */
if(!function_exists('starts_with')){
	
	function starts_with($haystack, $needle)
	{
		if(!is_string($haystack) || empty($haystack)) return false;
		if(!is_string($needle) || empty($needle)) return false;
		
		return !strncmp($haystack, $needle, strlen($needle));
	}
	
}




/**
 * Checks if the string ends with the given character or group of characters
 *
 * @access		public
 * @param		string $haystack
 * @param		string $needle
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jan 24, 2013
 */
if(!function_exists('ends_with')){
	
	function ends_with($haystack, $needle)
	{
		if(!is_string($haystack) || empty($haystack)) return false;
		if(!is_string($needle) || empty($needle)) return false;
		
		$length = strlen($needle);
	
		return (substr($haystack, -$length) === $needle);
	}
	
}




/**
 * Parses a string containing a comma-separated list into an array
 *
 * @access		public
 * @param		string $string
 * @return		array
 *
 * @author 		Oskari Groenroos
 * @since		Jan 24, 2013
 */
if(!function_exists('parse_comma_separated')){
 	
	function parse_comma_separated($string)
	{
		// make sure to catch all possible delimiters
		$delimiters = array(":", ";", "|", "&", "and");
		$string = str_replace($delimiters, ',', $string);
	    
		// create the array
		$items = explode(',', $string);
	    
		if(count($items) > 1) {
			// if we have matches, let's clean them up
			$items = array_map('trim', $items);
		} else {
			// if we had no matches, let's try separating by spaces as a last resort
			$items[0] = preg_replace('!\s+!', ' ', $items[0]);
			$items = explode(' ', $items[0]);
		}
		
		return $items;
	}
	
}




/**
 * Formats a integer bytesize into a human-readable filesize string
 *
 * @access		public
 * @param		int $bytes
 * @return		string
 *
 * @author 		Oskari Groenroos
 * @since		Jan 24, 2013
 */
if(!function_exists('format_filesize')){
	
	function format_fileize($bytes)
	{
		$types = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
		for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
		return( round( $bytes, 2 ) . " " . $types[$i] );
	}
	
}




/**
 * Checks if a string is of the given encoding. Defaults to checking for UTF-8
 *
 * @access		public
 * @param		string $string
 * @param		string $encoding
 * @return		boolean
 *
 * @author 		Oskari Groenroos
 * @since		Jan 24, 2013
 */
if(!function_exists('string_is_encoding')){
	
	function string_is_encoding($string, $encoding = 'utf-8') {
		$sample = iconv($encoding, $encoding, $string);
		
		if (md5($sample) == md5($string))
			return true;
		
		return false;
	}

}




/**
 * Semi-intelligently shortens a string with an ellipsis. Specify either a word limit or a
 * character limit. Defaults to 25 words.
 *
 * @access		public
 * @param		string $string
 * @param		int $word_length
 * @param		int $char_length
 * @return		string
 *
 * @author 		Oskari Groenroos
 * @since		Jan 24, 2013
 */
if(!function_exists('make_excerpt')){
	
	function make_excerpt($string, $word_length = 25, $char_length = 0) {
		
		// if no character length is specified, we'll go for word length
		if($char_length == 0 || $char_length == null) {
			$words = explode(" ", $string);
			$words = array_slice($words, 0, $word_length);
			$string = implode(" ", $words);
		} else {
			$string = substr($string, 0, $char_length);
		}
		
		// get rid of any possible gubbins at the end
		$string = rtrim($string, "\x00..\x1F");
		$string = rtrim($string, " .,;:-‒–—―!?/&#");
		
		return $string."...";
	}

}




/**
 * Tries to guess if a given array is associative.
 *
 * @access		public
 * @param		$arr Array
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Oct 20, 2011
 */
if(!function_exists('is_associative_array')){
	
	function is_associative_array(array $arr) {
		
		if(!is_array($arr) || count($arr)==0) return false;
		
		return (bool)count(array_filter(array_keys($arr), 'is_string'));
	}
	
}





/**
 * This works like "in_array" but it's case insensitive. 
 * It will return a match if the needle is found in the haystack
 *
 * @access		public
 * @param		string $needle
 * @param		array  $haystack
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
if(!function_exists('in_arrayi')){

	function in_arrayi($needle, array $haystack) {
		
		if(!is_string($needle) || empty($needle)) return false;
		if(!is_array($haystack) || count($haystack)==0) return false;
		
		$needle = strtolower($needle);
	
		$haystack_flipped = array_flip($haystack);
		$haystack_flipped_lower = array_change_key_case($haystack_flipped);
		$haystack = array_flip($haystack_flipped_lower);
	
		return in_array($needle, $haystack);
	}
	
}




/**
 * Returns a random alphanumeric string long as the given length
 *
 * @access		public
 * @param		string $length
 * @return		false on error or string
 *
 * @author 		Damiano Venturin
 * @since		Sep 24, 2012
 */
if(!function_exists('rand_string')){
	
	function rand_string( $length ) {
	
		if(!is_string($length) || empty($length) || $lenght === '0') return false;
		
		//TODO check if $lenght is an integer
		
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = '';
	
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
	
		return $str;
	}
	
}


/**
 * Pretty dumb function which returns the given string without the not alphanumeric characters
 *
 * @access		public
 * @param		string $string
 * @return		string
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
if(!function_exists('only_alphanum')){
	
	function only_alphanum($string)
	{
		if(!is_string($string) || empty($string)) return $string;
		
		$string = preg_replace('/ /', '_', trim($string));
		$string = preg_replace('/[^A-Za-z0-9]/', '', $string);
		return $string;
	}
	
}

/**
 * Pretty dumb function which returns the given string without the not alphanumeric characters 
 * beside dash and underscore
 *
 * @access		public
 * @param		string $string
 * @return		string
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
if(!function_exists('only_alphanum_dash_underscore')){
	
	function only_alphanum_dash_underscore($string)
	{
		if(!is_string($string) || empty($string)) return $string;
		
		$string = preg_replace('/ /', '_', trim($string));
		$string = preg_replace('/[^A-Za-z0-9-_]/', '', $string);
		return $string;
	}
}

/**
 * Pretty dumb function which returns the given string without the not alphanumeric characters
 * beside dash and underscore
 *
 * @access		public
 * @param		string $string
 * @return		string
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
if(!function_exists('only_alphanum_dash_underscore_plus')){
	
	function only_alphanum_dash_underscore_plus($string)
	{
		if(!is_string($string) || empty($string)) return $string;
		
		$string = preg_replace('/ /', '_', trim($string));
		$string = preg_replace('/[^A-Za-z0-9-_+]/', '', $string);
		return $string;
	}
	
}







/**
 * Looks into a file ($source_dir.$source_file) and replaces the lines matching 
 * the needle with the given text ($replace).
 * 
 * Note: it will replace the WHOLE lines which contains the text not only the matching part.
 * 
 * It's useful to reconfigure configuration files
 *
 * @access		public
 * @param		string $source_dir
 * @param		string $source_file
 * @param		string $needle
 * @param		string $replace
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
if(!function_exists('amend_file')){

	function amend_file($source_dir, $source_file, $needle, $replace) {
	
		//checks
		if(!is_string($source_dir) || empty($source_dir)) return $false;
		if(!is_string($source_file) || empty($source_file)) return $false;
		if(!is_string($needle) || empty($needle)) return $false;
		if(!is_string($replace) || empty($replace)) return $false;
		
		if(!ends_with($source_dir,'/')) $source_dir .= '/';
		
		if(!is_dir($source_dir)) return false;
	
		//TODO check if the folder is writable
		
		$source = $source_dir.$source_file;
	
		if(!is_file($source)) return false;
	
		$target = $source_dir.'this_is_something_temporary.txt';
	
		//copies the original file on the temporary one replacing matches
		$sh=fopen($source, 'r');
		$th=fopen($target, 'w');
		while (!feof($sh)) {
			$line=fgets($sh);
			if (strpos($line, $needle) !== false) {
				$line = $replace . PHP_EOL;
			}
			fwrite($th, $line);
		}
		fclose($sh);
		fclose($th);
	
		//deletes old source file
		unlink($source);
	
		//renames the amended file with the name of the original one
		return rename($target, $source);
	}

}





/**
 * Applies new rights to a file or, recursively, to a directory
 *
 * @access		public
 * @param		string $path
 * @param		string $filemode 
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
if(!function_exists('chmodr')){
	
	function chmodr($path, $filemode) { 
	    
		//checks
		if(!is_string($path) || empty($path)) return $false;
		if(!is_string($filemode) || empty($filemode)) return $false;
		if (!is_dir($path)) return chmod($path, $filemode); 
	
	    $dh = opendir($path);
	     
	    while (($file = readdir($dh)) !== false) { 
	    	
	        if($file != '.' && $file != '..') { 
	            
	        	$fullpath = $path.'/'.$file; 
	            
				if(is_link($fullpath)) return false; 
				
				if(!is_dir($fullpath) && !chmod($fullpath, $filemode)) return false; 
				
				if(!chmodr($fullpath, $filemode)) return false;
				 
	        } 
	    } 
	
	    closedir($dh); 
	
	    return chmod($path, $filemode) ? true : false; 
	}
}



/**
 * Clones a directory and all its content from one position to another.
 * It copies also symlinks.
 *
 * @access		public
 * @param		string $source
 * @param		string $destination
 * @param		boolean $first_remove_destination
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
if(!function_exists('copy_directory')){
	
	function copy_directory($source, $destination, $first_remove_destination = false ) {
		
		if(!is_string($source) || empty($source)) return $false;
		if(!is_string($destination) || empty($destination)) return $false;
		
		if($first_remove_destination) {
			
			if(is_dir($destination)) {
				if(!remove_dir($destination)) return false;
			}
			
			if(is_file($destination)) {
				if(!unlink($destination)) return false;
			}
		}
		
		$links = array();
		
		if ( is_dir( $source ) ) {
			
			//creates destination if it doesn't exist
			if(!is_dir($destination)) {
				if (! @mkdir( $destination )) return false;
			}
			
			if(!is_writable($destination)) return false;
			
			//loops into the directory creating every subfolder and copying every element found
			$directory = dir( $source );
			
			
			while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
				
				if ( $readdirectory == '.' || $readdirectory == '..' ) {
					continue;
				}
				
				$PathDir = $source . '/' . $readdirectory;
				
				//if it's a directory cycles all its content but not if it's a link
				if ( is_dir( $PathDir ) && !is_link ($PathDir)) {
					copy_directory( $PathDir, $destination . '/' . $readdirectory );
					continue;
				}
				
				if(is_link ($PathDir)) {
					$pieces = explode('/', $PathDir);
					$last = array_pop($pieces);
					$link_name = $destination.'/'.$last;
					$links[] = array(
									'name' => $link_name,
									'target' => readlink($PathDir),
								);
				} else {
					if(!copy( $PathDir, $destination . '/' . $readdirectory )) return false;
				}
			}
	
			$directory->close();
			
		} else {
	
			if(is_link ($PathDir)) {
				$pieces = explode('/', $PathDir);
				$last = array_pop($pieces);
				$link_name = $destination.'/'.$last;
				$links[] = array(
						'name' => $link_name,
						'target' => readlink($PathDir),
				);
			} else {
				if(!copy( $source, $destination )) return false;
			}
		}
		
		//creates collected links
		foreach ($links as $link) {
	
			if(!symlink($link['target'] , $link['name'])) return false;
			
		}
			
		return true;
	}
}





/**
 * Removes a directory and all its content if present.
 * If $dir is a file instead of a directory it gets deleted.
 *
 * @access		public
 * @param		string $dir
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
function remove_dir($dir) {
	
	//checks
	if(!is_string($dir) || empty($dir)) return $false;
	if (!is_dir($dir) || is_link($dir)) return unlink($dir);
	
	foreach (scandir($dir) as $file) {
		
		if ($file == '.' || $file == '..') continue;
		
		if (!remove_dir($dir.'/'.$file)) {
			
			chmod($dir.'/'.$file, 0777);
			
			if (!remove_dir($dir.'/'.$file)) return false;
			
		};
	}
	return rmdir($dir);
}

/* End of file domagic_helper.php */
/* Location: ./application/helpers/domagic_helper.php */
