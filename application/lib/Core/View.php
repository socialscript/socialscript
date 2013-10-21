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

namespace lib\Core;

class View {
	function __construct() {
		$this->Registry = Registry::getInstance();
	}
	function getTemplateEngine() {
		if(! class_exists('Smarty')) {
			include $this->Registry->APPLICATION_DIR . 'lib' . DIRECTORY_SEPARATOR . 'Smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php';
		}
		
		// singleton for ajax/non ajax functionality
		$this->View = \Smarty::Init();
		$this->View->template_dir = ($this->Registry->isAdmin === TRUE) ? $this->Registry->smartyConfig['template_dir_admin'] : $this->Registry->smartyConfig['template_dir'] . $this->Registry->Settings->default_layout . '/';
		$this->View->cache_dir = ($this->Registry->isAdmin === TRUE) ? $this->Registry->smartyConfig['cache_dir_admin'] : $this->Registry->smartyConfig['cache_dir'];
		$this->View->compile_dir = ($this->Registry->isAdmin === TRUE) ? $this->Registry->smartyConfig['compile_dir_admin'] : $this->Registry->smartyConfig['compile_dir'];
		($this->Registry->isAdmin === TRUE) ? $this->View->assign('tpl_dir', $this->Registry->smartyConfig['template_dir_admin']) : $this->View->assign('tpl_dir', $this->Registry->smartyConfig['template_dir'] . $this->Registry->Settings->default_layout . '/');
		$this->View->assign('get', $this->Registry->GET);
		$this->View->assign('no_ajax', NO_AJAX);
		$this->View->assign('settings', $this->Registry->Settings);
		unset($this->Registry);
		return $this->View;
	}
}

?>