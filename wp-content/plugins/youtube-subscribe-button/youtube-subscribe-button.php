<?php 
/*
Plugin Name: YouTube Subscribe Button
Plugin URI: http://www.skipser.com/test/youtube-subscribe-button
Description: Adds YouTube channel subscribe button to your site.
Version: 1.1.0
Author: Arun
Author URI: http://www.skipser.com
License: GPL3
*/

/*  
* 	Copyright (C) 2011  Skipser
*	http://skipser.com
*	http://www.skipser.com/test/youtube-subscribe-button
*
*	This program is free software: you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation, either version 3 of the License, or
*	(at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/********************************************************************/
/*                                                                  */
/*                         Global variables                         */
/*                                                                  */
/********************************************************************/

$USERID = '';
$DEBUG_ENABLED = 'false';

/********************************************************************/
/*                                                                  */
/*            Do not change anything below this.                    */
/*                                                                  */
/********************************************************************/

define( 'YOUTUBE_SUBSCRIBE_BUTTON_CURRENT_VERSION', '1.0.0' );
define( 'YOUTUBE_SUBSCRIBE_BUTTON_DEBUG', false);

function youtubeSubscribeButton($channel, $layout='default', $theme='') {
	global $CHANNEL, $LAYOUT, $THEME;

	if (preg_match('/youtubesubscribedebug=true/s', $_SERVER['REQUEST_URI'])) {
		$DEBUG_ENABLED='true';
	}

	$CHANNEL=$channel;
	if ($CHANNEL == '') {
?>
	Please give a valid YouTubechannel name or id
<?php
	}
	$LAYOUT=$layout;
	$THEME=$theme;

	$layout_code='data-layout="'.$LAYOUT.'"';
	$theme_code='';
	if ($THEME !='') {
		$theme_code='data-theme="'.$THEME.'"';
	}
	$channel_code='data-channel="'.$CHANNEL.'"';
	if(preg_match("/UC[^\"&?\/ ]{22}/", $CHANNEL)) {
		$channel_code='data-channelid="'.$CHANNEL.'"';
    }

	$youtube_subscribe_butt= <<<EOT
<div class="g-ytsubscribe" $channel_code $layout_code $theme_code></div>
<div id="youtubebuttcredit"><a href="http://www.youtubesubscribe.skipser.com"><strong>YouTube subscribe button</strong></a> by <a href="http://www.skipser.com"><strong>Skipser</strong></a></div>
<script type='text/javascript'>document.getElementById("youtubebuttcredit").style.display="none";window.___gcfg = {lang: 'en'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>
EOT;

	echo $youtube_subscribe_butt;

}


class YoutubeSubscribeButtonWidget extends WP_Widget {
	/** constructor */
	function YoutubeSubscribeButtonWidget() {
		parent::WP_Widget(false, $name = 'YouTube Subscribe Button');
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['htxt']);
		?>
			<?php echo $before_widget; ?>
				<?php if ( $title ) echo $before_title . $title . $after_title; ?>
				<?php youtubeSubscribeButton($instance['channelid'], $instance['layout'], $instance['theme']); ?>
			<?php echo $after_widget; ?>
		<?php
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['htxt'] = strip_tags($new_instance['htxt']);
		$instance['channelid'] = strip_tags($new_instance['channelid']);
		$instance['layout'] = strip_tags($new_instance['layout']);
		$instance['theme'] = strip_tags($new_instance['theme']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

		$channelid=''; $layout=''; $theme=''; $htxt='';

		if ($instance) {
			$channelid = esc_attr($instance['channelid']);
			$layout = esc_attr($instance['layout']);
			$theme = esc_attr($instance['theme']);
			$htxt = esc_attr($instance['htxt']);
		} else {
			$defaults = array('channelid' => '', 'layout' => 'default', 'theme' => '');
			$instance = wp_parse_args( (array) $instance, $defaults );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('htxt'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('htxt'); ?>" name="<?php echo $this->get_field_name('htxt'); ?>" type="text" value="<?php echo $htxt; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('channelid'); ?>"><?php _e('YouTube Channnel Id or Name:'); ?></label> 
			<label><br/><a href="http://www.youtube.com/account_advanced">Click here</a> to find out your YouTube Id.</label>
			<input class="widefat" id="<?php echo $this->get_field_id('channelid'); ?>" name="<?php echo $this->get_field_name('channelid'); ?>" type="text" value="<?php echo $channelid; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout:'); ?></label> 
			<select class="select" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" >
				<option <?php if($instance['layout'] == 'default') { echo 'selected="selected"'; } ?>>default</option>
				<option <?php if($instance['layout'] == 'full') { echo 'selected="selected"'; } ?>>full</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('theme'); ?>"><?php _e('Theme:'); ?></label> 
			<select class="select" id="<?php echo $this->get_field_id( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>" >
				<option <?php if($instance['theme'] == 'default') { echo 'selected="selected"'; } ?>>default</option>
				<option <?php if($instance['theme'] == 'dark') { echo 'selected="selected"'; } ?>>dark</option>
			</select>
		</p>
		<?php 
	}

} 

// register YouTybe widget
add_action('widgets_init', create_function('', 'return register_widget("YoutubeSubscribeButtonWidget");'));

?>
