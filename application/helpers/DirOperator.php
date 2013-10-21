<?php

namespace helpers;

/**
 *
 * @author Richard Hayes <richard_c_hayes@yahoo.co.uk> (and special thanks to
 *         Igor Storozhev)
 * @version 1.5
 *         
 *          Class DirOperator used to read, write and delete directories.
 *         
 *          <b>Current functionality</b> includes reading, writing, creating and
 *          deleting of directories.
 *          Regular expressions can be used for file/directory inclusion and
 *          exclusion.
 *         
 */
class DirOperator {
	/**
	 *
	 * @var array contents of directories
	 * @access private
	 */
	var $contents = array();
	
	/**
	 *
	 * @var string error messages
	 * @access private
	 */
	var $error;
	
	/**
	 *
	 * @var boolean Whether to display directories with output
	 * @access private
	 */
	var $showDir = false;
	
	/**
	 *
	 * @var boolean Whether to scan subdirectories
	 * @access private
	 */
	var $sub = false;
	
	/**
	 *
	 * @access public
	 * @return s void
	 */
	function DirOperator() {
	}
	
	/**
	 * Resets object to default values
	 *
	 * @access public
	 * @return s void
	 */
	function reset() {
		$this->contents = array();
		$this->message = array();
		$this->sub = false;
		$this->showDir = false;
	}
	
	/**
	 * Returns directory contents
	 *
	 * @access public
	 * @return s array
	 */
	function getContents() {
		return $this->contents;
	}
	
