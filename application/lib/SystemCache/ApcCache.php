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

namespace lib\SystemCache;

class ApcCache  {

	public $cacheTypeToClear = '';

	static $Instance;
	static function getInstance() {
		if(! is_object(self::$Instance)) {
			self::$Instance = new ApcCache();
		}
		return self::$Instance;
	}
	function __construct(){

	}

	function Exists($Key)
	{
		return apc_exists($Key);
	}
	function Store($Key,$Variable)
	{
		if(!apc_exists($Key))
		{
			return apc_store($Key,$Variable);
		}

	}

	function Delete($Key)
	{
		if(apc_exists($Key))
		{
			return apc_delete($Key);

		}
	}

	function clearCache($cacheTypeToClear = FALSE)
	{
		$this->cacheTypeToClear = $cacheTypeToClear;
		if($cacheTypeToClear === FALSE)
		{
			apc_clear_cache();
			apc_clear_cache('user');
			apc_clear_cache('opcode');
		}
		else
		{
			apc_clear_cache($this->cacheTypeToClear);

		}
	}

	function Fetch($Key)
	{
		//if(apc_exists($Key))
		//{
		return apc_fetch($Key);
		//}
		//else
		//{
		//return FALSE;
		//}
	}

	function CacheInfo()
	{
		pr(apc_cache_info());
	}
}

?>