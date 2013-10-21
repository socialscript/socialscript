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

use lib\WNException\WNException;
function WNErrorHandler($errno, $errstr, $errfile, $errline) {
	// if(E_RECOVERABLE_ERROR === $errno) {
	// echo "'catched' catchable fatal error\n";
	// throw new WNException($errstr, $errno, 0, $errfile, $errline);
	
	// return true;
	// }
	return false;
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
?>