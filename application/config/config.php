<?php
if(! isset($dbConnectionAr)) {
	$dbConnectionAr = array(
			'MAIN' => array(
					'DB_HOST' => 'localhost',
					'DB_USERNAME' => 'root',
					'DB_PASSWORD' => 'mysql',
					'DB_NAME' => 'community'
			),
			'SELECT' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => 'community'
			),
			'INSERT' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			),
			'UPDATE' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			),
			'DELETE' => array(
					'DB_HOST' => '',
					'DB_USERNAME' => '',
					'DB_PASSWORD' => '',
					'DB_NAME' => ''
			)
	);
}
$google_analytics = array(
		'email' => 'emailt@email.com',
		'password' => 'password',
		'profile_id' => 'profile_id'
);
$theme = 'wn';
$table_prefix = 'wn';
$smarty_config = array(
		'template_dir' => APPLICATION_DIR . 'views/' . $theme . '/front/',
		'cache_dir' => DATA_DIR . 'cache/' . $theme . '/front/',
		'compile_dir' => DATA_DIR . 'compile/' . $theme . '/front/',
		'template_dir_admin' => APPLICATION_DIR . 'views/' . $theme . '/admin/',
		'cache_dir_admin' => DATA_DIR . 'cache/' . $theme . '/admin/',
		'compile_dir_admin' => DATA_DIR . 'compile/' . $theme . '/admin/'
);

$default_admin_theme = 'cupertino';
$validRoutes = array(
		'parameter_name' => array(
				'route' => array(
						'index',
						'users',
						'howitworks',
						'ajax',
						'chat',
						'users_content',
						'users_interaction'
				),
				'action' => array(
						'add',
						'edit',
						'delete',
						'register',
						'login',
						'get_friends',
						'username',
						'welcome',
						'add_friend',
						'general_messages',
						'send_generalmessage',
						'say_hello',
						'mark_interested_in',
						'ask_question',
						'upload',
						'progress',
						'upload_profile_pic',
						'galleries_dropdown',
						'get_gallery_pictures',
						'manage_pictures',
						'upload_pictures',
						'add_pictures_gallery',
						'pictures_gallery_dropdown',
						'manage_pictures',
						'get_gallery_pictures',
						'delete_pic',
						'add_blog_category',
						'blog_categories_dropdown',
						'manage_blogs',
						'add_blog',
						'user_blogs',
						'get_blog',
						'edit_blog',
						'manage_events',
						'add_event',
						'user_events',
						'get_event',
						'edit_event',
						'upload_videos',
						'manage_videos',
						'get_gallery_videos',
						'delete_video',
						'add_videos_gallery',
						'videos_galleries_dropdown',
						'get_events_to_invite',
						'invite_to_event',
						'view_pictures',
						'view_pictures_comments',
						'add_picture_comment',
						'get_picture_comments',
						'view_pictures_gallery',
						'view_blogs',
						'view_blog',
						'view_blogs_by_category',
						'view_blog_comments',
						'get_blog_comments',
						'add_blog_comment',
						'subscribe_to_blog',
						'view_events',
						'view_event',
						'view_event_comments',
						'get_event_comments',
						'add_event_comment',
						'subscribe_to_events',
						'subscribe_to_pictures',
						'friends',
						'best_friends',
						'family_friends',
						'get_all_trade_questions'
				),
				
				'regexp' => array(
						
						'cat_name' => array(
								'[0-9]+'
						),
						'gallery' => array(
								'[0-9]+'
						),
						'rh' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'id' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'g_id' => array(
								'[0-9a-zA-Z\-_]+'
						),
							'u_id' => array(
								'[0-9a-zA-Z\-_]+'
						),
							'c_id' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'u_k' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'trade_id' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'type' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'username' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'featured' => array(
								'[0-9]'
						),
						'online' => array(
								'[0-9]'
						),
						'male' => array(
								'[0-9]'
						),
						'female' => array(
								'[0-9]'
						),
						'search_country' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'order_by' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'group' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'username' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'blog' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'event' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'trade' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'music' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'video' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'photo' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'title' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'country' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'n_a' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'moderator' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'pag' => array(
								'[0-9]+'
						)
				)
				
		)
);

