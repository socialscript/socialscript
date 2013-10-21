<?php
/**
 * This file is part of socialscript (c) 2013 Paul Trombitas.
 *
 * socialscript is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * socialscript is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with socialscript.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace lib\PasswordEncryption;

class PasswordEncryption {

	private $Password = FALSE;
	private $Salt = FALSE;
	private $encryptionAlgorithm = FALSE;
	private $availableCryptAlgorithms = array(
			'CRYPT_STD_DES',
			'CRYPT_EXT_DES',
			'CRYPT_MD5',
			'CRYPT_BLOWFISH',
			'CRYPT_SHA256',
			'CRYPT_SHA512'
	);
	private $encryptMethod = 'crypt';
	private $encryptedMethods = array(
			'crypt',
			'hash'
	);

	function __construct() {

	}

	function setPassword($Password) {
		$this->Password = $Password;
		return $this;
	}
	function getPassword() {
		return $this->Password;
	}
	/* used only when recreating user password,at login */
	function setSalt($Salt) {
		$this->Salt = $Salt;
		return $this;
	}
	function getSalt() {
		return $this->Salt;
	}

	function setEncryptMethod($encryptMethod) {
		// if is not available,uses crypt which was initialized default
		if(in_array($encryptMethod, $this->encryptedMethods)) {
			$this->encryptMethod = $encryptMethod;
		}
		return $this;
	}

	function getEncryptMethod() {
		return $this->encryptMethod;
	}

	function setEncryptionAlgorithm($encryptionAlgorithm) {
		$this->encryptionAlgorithm = $encryptionAlgorithm;
		return $this;
	}
	function getEncryptionAlgorithm() {
		return $this->encryptionAlgorithm;
	}

	function Encrypt() {
		$method = $this->encryptMethod . 'Password';
		return self::$method();
	}

	function cryptPassword() {
		// if the crypt algorithm is not available,use blowfish
		if(! in_array($this->encryptionAlgorithm, $this->availableCryptAlgorithms)) {
			$this->encryptionAlgorithm = 'CRYPT_BLOWFISH';
		}
		if($this->Salt === FALSE) {
			self::generateCryptSalt();
		}
		return array(
				'password' => crypt($this->Password, $this->Salt),
				'salt' => $this->Salt
		);
	}

	function hashPassword() {
		// if the hash extension is not loaded,use crypt with blowfish algo
		if(! extension_loaded('hash')) {
			$this->encryptionAlgorithm = 'CRYPT_BLOWFISH';
			self::cryptPassword();
		}
		// checks if the hash algo is available
		if(in_array($this->encryptionAlgorithm, hash_algos())) {
			return array(
					'password' => hash($this->encryptionAlgorithm,$this->Password),
					'salt' => ''
			);
		} 		// if it's not available use sha256
		else {
			return array(
					'password' => hash('sha512',$this->Password),
					'salt' => ''
			);
		}
	}

	function generateCryptSalt() {
		switch ($this->encryptionAlgorithm) {
			case 'CRYPT_STD_DES' :
				$this->saltLength = 2;
				$this->Salt = self::generateRandomAlphabet();
				break;
			case 'CRYPT_EXT_DES' :
				$this->saltLength = 8;
				$this->Salt = '_' . self::generateRandomAlphabet();
				break;
			case 'MD5' :
				$this->saltLength = 12;
				$this->Salt = '$1$' . self::generateRandomChars();
				break;
			case 'CRYPT_BLOWFISH' :
				$this->saltLength = 22;
				$this->Salt = '$2a$07$' . self::generateRandomAlphabet() . '$';
				break;
			case 'CRYPT_SHA256' :
				$this->saltLength = 16;
				$this->Salt = '$5$rounds=5000$' . self::generateRandomAlphabet() . '$';
				break;
			case 'CRYPT_SHA512' :
				$this->saltLength = 16;
				$this->Salt = '$6$rounds=5000$' . self::generateRandomAlphabet() . '$';
				break;
		}
	}

	function generateRandomAlphabet() {
		$this->chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789');
		shuffle($this->chars);
		return implode('', array_slice($this->chars, 0, $this->saltLength));
	}
	function generateRandomChars() {
		$this->chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*(){}"|:<>?');
		shuffle($this->chars);
		return implode('', array_slice($this->chars, 0, $this->saltLength));
	}
	function generateRandomNumbers() {
		$this->chars = str_split('0123456789');
		shuffle($this->chars);
		return implode('', array_slice($this->chars, 0, $this->saltLength));
	}
	function generateRand() {
		return rand($this->min, $this->max);
	}
}

?>