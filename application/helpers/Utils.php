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

namespace helpers;

class Utils {
	function chunk_string_words($string, $characters_limit) {
		$string_chunked = array();
		// If text is > $characters_limit, add a space after each
		// $characters_limit characters
		if(strlen($string) > $characters_limit) {
			// splits the string by space character
			$token = strtok($string, " ");
			while ( $token !== FALSE ) {
				// if token has a lenght greater than limit
				if(strlen($token) > $characters_limit) {
					// split the token at $characters_limit characters by space
					// character
					$string_chunked[] = chunk_split($token, $characters_limit, '<br />');
				} else {
					$string_chunked[] = $token;
				}
				$token = strtok(" ");
			}
			$string_chunked = implode(' ', $string_chunked);
		} else {
			$string_chunked = $string;
		}

		return $string_chunked;
	}

	static function limit_text($text,$limit,$append='...')
	{
		if(strlen($text) > $limit)
		{
			return substr($text,0,$limit) . '...';
		}
		else
		{
			return $text;
		}
	}


	static function getEncryptionAlgorithm() {
		if(extension_loaded('hash')) {
			if(in_array('sha256', hash_algos())) {
				return 'sha256';
			} else {
				return 'md5';
			}
		} else {
			return 'md5';
		}
	}
	function getTodayDate() {
		return date('Y-m-d');
	}

		static function getFileSize($file) {
		$fileSize = filesize($file);
		switch ($fileSize) {
			case ($fileSize < 1024) :
				return $fileSize . ' Bit';
			case ($fileSize > 1024 && $fileSize < 1048576) :
				return round($fileSize / 1024, 1) . ' Kb';
			case ($fileSize > 1048576 && $fileSize < 1073741824) :
				return round($fileSize / 1048576, 1) . ' Mb';
			case ($fileSize > 1073741824 && $fileSize < 1099511627776) :
				return round($fileSize / 1073741824, 1) . ' Gb';
			case ($fileSize > 1099511627776 && $fileSize < 1125899906842624) :
				return round($fileSize / 1099511627776, 1) . ' TB';
			case ($fileSize > 1125899906842624) :
				return round($fileSize / 1125899906842624, 1) . ' PB';
			default :
				return $fileSize;
		}
	}
	function getTodayDateTime() {
		return date('Y-m-d H:i:s');
	}
	function dateStrToTime($date) {
		return strtotime($date);
	}
	static function safe_url($url) {
		$url = preg_replace("/[^a-zA-Z0-9\s]/", "", $url);
		$url = str_replace(' ', '_', $url);
		return trim(strip_tags($url));
	}
	function safe_seo_link($link) {
		$arr = preg_replace("/[^a-zA-Z0-9\s]/", "", $link);
		$arr = str_replace(' ', '_', $arr);
		// $arr = substr( $arr , 0 , 100 );
		return trim(strip_tags($arr));
	}
	function chars_limit($string, $limit, $append = '...') {
		(! is_string($string)) ? $string = (string) $string : FALSE;
		(! is_int($limit)) ? $limit = (int) $limit : FALSE;

		if(strlen($string) > $limit) {
			$string = substr($string, 0, $limit) . $append;
		}

		return $string;
	}
	static function getAge($birthday) {
	/*	list($year, $month, $day) = explode("-", $birthday);
		$year_diff = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff = date("d") - $day;
		if($month_diff < 0)
			$year_diff --;
		elseif(($month_diff == 0) && ($day_diff < 0))
			$year_diff --;
return $year_diff;
		*/
		$date = new \DateTime($birthday);
		$now = new \DateTime();
		$interval = $now->diff($date);
		return $interval->y;


	}
	function getFileExtension($File) {
		$File_ar = explode('.', $File);
		return strtolower($File_ar[count($File_ar) - 1]);
	}
	function checkSiteUrl($systemCloneType, $main_system, $siteurl) {
		if($systemCloneType == 'vod_main')

		{
			(substr($main_system, - 1) != '/') ? $main_system = $main_system . '/' : FALSE;
			$siteurl = $main_system;
		} else {
			$siteurl = Utils::check_url($siteurl);
		}
		return $siteurl;
	}
	function check_url($url) {
		if($url == '') {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			return $url;
		}
		$url_ar = parse_url($url);
		if($url_ar['domain'] == '') {
			$url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			return $url;
		} else {
			$url = 'http://' . $url_ar['domain'] . '/';
		}

		return $url;
	}
	function pr($arrayToPrint, $vDump = FALSE) {
		if(is_array($arrayToPrint)) {
			if($vDump == FALSE) {
				print '<pre>';
				print_r($arrayToPrint);
				print '</pre>';
			} elseif($vDump == TRUE) {
				var_dump($arrayToPrint);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function p($stringToPrint, $Delimiter = FALSE) {
		if($Delimiter == FALSE) {
			print '<br />' . $stringToPrint . '<br />';
		} elseif($Delimiter != FALSE) {
			print '<p>' . $stringToPrint . '</p>';
		}
		return TRUE;
	}
	function pd($stringToPrint = FALSE) {
		if($stringToPrint == FALSE) {
			print '<br />' . 'test test test' . '<br />';
		} else {
			print '<p>' . $stringToPrint . '</p>';
		}
		return TRUE;
	}
}

?>