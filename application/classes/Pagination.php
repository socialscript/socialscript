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

namespace classes;

class Pagination {
	static function Generate($page, $per_page, $nr_rows, $url, $div_element) {
		$pagination = '';
		if($nr_rows > $per_page) {
			$pag = 1;
			$pagination .= '<ul>';
			while ( $pag <= ceil($nr_rows / $per_page) ) {
				if($pag != $page + 1) {
					
					$pagination .= '<li><a   onclick=\'show_pagination("' . $url . '&pag=' . $pag . '","' . $div_element . '")\'>' . $pag . '</a></li>';
				} else {
					$pagination .= '<li class="active"><a >' . $pag . '</a> </li>';
				}
				$pag ++;
			}
			$pagination .= '</ul>';
		}
		
		return $pagination;
	}
}

?>