$validRoutesAdmin = array(
		'parameter_name' => array(
				'route' => array(
						'index',
						'settings',
						'forms',
						'register',
						'ajax',
						'languages',
						'nr_items_to_display',
						'roles',
						'users',
						'chat_rooms',
						'user_content_settings',
						'users_interaction',
						'users_content'
				),
				
				'action' => array(
						'index',
						'save_register',
						'edit',
						'add',
						'delete',
						'get',
						'username',
						'load_language',
						'edit_extra',
						'available_countries',
						'edit_availability',
						'pictures_settings',
						'edit_pictures_settings',
						'user_profile',
						'manage_extra_sections',
						'get_events',
						'manage_event',
						'event_comments',
						'get_blogs',
						'manage_blog',
						'blog_comments',
						'pictures',
						'view_picture',
						'music',
						'view_music',
						'delete_music',
						'delete_picture',
						'manage_pictures_comments',
						'manage_music_comments',
						'videos',
						'view_video',
						'delete_video',
						'manage_video_comments',
						'login',
						'games',
						'edit_games',
						'banners',
						'edit_banners'
				),
				'regexp' => array(
						
						'lang' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'type' => array(
								'[0-9a-zA-Z\-_]+'
						),
						'id' => array(
								'[0-9]+'
						)
				)
		)
)
;

$form_validators = array(
		'Email',
		'LettersAndNumbers',
		'LetterNumberUnderscore',
		'OnlyLetters',
		'Numeric',
		'Lowercase',
		'Uppercase',
		'Date(YYYY-mm-dd)',
		'creditCard',
		'Phone',
		'Ipv4',
		'Url',
		'OnlyNumbersAndSpace',
		'OnlyLettersAndSpace',
		'OnlyLettersAndUnderscore',
		'AtLeastOneNumberOneLowercaseOneUppercase'
);
$form_validators_regexp = array(
		'Email' => 'isEmail',
		'LetterNumberUnderscore' => '/^[0-9a-zA-Z_]+.{min,max}$/',
		'LettersAndNumbers' => '/^[0-9a-zA-Z]+.{min,max}$/',
		'OnlyLetters' => '/^[a-zA-Z\']+.{min,max}$/',
		'Numeric' => '/^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/',
		'Lowercase' => '/^[0-9a-z]+.{min,max}$/',
		'Uppercase' => '/^[0-9a-z]+.{min,max}$/',
		'Date(YYYY-mm-dd)' => 'isDate',
		'creditCard' => '^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$',
		'Phone' => '/^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/',
		'Ipv4' => 'isIpv4',
		'Url' => 'isUrl',
		'OnlyNumbersAndSpace' => '/^[0-9\ ]+.{min,max}$/',
		'OnlyLettersAndSpace' => '/^[a-zA-Z\ \']+.{min,max}$/',
		'OnlyLettersAndUnderscore' => '/^[a-zA-Z\_]+.{min,max}$/',
		'AtLeastOneNumberOneLowercaseOneUppercase' => '/((?=.*[A-Z])(?=.*[a-z])(?=.*\d)).{min,max}$/'
);
$form_validators_js = array(
		'Email' => 'email',
		'LetterNumberUnderscore' => 'LetterNumberUnderscore',
		'LettersAndNumbers' => 'onlyLetterNumber',
		'OnlyLetters' => 'onlyLetter',
		'Numeric' => 'onlyNumber',
		'Lowercase' => 'lowercase',
		'Uppercase' => 'uppercase',
		'Date(YYYY-mm-dd)' => 'date',
		'creditCard' => 'creditCard',
		'Phone' => 'phone',
		'Ipv4' => 'ipv4',
		'Url' => 'url',
		'OnlyNumbersAndSpace' => 'onlyNumberSp',
		'OnlyLettersAndSpace' => 'onlyLetterSp',
		'OnlyLettersAndSpace' => 'onlyLetterUn',
		'AtLeastOneNumberOneLowercaseOneUppercase' => 'AtLeastOneNumberOneLowercaseOneUppercase'
);

$form_validators_js_ajax = array(
		'username_already_exists' => 'username_already_exists',
		'email_already_exists' => 'email_already_exists'
);
?>