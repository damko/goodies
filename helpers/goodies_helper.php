<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//TODO this helper should go into a spark


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
function startsWith($haystack, $needle)
{
	if(!is_string($haystack) || empty($haystack)) return false;
	if(!is_string($needle) || empty($needle)) return false;
	
	return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle)
{
	if(!is_string($haystack) || empty($haystack)) return false;
	if(!is_string($needle) || empty($needle)) return false;
	
	$length = strlen($needle);

	return (substr($haystack, -$length) === $needle);
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
function isAssociativeArray(array $arr) {
	return (bool)count(array_filter(array_keys($arr), 'is_string'));
}

/**
 * This works like "in_array" but it's case insensitive. 
 * It will return a match if the needle is found in the haystack
 *
 * @access		public
 * @param		$needle String
 * @param		$haystack Array
 * @return		boolean
 *
 * @author 		Damiano Venturin
 * @since		Jun 22, 2012
 */
function in_arrayi($needle, array $haystack) {
	$needle = strtolower($needle);

	$haystack_flipped = array_flip($haystack);
	$haystack_flipped_lower = array_change_key_case($haystack_flipped);
	$haystack = array_flip($haystack_flipped_lower);

	return in_array($needle, $haystack);
}

/**
 * Returns a random string
 *
 * @access		public
 * @param		none
 * @return		string
 * @example
 * @see
 *
 * @author 		Damiano Venturin
 * @copyright 	2V S.r.l.
 * @license		GPL
 * @link		http://www.squadrainformatica.com/en/development#mcbsb  MCB-SB official page
 * @since		Sep 24, 2012
 *
 */
function rand_string( $length ) {

	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = '';

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}

function only_chars_nums_underscore($string)
{
	if(is_array($string)) return false;
	$string = preg_replace('/ /', '_', trim($string));
	$string = preg_replace('/[^A-Za-z0-9-_]/', '', $string);
	return $string;
}

function only_chars_nums_underscore_plus($string)
{
	if(is_array($string)) return false;
	$string = preg_replace('/ /', '_', trim($string));
	$string = preg_replace('/[^A-Za-z0-9-_+]/', '', $string);
	return $string;
}

function amend_file($source_dir, $source_file, $needle, $replace) {

	if(!is_dir($source_dir)) return false;

	$source = $source_dir.$source_file;

	if(!is_file($source)) return false;

	$target = $source_dir.'this_is_something_temporary.txt';

	// copy operation
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

	// delete old source file
	unlink($source);

	// rename target file to source file
	rename($target, $source);

	return true;
}


function chmodr($path, $filemode) { 
    if (!is_dir($path)) 
        return chmod($path, $filemode); 

    $dh = opendir($path); 
    while (($file = readdir($dh)) !== false) { 
        if($file != '.' && $file != '..') { 
            $fullpath = $path.'/'.$file; 
            if(is_link($fullpath)) 
                return false; 
            elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode)) 
                    return false; 
            elseif(!chmodr($fullpath, $filemode)) 
                return false; 
        } 
    } 

    closedir($dh); 

    return chmod($path, $filemode) ? true : false; 
}

function copy_directory( $source, $destination, $first_remove_destination = false ) {
	
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

function remove_dir($dir) {
	
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