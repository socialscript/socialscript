function add_predefined(type)
{
	if(type.value == "date_of_birth")
		{
	addDateOFBirth();
		}
	else if(type.value == "password")
	{
addPassword();
	}
	if(type.value == "password_retype")
	{
		addPasswordAndRetypePassword();
	}
	}




function addAdditional(dropdown,id)
			{

		 $("#validation_type-add"+id).remove();
				if(dropdown.value == "alphanumeric" || dropdown.value == "alpha" || dropdown.value == "lowercase" || dropdown.value == "uppercase" || dropdown.value == "numbersAndSpace" || dropdown.value == "lettersAndSpace")
					{

					$("#validation_type-"+id).append('<div id="validation_type-add'+id+'"><div style="float:left">Min Chars: </div><div style="float:left"><input type="text" name="min_'+id+'" style="width:20px"></div><div style="float:left">Max Chars:</div><div style="float:left"><input type="text" name="max_'+id+'" style="width:20px;"></div></div>');
					}
				else if(dropdown.value == "numeric")
				{
					$("#validation_type-"+id).append('<div id="validation_type-add'+id+'"><div style="float:left">Min Value: </div><div style="float:left"><input type="text" name="min_'+id+'" style="width:20px"></div><div style="float:left">Max Value:</div><div style="float:left"><input type="text" name="max_'+id+'" style="width:20px;"></div></div>');
				}
				else if(dropdown.value == "date(YYYY-mm-dd)")
				{
					$("#validation_type-"+id).append('<div class="clear"></div><div id="validation_type-add'+id+'"><div style="float:left">Bigger Than: </div><div style="float:left"><input type="text" name="min_'+id+'" style="width:150px" class="datep"></div><div style="float:left">Less Than:</div><div style="float:left"><input type="text" name="max_'+id+'" style="width:150px;" class="datep"></div></div>');
				}
			}

