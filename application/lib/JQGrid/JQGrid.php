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

namespace lib\JQGrid;

use lib\WNException\WNException;

class JQGrid {
	private $ElementId;
	private $Url;
	private $Data;
	private $DataType;
	private $ColNames;
	private $ColModel;
	private $RowNum;
	private $MType;
	private $RowList;
	private $Pager;
	private $SortName;
	private $ViewRecords;
	private $Toolbar;
	private $SortOrder;
	private $Caption;
	private $EditUrl;
	private $BeforeShowForm;
	private $Custom;
	private $GridComplete;
	private $OnSelectRow;
	private $BeforeEditCell;
	private $BeforeSelectRow;
	private $CellEdit;
	private $Antets;
	private $Width;
	private $Height;
	private $Multiselect;
	private $Loadonce;
	private $Formatter;
	private $EditGridRow;
	private $CustomOptions;

	public function __call($strFunction, $arArguments) {
		$strMethodType = substr($strFunction, 0, 3);
		$strMethodMember = substr($strFunction, 3);

		switch ($strMethodType) {
			case "set" :
				return ($this->SetAccessor($strMethodMember, $arArguments[0]));
				break;
			case "get" :
				return ($this->GetAccessor($strMethodMember));
		}

		return (false);
	}
	private function SetAccessor($strMember, $strNewValue) {
		if(property_exists($this, $strMember)) {
			if(is_numeric($strNewValue)) {
				eval(' $this-> ' . $strMember . ' = ' . $strNewValue . ' ; ');
			} elseif(is_array($strNewValue)) {
				eval(' $this->' . $strMember . '=  ' . var_export($strNewValue, TRUE) . '  ; ');
			} else {
				eval(' $this-> ' . $strMember . " = '" . addslashes($strNewValue) . "' ; ");
			}
		} else {
			return (false);
		}
	}
	private function GetAccessor($strMember) {
		if(property_exists($this, $strMember)) {

			eval(' $strRetVal = $this-> ' . $strMember . ' ; ');
			return ($strRetVal);
		} else {
			return (false);
		}
	}
	function generateGrid() {
		$this->Grid = '<script type="text/javascript">';
		$this->Antets != '' ? $this->Grid .= stripslashes($this->Antets) : NULL;

		$this->Grid .= 'jQuery("#' . $this->ElementId . '").jqGrid({';

		$this->Url != '' ? $this->Grid .= 'url:' . "'" . stripslashes($this->Url) . "'," : NULL;
		$this->CellEdit != '' ? $this->Grid .= 'cellEdit:' . stripslashes($this->CellEdit) . "," : NULL;
		$this->Width != '' ? $this->Grid .= 'width:' . $this->Width . "," : NULL;
		$this->Height != '' ? $this->Grid .= 'height:' . $this->Height . "," : NULL;
		$this->Multiselect != '' ? $this->Grid .= 'multiselect:' . $this->Multiselect . "," : NULL;
		$this->Data != '' ? $this->Grid .= 'data:' . stripslashes($this->Data) . ',' : NULL;
		$this->DataType != '' ? $this->Grid .= 'datatype:' . "'" . stripslashes($this->DataType) . "'," : NULL;
		$this->ColNames != '' ? $this->Grid .= 'colNames:["' . implode('","', $this->ColNames) . '"],' : NULL;
		$this->ColModel != '' ? $this->Grid .= 'colModel:[' . implode(',', $this->ColModel) . '],' : NULL;
		$this->RowNum != '' ? $this->Grid .= 'rowNum:' . stripslashes($this->RowNum) . ',' : NULL;
		$this->MType != '' ? $this->Grid .= 'mtype:"' . stripslashes($this->MType) . '",' : NULL;
		$this->RowList != '' ? $this->Grid .= 'rowList:[' . implode(',', $this->RowList) . '],' : NULL;
		$this->Pager != '' ? $this->Grid .= 'pager:"' . stripslashes($this->Pager) . '",' : NULL;
		$this->SortName != '' ? $this->Grid .= 'sortname:"' . stripslashes($this->SortName) . '",' : NULL;
		$this->ViewRecords != '' ? $this->Grid .= 'viewrecords:' . stripslashes($this->ViewRecords) . ',' : NULL;
		$this->Toolbar != '' ? $this->Grid .= 'toolbar:[' . stripslashes($this->Toolbar) . '],' : NULL;
		$this->SortOrder != '' ? $this->Grid .= 'sortOrder:"' . stripslashes($this->SortOrder) . '",' : NULL;
		$this->EditUrl != '' ? $this->Grid .= 'editurl:"' . stripslashes($this->EditUrl) . '",' : NULL;
		$this->EditGridRow != '' ? $this->Grid .= 'editGridRow:' . stripslashes($this->EditGridRow) . ',' : NULL;
		$this->GridComplete != '' ? $this->Grid .= 'gridComplete:' . stripslashes($this->GridComplete) . ',' : NULL;
		$this->OnSelectRow != '' ? $this->Grid .= 'onSelectRow:' . stripslashes($this->OnSelectRow) . ',' : NULL;
		$this->BeforeEditCell != '' ? $this->Grid .= 'beforeEditCell:' . stripslashes($this->BeforeEditCell) . ',' : NULL;
		$this->BeforeSelectRow != '' ? $this->Grid .= 'beforeSelectRow:' . stripslashes($this->BeforeSelectRow) . ',' : NULL;
		$this->BeforeShowForm != '' ? $this->Grid .= 'beforeShowForm:' . stripslashes($this->BeforeShowForm) . ',' : NULL;
		$this->Loadonce != '' ? $this->Grid .= 'loadonce:' . stripslashes($this->Loadonce) . ',' : NULL;
		$this->CustomOptions != '' ? $this->Grid .=   stripslashes($this->CustomOptions) : NULL;

		$this->Caption != '' ? $this->Grid .= 'caption:"' . stripslashes($this->Caption) . '"' : NULL;
		$this->Grid .= '});';
		$this->Custom != '' ? $this->Grid .= stripslashes($this->Custom) : NULL;
		$this->Formatter != '' ? $this->Grid .= stripslashes($this->Formatter) : NULL;
		$this->Grid .= '</script>';
		return $this->Grid;
	}
}

?>