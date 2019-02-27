<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class YTWD_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
                false, $name = __('YouTube WD', 'ytwd'), array('description' => __('YouTube WD', 'ytwd'))
        );
    }

    
    public function widget($args, $instance) {
        $markup = '';
        extract($args);

        //Output before widget stuff
        echo $before_widget;
        if($instance["title"]){
            echo "<p>".$instance["title"]."</p>";
        }
        if($instance["text_above_embed"]){
            echo "<p>".$instance["text_above_embed"]."</p>";
        }
		$params = array();
		$params ['item'] = $instance['item'];
		$params ['width'] = $instance['width'];
		$params ['height'] = $instance['height'];
		$params ['id'] = $widget_id;
		$params ['widget'] = true;
	     
        require_once(YTWD_DIR . '/includes/frontend_ytwd.php');   	
        $view = new Frontend_ytwd($params);
        $view->execute();
        
		if($instance["text_below_embed"]){
            echo "<p>".$instance["text_below_embed"]."</p>";
        }
        //Output after widget stuff
        echo $after_widget;
    }
	// update
    public function update($new_instance, $old_instance) {

        $instance = $old_instance;		
		$instance['title'] = esc_html( $new_instance['title'] ) ;
		$instance['item'] = esc_html( $new_instance['item'] ) ;
		$instance['width'] = esc_html( $new_instance['width'] );
		$instance['height'] = esc_html( $new_instance['height'] );            
		$instance['text_above_embed'] = esc_html( $new_instance['text_above_embed'] );
		$instance['text_below_embed'] = esc_html( $new_instance['text_below_embed'] ) ;

        return $instance;
    }
	// admin form
   	public function form( $instance ) {		
		$title = isset($instance[ 'title' ]) ? $instance[ 'title' ] : "";
		$item = isset($instance[ 'item' ]) ? $instance[ 'item' ] : "";
		$width = isset($instance[ 'width' ]) ? $instance[ 'width' ] : "100";
		$height = isset($instance[ 'height' ]) ? $instance[ 'height' ] : "150";
		$text_above_embed = isset($instance[ 'text_above_embed' ]) ? $instance[ 'text_above_embed' ] : "";
		$text_below_embed = isset($instance[ 'text_below_embed' ]) ? $instance[ 'text_below_embed' ] : "";
		
		$embed_rows = $this->get_widget_admin_data();

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', "ytwd" ); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'item' ); ?>"><?php _e( 'Select Embed', "ytwd" ); ?>:</label><br> 
			<select id="<?php echo $this->get_field_id( 'item' ); ?>" name="<?php echo $this->get_field_name( 'item' ); ?>" style=" width: 100%;">
				<?php 
					foreach($embed_rows as $embed_row){						
						$selected = esc_attr( $item ) ==  $embed_row->id ? "selected" : "";
						echo '<option value="'.$embed_row->id.'" '.$selected.'>'.$embed_row->title.'</option>';
					}				
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width', "ytwd" ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="number" value="<?php echo esc_attr( $width ); ?>" min="1"> px 
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height', "ytwd" ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>"  min="1"> px         
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text_above_embed' ); ?>"><?php _e( 'Text Above Embed', "ytwd" ); ?>:</label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'text_above_embed' ); ?>" name="<?php echo $this->get_field_name( 'text_above_embed' ); ?>" ><?php echo esc_attr( $text_above_embed ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'text_below_embed' ); ?>"><?php _e( 'Text Below Embed' , "ytwd"); ?>:</label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'text_below_embed' ); ?>" name="<?php echo $this->get_field_name( 'text_below_embed' ); ?>" ><?php echo esc_attr( $text_below_embed ); ?></textarea>
		</p>
	
		<?php 
	}

   	
	private function get_widget_admin_data(){
		global $wpdb;
		// get embeds
		$embeds = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "ytwd_youtube WHERE published = '1'  ORDER BY id ");
		return $embeds;
	}

}

add_action('widgets_init', create_function('', 'register_widget("YTWD_Widget");'));  