(function($){
 $.fn.formbuilder = function() {
	 if(page == 'register')
	 {
saveUrl = "index_admin.php?route=forms&action=save_register"
	 }
 else
	 {
	 saveUrl = "index_admin.php?route=forms&action=save_user_profile"
	 }
	 var defaults = {
			 saveUrl:saveUrl
			  };
			  var options = $.extend(defaults, options);
			  nr_fields = $('ul[id^=frmb-]').length++ + form_fields_nr;
			  var frmb_id = 'frmb-' + nr_fields;
			 // frmb_id = frmb_id + form_fields_nr;


    return this.each(function() {

    	var ul_obj = $(this).append('<ul id="' + frmb_id + '" class="frmb"></ul>').find('ul');
		var field = '', field_type = '',  help, form_db_id;
		last_id = nr_fields;

		// Add a unique class to the current element
		$(ul_obj).addClass(frmb_id);
		// load existing form data
		if (options.load_url) {
			$.getJSON(options.load_url, function(json) {
				form_db_id = json.form_id;
				fromJson(json.form_structure);
			});
		}

    	var createDropdown = function (target) {
			var select = '';
			var box_content = '';
			var save_button = '';
			var box_id = frmb_id + '-control-box';
			var save_id = frmb_id + '-save-button';
			// Add the available options
			select += '<option value="0">Add fields</option>';
			select += '<option value="input_text">Text</option>';
			select += '<option value="textarea">Textarea</option>';
			select += '<option value="checkbox">Checkbox</option>';
			select += '<option value="radio">Radio Group</option>';
			select += '<option value="select">Dropdown</option>';
			// Build the control box and search button content
			if(page == 'register')
				{
			box_content = '<select id="' + box_id + '" class="frmb-control">' + select + '</select> or <select name="predefined" onchange="add_predefined(this)"><option value="">Add predefined fields</option><option value="date_of_birth">date of birth</option><option value="password">password</option><option value="password_retype">password and retype password</option></select>';
				}
			else
				{
				box_content = '<select id="' + box_id + '" class="frmb-control">' + select + '</select>';
				}
			save_button = '<input type="submit" id="' + save_id + '" class="frmb-submit" value="Save"/>';
			// Insert the control box into page
			if (!target) {
				$(ul_obj).before(box_content);
			} else {
				$(target).append(box_content);
			}

			$("#predefined").after(save_button);
			// Set the form save action
			$('#' + save_id).click(function () {
				save();
				return false;
			});

			$('#' + box_id).change(function () {
				addField($(this).val());
				$(this).val(0).blur();
				// This solves the scrollTo dependency
				$('html, body').animate({
					scrollTop: $('#frm-' + (last_id - 1) + '-item').offset().top
				}, 500);
				return false;
			});
		}(options.control_box_target);


		// Wrapper for adding a new field
		var addField = function (type, values, options, required) {
			last_id++;
				field = '';
				field_type = type;
				if (typeof (values) === 'undefined') {
					values = '';
				}
				switch (type) {
				case 'input_text':
					addTextField(values, required);
					break;
				case 'textarea':
					addTextarea(values, required);
					break;
				case 'checkbox':
					addCheckboxGroup(values, options, required);
					break;
				case 'radio':
					addRadioGroup(values, options, required);
					break;
				case 'select':
					addDropdown(values, options, required);
					break;
				}
			};
		// single line input type="text"
		var addTextField = function (values, required) {
				field += '<label>Label</label>';
				field += '<input class="fld-title" id="title-' + last_id + '" type="text" name="text-' + last_id + '" value="' + values + '" />';
				help = '';
				appendFieldLi("Text Field", field, required, help);
			};
		// multi-line textarea
		var addTextarea = function (values, required) {
				field += '<label>Label</label>';
				field += '<input type="text" value="' + values + '" name="textarea-' + last_id + '" />';
				help = '';
				appendFieldLi("Textarea field", field, required, help);
			};
		// adds a checkbox element
		var addCheckboxGroup = function (values, options, required) {
				var title = '';
				if (typeof (options) === 'object') {
					title = options[0];
				}
				field += '<div class="chk_group">';
				field += '<div class="frm-fld"><label>Title</label>';
				field += '<input type="text" name="checkbox-name-' + last_id + '" value="' + title + '" /></div>';
				field += '<div class="false-label">Select Options</div>';
				field += '<div class="fields">';
				if (typeof (values) === 'object') {
					for (i = 0; i < values.length; i++) {
						field += checkboxFieldHtml(values[i],title);
					}
				}
				else {
					field += checkboxFieldHtml('');
				}
				field += '<div class="add-area"><a href="#" class="add add_ck">Add</a></div>';
				field += '</div>';
				field += '</div>';
				help = '';
				appendFieldLi("Checkbox group", field, required, help);
			};
		// Checkbox field html, since there may be multiple
		var checkboxFieldHtml = function (values,title) {

				var checked = false;
				var value = '';
				if (typeof (values) === 'object') {
					value = values[0];
					checked = ( values[1] === 'false' || values[1] === 'undefined' ) ? false : true;
				}
				field = '';
				field += '<div>';
				field += '<input type="checkbox"' + (checked ? ' checked="checked"' : '') + ' name="checkbox-' + last_id + '[]"/>';
				field += '<input type="text" value="' + value + '" name="checkbox-' + last_id + '[]"/>';
				field += '<a href="#" class="remove" title="Remove">Remove</a>';
				field += '</div>';
				return field;
			};
		// adds a radio element
		var addRadioGroup = function (values, options, required) {
				var title = '';
				if (typeof (options) === 'object') {
					title = options[0];
				}
				field += '<div class="rd_group">';
				field += '<div class="frm-fld"><label>Title</label>';
				field += '<input type="text" name="radio-name-' + last_id + '" value="' + title + '" /></div>';
				field += '<div class="false-label">Select Options</div>';
				field += '<div class="fields">';
				if (typeof (values) === 'object') {
					for (i = 0; i < values.length; i++) {
						field += radioFieldHtml(values[i], 'frm-' + last_id + '-fld');
					}
				}
				else {
					field += radioFieldHtml('', 'frm-' + last_id + '-fld');
				}
				field += '<div class="add-area"><a href="#" class="add add_rd">Add</a></div>';
				field += '</div>';
				field += '</div>';
				help = '';
				appendFieldLi("Radio Group", field, required, help);
			};
		// Radio field html, since there may be multiple
		var radioFieldHtml = function (values, name) {
				var checked = false;
				var value = '';
				if (typeof (values) === 'object') {
					value = values[0];
					checked = ( values[1] === 'false' || values[1] === 'undefined' ) ? false : true;
				}
				field = '';
				field += '<div>';
				field += '<input type="radio"' + (checked ? ' checked="checked"' : '') + ' name="radio-' + last_id + '[]" />';
				field += '<input type="text" value="' + value + '" name="radio-' + last_id + '[]" />';
				field += '<a href="#" class="remove" title="Remove">Remove</a>';
				field += '</div>';
				return field;
			};
		// adds a select/option element
		var addDropdown = function (values, options, required) {
				var multiple = false;
				var title = '';
				if (typeof (options) === 'object') {
					title = options[0];
					multiple = options[1] === 'true' ? true : false;
				}
				field += '<div class="opt_group">';
				field += '<div class="frm-fld"><label>Title</label>';
				field += '<input type="text" name="dropdown-name-' + last_id + '" value="' + title + '" /></div>';
				field += '';
				field += '<div class="false-label">Select Options</div>';
				field += '<div class="fields">';
				//field += '<input type="checkbox" name="multiple"' + (multiple ? 'checked="checked"' : '') + '>';
				//field += '<label class="auto">Allow Multiple Options</label>';
				if (typeof (values) === 'object') {
					for (i = 0; i < values.length; i++) {
						field += selectFieldHtml(values[i], multiple);
					}
				}
				else {
					field += selectFieldHtml('', multiple);
				}
				field += '<div class="add-area"><a href="#" class="add add_opt">Add</a></div>';
				field += '</div>';
				field += '</div>';
				help = '';
				appendFieldLi("Dropdown", field, required, help);
			};
		// Select field html, since there may be multiple
		var selectFieldHtml = function (values, multiple) {
				if (multiple) {
					return checkboxFieldHtml(values);
				}
				else {
					return radioFieldHtml(values);
				}
			};

		// Appends the new field markup to the editor
		var appendFieldLi = function (title, field_html, required, help) {
				if (required) {
					required = required === 'checked' ? true : false;
				}
				var li = '';
				li += '<li id="frm-' + last_id + '-item" class="' + field_type + '" style="width:830px;">';
				li += '<div class="legend">';
			//	li += '<a id="frm-' + last_id + '" class="toggle-form" href="#">Hide</a> ';
				li += '<a id="del_' + last_id + '" class="del-button delete-confirm" href="#" title="Remove"><span>Remove</span></a>';
				li += '<strong id="txt-title-' + last_id + '">' + title + '</strong></div>';
				li += '<div id="frm-' + last_id + '-fld" class="frm-holder">';
				li += '<div class="frm-elements">';
				li += '<div class="frm-fld"><label for="required-' + last_id + '">Required</label>';
				li += '<input class="required" type="checkbox" value="1" name="required-' + last_id + '" id="required-' + last_id + '"' + (required ? ' checked="checked"' : '') + ' />';
				li += '<div class="frm-fld"><label for="validation_type-' + last_id + '">Validation Type</label>';
				li += '<div class="frm-fld" id="validation_type-'+last_id+'"><label for="validation_type-' + last_id + '"><select name="validation_type-'+last_id+'"  onchange="addAdditional(this,'+last_id+')"><option value="">Select</option>'+validation+'</select></label></div>';

				if(title == "Text Field" &&  page == 'register')
					{

			//	li += '<div class="frm-fld"><label for="validation_type2-' + last_id + '">Ajax Validation Type</label>';
				//li += '<div class="frm-fld" id="validation_type2-'+last_id+'"><label for="validation_type2-' + last_id + '"><select name="validation_type2-'+last_id+'"><option value="">Select</option>'+validators_ajax+'</select></label></div>';
					}
				li += field;
				li += '</div>';
				li += '</div>';
				li += '</li>';
				$(ul_obj).append(li);
				$('#frm-' + last_id + '-item').hide();
				$('#frm-' + last_id + '-item').animate({
					opacity: 'show',
					height: 'show'
				}, 'slow');

			};



			$('.delete-confirm').live('click', function () {
				var delete_id = $(this).attr("id").replace(/del_/, '');
				if (confirm($(this).attr('title'))) {
					$('#frm-' + delete_id + '-item').animate({
						opacity: 'hide',
						height: 'hide',
						marginBottom: '0px'
					}, 'slow', function () {
						$(this).remove();
					});
				}
				return false;
			});

			// Attach a callback to add new checkboxes
			$('.add_ck').live('click', function () {

				$(this).parent().before(checkboxFieldHtml());
				return false;
			});
			// Attach a callback to add new options
			$('.add_opt').live('click', function () {
				$(this).parent().before(selectFieldHtml('', false));
				return false;
			});
			// Attach a callback to add new radio fields
			$('.add_rd').live('click', function () {
				$(this).parent().before(radioFieldHtml(false, $(this).parents('.frm-holder').attr('id')));
				return false;
			});

			var save = function () {

					$.ajax({
						type: "POST",
						url: options.saveUrl,
						data: $("form").serialize(),
						success: function () {
							$("#response").dialog();
						}
					});

			};

    });
 };
})(jQuery);

