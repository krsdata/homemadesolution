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


// Default selected
$current = array(
	'key'    => '',
	'title'  => __( 'Chose an Icon', 'better-studio' ),
	'width'  => '',
	'height' => '',
	'type'   => '',
);

if ( isset( $options['value'] ) ) {

	if ( is_array( $options['value'] ) ) {

		if ( in_array( $options['value']['type'], array( 'custom-icon', 'custom' ) ) ) {
			$current['key']    = isset( $options['value']['icon'] ) ? $options['value']['icon'] : '';
			$current['title']  = bf_get_icon_tag( isset( $options['value'] ) ? $options['value'] : '' ) . ' ' . __( 'Custom icon', 'better-studio' );
			$current['width']  = isset( $options['value']['width'] ) ? $options['value']['width'] : '';
			$current['height'] = isset( $options['value']['height'] ) ? $options['value']['height'] : '';
			$current['type']   = 'custom-icon';
		} else {
			Better_Framework::factory( 'icon-factory' );

			$fontawesome = BF_Icons_Factory::getInstance( 'fontawesome' );

			if ( isset( $fontawesome->icons[ $options['value']['icon'] ] ) ) {
				$current['key']    = $options['value']['icon'];
				$current['title']  = bf_get_icon_tag( $options['value'] ) . $fontawesome->icons[ $options['value']['icon'] ]['label'];
				$current['width']  = ! empty( $options['value']['width'] ) ? $options['value']['width'] : '';
				$current['height'] = ! empty( $options['value']['height'] ) ? $options['value']['height'] : '';
				$current['type']   = 'fontawesome';
			}
		}

	} elseif ( ! empty( $options['value'] ) ) {

		Better_Framework::factory( 'icon-factory' );

		$fontawesome = BF_Icons_Factory::getInstance( 'fontawesome' );

		if ( isset( $fontawesome->icons[ $options['value'] ] ) ) {
			$current['key']    = $options['value'];
			$current['title']  = bf_get_icon_tag( $options['value'] ) . $fontawesome->icons[ $options['value'] ]['label'];
			$current['width']  = '';
			$current['height'] = '';
			$current['type']   = 'fontawesome';
		}

	}

}

$icon_handler = 'bf-icon-modal-handler-' . mt_rand();

?>
	<div class="bf-icon-modal-handler" id="<?php echo esc_attr( $icon_handler ); ?>">

		<div class="select-options">
			<span
				class="selected-option"><?php echo $current['title']; // escaped before in function that passes value to this ?></span>
		</div>

		<input type="hidden" class="icon-input" data-label=""
		       name="<?php echo esc_attr( $options['input_name'] ); ?>[icon]"
		       value="<?php echo esc_attr( $current['key'] ); ?>"/>
		<input type="hidden" class="icon-input-type" name="<?php echo esc_attr( $options['input_name'] ); ?>[type]"
		       value="<?php echo esc_attr( $current['type'] ); ?>"/>
		<input type="hidden" class="icon-input-height" name="<?php echo esc_attr( $options['input_name'] ); ?>[height]"
		       value="<?php echo esc_attr( $current['height'] ); ?>"/>
		<input type="hidden" class="icon-input-width" name="<?php echo esc_attr( $options['input_name'] ); ?>[width]"
		       value="<?php echo esc_attr( $current['width'] ); ?>"/>

	</div><!-- modal handler container -->
<?php

bf_enqueue_modal( 'icon' );
