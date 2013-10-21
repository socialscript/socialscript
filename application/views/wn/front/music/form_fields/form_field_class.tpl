validate[{if $form_field->required == '1'}required,{/if} {if
$form_field->validation !=
'0'}custom[{$form_validators_js[$form_field->validation]}]{/if} {if
$form_field->validation == 'numeric'} {if $form_field->min >
0},min[{$form_field->min}]{/if} {if $form_field->max >
0},max[{$form_field->max}]{/if} {elseif $form_field->validation ==
'date'} {if $form_field->min > 0},past[{$form_field->min}]{/if} {if
$form_field->max > 0},future[{$form_field->max}]{/if} {else} {if
$form_field->min > 0},minSize[{$form_field->min}]{/if} {if
$form_field->max > 0},maxSize[{$form_field->max}]{/if} {if
$form_field->validation_ajax ==
'username_already_exists'},ajax[ajaxUserCallPhp] {elseif
$form_field->validation_ajax ==
'email_already_exists'},ajax[ajaxEmailCallPhp]{/if} {/if}]