function addDateOFBirth()
{

	last_id = parseInt(last_id) + 1;
	  var frmb_id = 'frmb-' + last_id;
	li = '<li id="frm-' + last_id + '-item" class="dob"><div class="legend"><strong >Date of birth</strong></div><div class="frm-holder"><div class="frm-elements"><div class="frm-fld">';
	li += '<div class="legend">';
	li += '<a id="del_'+last_id+'" class="del-button delete-confirm" href="#" title="Remove"><span>Remove</span></a>';
	li += '<strong id="txt-title-'+last_id+'"></strong></div>';
	li += '<div id="frm-'+last_id+'-fld" class="frm-holder">';
	li += '<div class="frm-fld"><label for="required-'+last_id+'">Required</label>';
	li += '<input class="required" type="checkbox" value="1" name="required-'+last_id+'" id="required-'+last_id+'" />';
	//li += '<div class="frm-fld"><label for="validation_type-'+last_id+'">Validation Type</label>';
	//li += '<div class="frm-fld" id="validation_type-'+last_id+'"><label for="validation_type-'+last_id+'"><select name="validation_type-'+last_id+'"  onchange="addAdditional(this,'+last_id+')"><option value="">Select</option>'+validation+'</select></label></div>';

	li += '<div class="frm-fld">Preview: <input type="hidden" name="dob_'+last_id+'">'+years_dropdown+ months_dropdown+days_dropdown;
	li += '</div>';
	li += '</div>';
	li += '<label>Label</label>';
	li += '<input type="text" value="Date of Birth" name="dob-' + last_id + '" />';
	li += '</div></div></div></div></li>';

	$('#predefined').append(li);

}

