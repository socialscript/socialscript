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
function isEmail($Field) {
	$invalidEmail = FALSE;
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
	
	if(strstr($Field, '@') && strstr($Field, '.')) {
		
		if(preg_match($chars, $Field)) {
			
			return TRUE;
		} else {
			
			return FALSE;
		}
	} else {
		return FALSE;
	}
}
function isEmailDomainValid($Field) {
	if(strstr($Field, '@')) {
		list($userName, $mailDomain) = split("@", $Field);
		
		if(substr_count($mailDomain, ".") > 1) {
			$domain_arr = split("\\.", $mailDomain);
			$no = count($domain_arr);
			$no_2 = $no - 2;
			$no_1 = $no - 1;
			$mailDomain = $domain_arr[$no_2];
			$mailDomain .= "." . $domain_arr[$no_1];
		}
		
		if($mailDomain != '') {
			if(! checkdnsrr($mailDomain, "MX")) {
				return FALSE;
			}
		}
	}
	return TRUE;
}
function isEmpty($Field) {
	if(empty($Field)) {
		return FALSE;
	}
	return TRUE;
}
function isLessThan($Field, $Characters) {
	if(strlen($Field) <= $Characters) {
		return FALSE;
	}
	return TRUE;
}
function isNumeric($Field) {
	if(! is_numeric($Field)) {
		return FALSE;
	}
	return TRUE;
}
function isAlphanumeric($Field) {
	if(! ctype_alnum($Field)) {
		return FALSE;
	}
	
	return TRUE;
}
function isAlpha($Field) {
	if(! ctype_alpha($Field)) {
		return FALSE;
	}
	return TRUE;
}
function isLowercase($Field) {
	if(ctype_lower($Field)) {
		return FALSE;
	}
	return TRUE;
}
function isUppercase($Field) {
	if(! ctype_upper($Field)) {
		
		return FALSE;
	}
	return TRUE;
}
function isMoreThan($Field, $Characters) {
	if(strlen($Field) >= $Characters) {
		return FALSE;
	}
	return TRUE;
}

?>