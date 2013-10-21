<?php

class SplAutoloader {
	private $fileExtension = '.php';
	private $Namespace;
	private $includePaths;
	private $NamespaceSeparator = '\\';
	
	public function __construct($Namespace = null, $includePath = null) {
		$this->Namespace = $Namespace;
		$this->includePaths = (array) $includePath;
	}
	
	public function setNamespaceSeparator($sep) {
		$this->NamespaceSeparator = $sep;
	}
	
	public function getNamespaceSeparator() {
		return $this->NamespaceSeparator;
	}
	
	public function setIncludePath($includePath) {
		$this->includePaths = (array) $includePath;
	}
	
	public function getIncludePath() {
		return count($this->includePaths) > 1 ? $this->includePaths : reset($this->includePaths);
	}
	
	public function setFileExtension($fileExtension) {
		$this->fileExtension = $fileExtension;
	}
	
	public function getFileExtension() {
		return $this->fileExtension;
	}
	
	public function register() {
		return spl_autoload_register(array(
				$this,
				'loadClass'
		));
	}
	
	public function unregister() {
		return spl_autoload_unregister(array(
				$this,
				'loadClass'
		));
	}
	
	public function loadClass($className) {
		$isFound = false;
		
		if(null === $this->Namespace || $this->Namespace . $this->NamespaceSeparator === substr($className, 0, strlen($this->Namespace . $this->NamespaceSeparator))) {
			
			$fileName = '';
			$namespace = '';
			if(false !== ($lastNsPos = strripos($className, $this->NamespaceSeparator))) {
				
				$namespace = substr($className, 0, $lastNsPos);
				$className = substr($className, $lastNsPos + 1);
				$fileName = str_replace($this->NamespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
			}
			$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . $this->fileExtension;
			
			$includePaths = $this->includePaths ?  : array(
					'.'
			);
			foreach($includePaths as $includePath) {
				$unresolvedFilePath = $fileName;
				$isFound = $this->includeClass($className, $unresolvedFilePath);
				if($isFound) {
					break;
				}
			}
		}
		
		return $isFound;
	}
	
	private function includeClass($className, $unresolvedFilePath) {
		
		$filePath = stream_resolve_include_path($unresolvedFilePath);
		$isFound = false !== $filePath;
		
		if($isFound) {
			require $filePath;
		}
		
		return $isFound;
	}
}