function addPassword()
{

	last_id = parseInt(last_id) +2;
	  var frmb_id = 'frmb-' + last_id;
	li = '<li id="frm-' + last_id + '-item" class="password"><div class="legend"><strong >Password</strong></div><div class="frm-holder"><div class="frm-elements"><div class="frm-fld">';
	li += '<div class="legend">';
	li += '<a id="del_'+last_id+'" class="del-button delete-confirm" href="#" title="Remove"><span>Remove</span></a>';
	li += '<strong id="txt-title-'+last_id+'"></strong></div>';
	li += '<div id="frm-'+last_id+'-fld" class="frm-holder">';
	li += '<div class="frm-fld"><label for="required-'+last_id+'">Required</label>';
	li += '<input class="required" type="checkbox" value="1" name="required-'+last_id+'" id="required-'+last_id+'" checked="checked" readonly/>';
	//li += '<div class="frm-fld"><label for="validation_type-'+last_id+'">Validation Type</label>';
	//li += '<div class="frm-fld" id="validation_type-'+last_id+'"><label for="validation_type-'+last_id+'"><select name="validation_type-'+last_id+'"  onchange="addAdditional(this,'+last_id+')"><option value="">Select</option>'+validation+'</select></label></div>';

	li += '<div class="frm-fld">Preview: <input type="hidden" name="password-'+last_id+'">Password: <input type="password">';
	li += '</div>';
	li += '</div>';
	li += '<label>Label</label>';
	li += '<input type="text" value="Password" name="password-' + last_id + '" />';
	li += '</div></div></div></div></li>';

	$('#predefined').append(li);

}

function addPasswordAndRetypePassword()
{

	last_id =parseInt(last_id) + 3;
	  var frmb_id = 'frmb-' + last_id;
	li = '<li id="frm-' + last_id + '-item" class="dob"><div class="legend"><strong >Password and Repeat Password</strong></div><div class="frm-holder"><div class="frm-elements"><div class="frm-fld">';
	li += '<div class="legend">';
	li += '<a id="del_'+last_id+'" class="del-button delete-confirm" href="#" title="Remove"><span>Remove</span></a>';
	li += '<strong id="txt-title-'+last_id+'"></strong></div>';
	li += '<div id="frm-'+last_id+'-fld" class="frm-holder">';
	li += '<div class="frm-fld"><label for="required-'+last_id+'">Required</label>';
	li += '<input class="required" type="checkbox" value="1" name="required-'+last_id+'" id="required-'+last_id+'" checked="checked" readonly/>';
	//li += '<div class="frm-fld"><label for="validation_type-'+last_id+'">Validation Type</label>';
	//li += '<div class="frm-fld" id="validation_type-'+last_id+'"><label for="validation_type-'+last_id+'"><select name="validation_type-'+last_id+'"  onchange="addAdditional(this,'+last_id+')"><option value="">Select</option>'+validation+'</select></label></div>';

	li += '<div class="frm-fld">Preview:<input type="hidden" name="password_retype-'+last_id+'">Password:<input type="password"> Retype Password:<input type="password">';
	li += '</div>';
	li += '</div>';
	li += '<label>Label</label>';
	li += '<input type="text" value="Password" name="password_retype-' + last_id + '" />';
	li += '</div></div></div></div></li>';

	$('#predefined').append(li);

}