<?php
/***
 *  BetterFramework is BetterStudio framework for themes and plugins.
 *
 *  ______      _   _             ______                                           _
 *  | ___ \    | | | |            |  ___|                                         | |
 *  | |_/ / ___| |_| |_ ___ _ __  | |_ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 *  | ___ \/ _ \ __| __/ _ \ '__| |  _| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 *  | |_/ /  __/ |_| ||  __/ |    | | | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <
 *  \____/ \___|\__|\__\___|_|    \_| |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


/*
$wrapper = Better_Framework::html()->add( 'div' )->class( 'bf-clearfix bf-color-picker-container' );
$input   = Better_Framework::html()->add( 'input' )->type( 'text' )->name( $options['input_name'] )->class( 'bf-color-picker' );

if( isset( $options['input_class'] ) )
    $input->class($options['input_class']);

$preview = Better_Framework::html()->add( 'div' )->class( 'bf-color-picker-preview' );

if(  !empty( $options['value'] ) ) {
    $input->value( $options['value'] )->css('border-color', $options['value']);
    $preview->css( 'background-color', $options['value'] );
}

$wrapper->add( $input );
$wrapper->add( $preview );

echo $wrapper->display();  // escaped before
*/


/*
?>
<input type="text" class="bf-wp-color-picker color-picker <?php if(! empty($options['input_class']))  echo sanitize_html_class($options['input_class']) ?>" name="<?php
echo esc_attr($options['input_name'])
?>" value="<?php
if(!empty($options['value']))
	echo esc_attr($options['value'])
?>" data-alpha="true">
*/

?>

<div class="bs-color-picker-wrapper">
	<div class="bs-color-picker-stripe">
		<a class="wp-color-result" title="Select Color" data-current="Current Color"
		   style="<?php if ( ! empty( $options['value'] ) ) { ?> background-color: <?php echo esc_attr( $options['value'] ); } ?>"></a>
	</div>

	<input type="text" name="<?php
	echo esc_attr( $options['input_name'] )
	?>" value="<?php
	if ( ! empty( $options['value'] ) )
		echo esc_attr( $options['value'] )
	?>" class="bs-color-picker-value wpb_vc_param_value">
</div>