	/**
	 * Scan directories for files.
	 *
	 * @param string $path
	 *        	location of directory
	 * @param string $inc
	 *        	reg-ex used for types of files to display.
	 * @param string $exclude
	 *        	reg-ex used for files and directories not to include with
	 *        	output
	 * @access private
	 * @return s boolean
	 */
	function scan($path, $exclude = array()) {
		$dp = @dir($path);
		if(! $dp) {
			$this->message[] = "Couldn't open directory $path";
			return false;
		}
		
		$it = new RecursiveDirectoryIterator($path);
		$excludelude_count = count($exclude);
		
		foreach(new \RecursiveIteratorIterator($it) as $file) {
			if(! $it->isDot()) {
				if($excludelude_count > 0) {
					if(! in_array(end(explode('.', $file->fileName)), $exclude)) {
						$this->contents[] = $file;
					}
				} else 

				{
					$this->contents[] = $file;
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Return files from directories.
	 *
	 * If variables: $inc or $exclude are set they need to be enclosed in
	 * "double"
	 * quotes.
	 * When $inc or $exclude are not set All files/directories will be included
	 * with
	 * output.
	 * Example -
	 * <code>
	 * $dir = new DirOperator();
	 * $dir -> output('./', "(htm|html|gif)\$",
	 * "(.htaccess|phpMyAdmin|nude.jpeg)"));
	 * </code>
	 * The above code would only output .htm, .html and .gif files and
	 * .htaccess, nude.jpeg (files)
	 * and phpMyAdmin directory would be ignored. If you are not familiar with
	 * regular-expressions, please take
	 * note of the syntax (|\$)
	 *
	 * @param string $path
	 *        	location of directory
	 * @param string $inc
	 *        	reg-ex used for types of files to display.
	 * @param string $exclude
	 *        	reg-ex used for files and directories not to include with
	 *        	output
	 * @access public
	 * @return s mixed
	 */
	function output($path, $exclude = array()) {
		if($this->scan($path, $exclude)) {
			return $this->contents;
		} else {
			return '';
		}
	}
	
	/**
	 * Include subdirectories to scan
	 *
	 * @access public
	 * @return s void
	 */
	function setSubDir() {
		$this->sub = true;
	}
	
	/**
	 * Exclude subdirectories to scan
	 *
	 * @access public
	 * @return s void
	 */
	function unsetSubDir() {
		$this->sub = false;
	}
	
	/**
	 * Display directories with output
	 *
	 * @access public
	 * @return s void
	 */
	function showDir() {
		$this->showDir = true;
	}
	
	/**
	 * Hide directories from output
	 *
	 * @access public
	 * @return s void
	 */
	function hideDir() {
		$this->showDir = false;
	}
	
	/**
	 * Create a directory
	 *
	 * @param string $path
	 *        	directory/path/name
	 * @param int $perm
	 *        	directory permissions
	 * @access public
	 * @return s boolean
	 */
	function create($path, $perm = 0777) {
		if(is_dir($path)) {
			$this->error .= "Directory $path already exists";
			p($this->error);
			return false;
		}
		
		$old_umask = umask(0);
		
		if(! mkdir($path, $perm)) {
			$this->error .= "Couldn't create directory $path with permission $perm ";
			p($this->error);
			return false;
		}
		
		umask($old_umask);
		
		return true;
	}
	
	/**
	 * Deletes a directory
	 *
	 * @param string $path
	 *        	directory/path/name
	 * @access public
	 * @return s boolean
	 */
	function delete($path) {
		if(! @rmdir($path)) {
			$this->message[] = "Couldn't delete directory $path ";
			return false;
		}
		return true;
	}
	function deleteFile($path) {
		if(file_exists($path)) {
			if(! @unlink($path)) {
				
				$this->message[] = 'Could not delete file ' . $path;
			} else {
				return true;
			}
		} else {
			$this->message[] = 'File ' . $path . ' doesn"t exist';
		}
	}
	function rename($oldName, $newName) {
		if(rename($oldName, $newName)) {
			return TRUE;
		} else {
			$this->message[] = 'Could not rename  ' . $path;
		}
	}
	function isWritable($path) {
		if(! is_writable($path)) {
			$this->message[] = $path . ' is not writable';
		} else {
			$this->message[] = $path . ' is  writable';
		}
	}
	function isReadable($path) {
		if(! is_readable($path)) {
			$this->message[] = $path . ' is not readable';
		} else {
			$this->message[] = $path . ' is  readable';
		}
	}
	function changePermissions($path, $perm = 0777) {
		if(! chmod($path, $perm)) {
			$this->message[] = ' permissions could not be set to ' . $perm;
		} else {
			$this->message[] = ' permissions succesfully set to ' . $perm;
		}
	}
	function getOwner($path) {
		if(fileowner($path)) {
			
			print '<br />' . fileowner($path) . '<br />';
			print_r(posix_getpwuid(fileowner($filename)));
		} else {
			return FALSE;
		}
	}
	function getPermissions($path) {
		if(fileperms($path)) {
			$this->message[] = substr(sprintf('%o', fileperms($path), - 4));
		} else {
			return FALSE;
		}
	}
	function getStat($path) {
		if(stat($path)) {
			$this->message[] = stat($path);
		} else {
			return FALSE;
		}
	}
	function getModificationTime($path) {
		if(filemtime($path)) {
			$this->message[] = filemtime($path);
		} else {
			return FALSE;
		}
	}
	function getGroup($path) {
		if(filegroup($path)) {
			print_r(posix_getgrgid(filegroup($filename)));
		} else {
			return FALSE;
		}
	}
	function renameFileUnix($path, $path_dir = FALSE) {
		if(ctype_alnum($path) == FALSE) {
			
			$path_without_dir = str_replace($path_dir, '', $path);
			$path_2 = preg_replace('/[^a-zA-Z0-9\s\/\.\-\_]/', '', $path_without_dir);
			$path_2 = str_replace(' ', '_', $path_2);
			$path_2 = strtolower($path_2);
			$new_path = $path_dir . $path_2;
			self::rename($path, $new_path);
			return $new_path;
		}
	}
	function status() {
		if(count($this->message) < 1) {
			return 'Success';
		} else {
			return $this->message;
		}
	}
}
?>