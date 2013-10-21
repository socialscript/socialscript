<?php

namespace models;

use lib\Core\Model as Model;

class ModelUsers extends Model {
	function getFormFieldsRegister() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE type="register_form" AND id > 4 ORDER BY `order` ASC');
		foreach($result as $k => &$v) {
			$options = array();
			$v->name = ucwords($v->name);
			if($v->field_type == 'checkbox' || $v->field_type == 'radio' || $v->field_type == 'dropdown') {
				$options = explode('|', $v->options);
				unset($options[count($options) - 1]);

				$i = 0;
				foreach($options as $k2 => $v2) {

					list($v->elements[$i]['name'], $v->elements[$i]['checked']) = explode(':', $v2);
					// $v->elements[$i]['field_name'] =
					// strtolower(preg_replace('/[^A-Za-z0-9]/', '',
					// $v->elements[$i]['name']));
					$v->elements[$i]['field_name'] = strtolower(str_replace(' ', '', $v->elements[$i]['name']));
					$i ++;
				}
			}
			// $v->field_name = strtolower(preg_replace('/[^A-Za-z0-9]/', '',
			// $v->name));
			$v->field_name = strtolower(str_replace(' ', '', $v->name));
			$v->value = '';
		}
		return $result;
	}
	function usernameExists($Username) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT username FROM ' . $this->table_prefix . '_users WHERE username="' . $Username . '" LIMIT 1');
	}
	function emailExists($Email) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT username FROM ' . $this->table_prefix . '_users WHERE email="' . $Email . '" LIMIT 1');
	}
	function getFormFields() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE type="register_form" ORDER BY id ASC');
	}
	function Login($Username, $Password) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Username,
				$Password
		))->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_users
				WHERE username= ? AND password = ?');
	}
	function getUserByUsername($Username) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Username
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
				WHERE username= ? LIMIT 1')[0];
	}
	function getUserByUserKey($userKey) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$userKey
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
				WHERE user_key= ?  LIMIT 1')[0];
	}
	function getUserSalt($Username) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setFetchType('OneRecord')->setPreparedValues(array(
				$Username
		))->executeQuery('SELECT salt FROM ' . $this->table_prefix . '_users
				WHERE username= ?');
		if(is_object($result)) {
			return $result;
		} else {
			$std = new \stdClass();
			$std->salt = '';
			return $std;
		}
	}
	function checkUserExists($userKey) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$userKey
		))->executeQueryNrRows('SELECT * FROM ' . $this->table_prefix . '_users
				WHERE user_key= ?');
	}
	function setUserOnline($Username) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Username
		))->executeQuery('UPDATE ' . $this->table_prefix . '_users
				SET last_login="'.time().'",online="1" WHERE username= ? ');
	}

	function setUserOffline($Username) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Username
		))->executeQuery('UPDATE ' . $this->table_prefix . '_users
				SET online="0" WHERE user_key= ? ');
	}

	function checkUserIsOnline($userKey) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$userKey
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_users
				WHERE user_key= ?')[0]->online;
	}
	function checkUserIsOnlineByUsername($Username) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Username
		))->executeQueryNrRows('SELECT online FROM ' . $this->table_prefix . '_users
				WHERE username= ?');
	}
	function saveUserStatus($Fields, $Fields2) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('UPDATE ' . $this->table_prefix . '_users
				SET changing_status=? WHERE user_key= ? ');

		$nr_rows = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->executeQueryNrRows('SELECT id FROM ' . $this->table_prefix . '_statuses');
		if($nr_rows > 40) {
			$this->DB->loadQuery('DELETE')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('DELETE FROM ' . $this->table_prefix . '_statuses
				ORDER BY id ASC LIMIT 1');
		}
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields2)->executeQuery('INSERT INTO ' . $this->table_prefix . '_statuses(username,status)
					VALUES(?,?)');
	}
	function getUserExtraFields($Id) {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT
			* FROM ' . $this->table_prefix . '_forms WHERE (type="register_form" OR type="user_profile") AND id > 4 ');
		foreach($result as $k => &$v) {
			$value_result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$Id
			))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT
			value FROM ' . $this->table_prefix . '_users_extra 	WHERE field="' . $v->id . '" AND user_id=?');
			//var_dump($value_result);
			if(isset($value_result[0])) {
				$v->value = $value_result[0]->value;
			} else {
				$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
						$Id,
						$v->id,
						''
				))->executeQuery('INSERT INTO ' . $this->table_prefix . '_users_extra(user_id,field,value)
					VALUES(?,?,?)');

				$v->value = '';
			}
		}
		return $result;
	}
	function getUserExtraFieldsProfile($Id) {
		$result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
				$Id
		))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT
			* FROM ' . $this->table_prefix . '_forms WHERE type="user_profile" ');
		foreach($result as $k => &$v) {
			$value_result = $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues(array(
					$Id
			))->setFetchMode('FETCH_OBJ')->executeQuery('SELECT
			value FROM ' . $this->table_prefix . '_users_extra 	WHERE field="' . $v->id . '" AND user_id=?');
			if(isset($value_result[0])) {
				$v->value = $value_result[0]->value;
			} else {
				$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues(array(
						$Id,
						$v->id,
						''
				))->executeQuery('INSERT INTO ' . $this->table_prefix . '_users_extra(user_id,field,value)
					VALUES(?,?,?)');

				$v->value = '';
			}
		}
		return $result;
	}
	function getUserExtraField($Name) {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT id FROM ' . $this->table_prefix . '_forms WHERE LOWER(REPLACE(name," ",""))= "' . $Name . '"');
		if(isset($result[0])) {
			return $result[0]->id;
		} else {
			return FALSE;
		}
	}
	function getUserExtraFieldById($Id) {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE id="' . $Id . '"')[0];
	}
	function getExtraFieldsProfile() {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setPreparedValues($Id)->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms
				 			WHERE type="user_profile" ORDER BY id ASC');
	}
	function insertExtraFieldProfile($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_users_extra(user_id,field,value)
					VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function getFormFieldsNoDefaultRegister() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE type="register_form"  ORDER BY `order` ASC');
		foreach($result as $k => &$v) {
			$options = array();
			$v->name = ucwords($v->name);
			if($v->field_type == 'checkbox' || $v->field_type == 'radio' || $v->field_type == 'dropdown') {
				$options = explode('|', $v->options);
				unset($options[count($options) - 1]);

				$i = 0;
				foreach($options as $k2 => $v2) {

					list($v->elements[$i]['name'], $v->elements[$i]['checked']) = explode(':', $v2);
					// $v->elements[$i]['field_name'] =
					// strtolower(preg_replace('/[^A-Za-z0-9]/', '',
					// $v->elements[$i]['name']));
					$v->elements[$i]['field_name'] = strtolower(str_replace(' ', '', $v->elements[$i]['name']));
					$i ++;
				}
			}
			// $v->field_name = strtolower(preg_replace('/[^A-Za-z0-9]/', '',
			// $v->name));
			$v->field_name = strtolower(str_replace(' ', '', $v->name));
		}
		return $result;
	}
	function getFormFieldsNoDefault() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE type="register_form"  ORDER BY `order` ASC');
		foreach($result as $k => &$v) {
			$options = array();
			$v->name = ucwords($v->name);
			if($v->field_type == 'checkbox' || $v->field_type == 'radio' || $v->field_type == 'dropdown') {
				$options = explode('|', $v->options);
				unset($options[count($options) - 1]);

				$i = 0;
				foreach($options as $k2 => $v2) {

					list($v->elements[$i]['name'], $v->elements[$i]['checked']) = explode(':', $v2);
					// $v->elements[$i]['field_name'] =
					// strtolower(preg_replace('/[^A-Za-z0-9]/', '',
					// $v->elements[$i]['name']));
					$v->elements[$i]['field_name'] = 'register_' . strtolower(str_replace(' ', '', $v->elements[$i]['name']));
					$i ++;
				}
			}
			// $v->field_name = strtolower(preg_replace('/[^A-Za-z0-9]/', '',
			// $v->name));
			$v->field_name = 'register_' . strtolower(str_replace(' ', '', $v->name));
		}

		return $result;
	}
	function getFormFieldsEditProfile() {
		$result = $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_forms WHERE id="2" OR  id > "4"  ORDER BY `order` ASC');
		foreach($result as $k => &$v) {
			$options = array();
			$v->name = ucwords($v->name);
			if($v->field_type == 'checkbox' || $v->field_type == 'radio' || $v->field_type == 'dropdown') {
				$options = explode('|', $v->options);
				unset($options[count($options) - 1]);

				$i = 0;
				foreach($options as $k2 => $v2) {

					list($v->elements[$i]['name'], $v->elements[$i]['checked']) = explode(':', $v2);
					// $v->elements[$i]['field_name'] =
					// strtolower(preg_replace('/[^A-Za-z0-9]/', '',
					// $v->elements[$i]['name']));
					$v->elements[$i]['field_name'] = strtolower(str_replace(' ', '', $v->elements[$i]['name']));
					$i ++;
				}
			}
			// $v->field_name = strtolower(preg_replace('/[^A-Za-z0-9]/', '',
			// $v->name));
			$v->field_name = strtolower(str_replace(' ', '', $v->name));
		}

		return $result;
	}
	function getFeaturedUsers($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_users
			LEFT JOIN ' . $this->table_prefix . '_users_extra
			ON ' . $this->table_prefix . '_users.id=' . $this->table_prefix . '_users_extra.user_id
			GROUP BY ' . $this->table_prefix . '_users.id
			ORDER BY ' . $this->table_prefix . '_users.id DESC
			LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getFeatured($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_users
			LEFT JOIN ' . $this->table_prefix . '_users_extra
			ON ' . $this->table_prefix . '_users.id=' . $this->table_prefix . '_users_extra.user_id
				WHERE featured="1"
			GROUP BY ' . $this->table_prefix . '_users.id
			ORDER BY ' . $this->table_prefix . '_users.id DESC
			LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getUserLatestPictures($userKey, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$userKey
		))->executeQuery('SELECT ' . $this->table_prefix . '_pictures.*,' . $this->table_prefix . '_galleries.gallery_name,' . $this->table_prefix . '_galleries.user_key FROM ' . $this->table_prefix . '_pictures
				LEFT JOIN ' . $this->table_prefix . '_galleries
				ON ' . $this->table_prefix . '_pictures.gallery_id=' . $this->table_prefix . '_galleries.id
					WHERE ' . $this->table_prefix . '_galleries.user_key = ? ORDER BY
				' . $this->table_prefix . '_pictures.id DESC LIMIT ' . $Limit);
	}
	function getUserLatestGroups($userKey, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$userKey
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_groups
				 					WHERE user_key = ? ORDER BY
				id DESC LIMIT ' . $Limit);
	}
	function getUserLatestBlogs($userKey, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$userKey
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_blogs
				 					WHERE user_key = ? ORDER BY
				id DESC LIMIT ' . $Limit);
	}
	function getUserLatestEvents($userKey, $Limit) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$userKey
		))->executeQuery('SELECT * FROM ' . $this->table_prefix . '_events
				 					WHERE user_key = ? ORDER BY
				id DESC LIMIT ' . $Limit);
	}
	function getUsersNrByCountry($Country) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
				$Country
		))->executeQuery('SELECT COUNT(id) AS nr_rows FROM ' . $this->table_prefix . '_users
				 					WHERE country = ?')[0]->nr_rows;
	}
	function getUsersByCountry($Country, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues(array(
						$Country
				))->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_users
					LEFT JOIN ' . $this->table_prefix . '_users_extra
				ON ' . $this->table_prefix . '_users.user_key=' . $this->table_prefix . '_users_extra.user_id
				 					WHERE ' . $this->table_prefix . '_users.country = ?
				GROUP BY ' . $this->table_prefix . '_users.user_key LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getOnlineUsers($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_users
					LEFT JOIN ' . $this->table_prefix . '_users_extra
				ON ' . $this->table_prefix . '_users.user_key=' . $this->table_prefix . '_users_extra.user_id
				 					WHERE ' . $this->table_prefix . '_users.online = "1"
				GROUP BY ' . $this->table_prefix . '_users.user_key LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getTopRatedUsers($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_users
					LEFT JOIN ' . $this->table_prefix . '_users_extra
				ON ' . $this->table_prefix . '_users.user_key=' . $this->table_prefix . '_users_extra.user_id

				GROUP BY ' . $this->table_prefix . '_users.user_key
				ORDER BY ' . $this->table_prefix . '_users.rating DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getAllUsers($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_users
					LEFT JOIN ' . $this->table_prefix . '_users_extra
				ON ' . $this->table_prefix . '_users.user_key=' . $this->table_prefix . '_users_extra.user_id

				GROUP BY ' . $this->table_prefix . '_users.user_key
				ORDER BY ' . $this->table_prefix . '_users.registered_date DESC LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getTrades($Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS ' . $this->table_prefix . '_trade.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_trade
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_trade.user_key = ' . $this->table_prefix . '_users.user_key ORDER BY ' . $this->table_prefix . '_trade.id desc
				  LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function getTrade($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_trade.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_trade
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_trade.user_key = ' . $this->table_prefix . '_users.user_key
				 WHERE ' . $this->table_prefix . '_trade.id=?  LIMIT 1')[0];
	}
	function getTradeByName($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_trade.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_trade
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_trade.user_key = ' . $this->table_prefix . '_users.user_key
				 WHERE ' . $this->table_prefix . '_trade.title=?  LIMIT 1')[0];
	}
	function addTrade($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_trade(user_key,title,text,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
		return TRUE;
	}
	function addTradeQuestion($Fields) {
		$this->DB->loadQuery('INSERT')->setPrepareOn(TRUE)->setPreparedValues($Fields)->executeQuery('INSERT INTO ' . $this->table_prefix . '_trade_questions(trade_id,user_key,question,timestamp)
				VALUES(' . implode(array_map(function ($value) {
			return '?';
		}, $Fields), ',') . ')');
	}
	function getTradeQuestions($Fields) {
		return $this->DB->loadQuery('SELECT')->setPrepareOn(TRUE)->setFetchMode('FETCH_OBJ')->setPreparedValues($Fields)->executeQuery('SELECT ' . $this->table_prefix . '_trade_questions.*,' . $this->table_prefix . '_users.username FROM ' . $this->table_prefix . '_trade_questions
				LEFT JOIN ' . $this->table_prefix . '_users ON ' . $this->table_prefix . '_trade_questions.user_key = ' . $this->table_prefix . '_users.user_key
				WHERE trade_id= ? ORDER BY id DESC');
	}
	function getStatuses() {
		return $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT * FROM ' . $this->table_prefix . '_statuses
				 ORDER BY id DESC');
	}
	function Search($Where, $OrderBy, $Limit) {
		return array(
				'results' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery('SELECT SQL_CALC_FOUND_ROWS * FROM ' . $this->table_prefix . '_users
					LEFT JOIN ' . $this->table_prefix . '_users_extra
				ON ' . $this->table_prefix . '_users.user_key=' . $this->table_prefix . '_users_extra.user_id
' . $Where . '
				GROUP BY ' . $this->table_prefix . '_users.user_key
				' . $OrderBy . ' LIMIT ' . $Limit),
				'nr_rows' => $this->DB->loadQuery('SELECT')->setFetchMode('FETCH_OBJ')->executeQuery("SELECT FOUND_ROWS() AS nr_rows")[0]->nr_rows
		);
	}
	function startWebcam($userKey) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($userKey)->executeQuery('UPDATE ' . $this->table_prefix . '_users
				SET webcam="1",webcam_session_id=? WHERE user_key= ? ');
	}
	function disconnectWebcam($userKey) {
		$this->DB->loadQuery('UPDATE')->setPrepareOn(TRUE)->setPreparedValues($userKey)->executeQuery('UPDATE ' . $this->table_prefix . '_users
				SET webcam="0" WHERE user_key= ? ');
	}
}

?>