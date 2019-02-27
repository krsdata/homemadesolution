<?php

class Shortcode_ytwd extends Admin_base_ytwd{

    
    /*display function list */
    public function display(){
  
        $shortcodes = $this->get_shortcodes();
        $max_short_code_id = $this->get_shortcode_max_id();
        
		wp_print_scripts('jquery');
		$embeds = $this->get_embeds();

        require_once(YTWD_DIR . '/views/admin/view_shortcode_ytwd.php'); 
    } 
    
 	public function save(){		
		global $wpdb;
		$data = array();
		$insert = isset($_REQUEST["insert"]) ? esc_html(stripslashes($_REQUEST["insert"])) : "";
		$data["id"]= isset($_REQUEST["id"]) ? (int) esc_html(stripslashes($_REQUEST["id"])) : "";
		$data["tag_text"]= isset($_REQUEST["tag_text"]) ? esc_html(stripslashes($_REQUEST["tag_text"])) : "";

		$format = array('%d','%s');
		if( $insert ){		
			$wpdb->insert( $wpdb->prefix . "ytwd_shortcodes", $data, $format );
		}
		else{
			$where = array("id"=> $data["id"]);
			$where_format = array('%d');
			$wpdb->update( $wpdb->prefix . "ytwd_shortcodes", $data, $where, $format, $where_format );
		}

		$this->display();	
	}   
   

    
	public function get_embeds(){
		global $wpdb;
		// get rows
		$query = "SELECT id, title  FROM " . $wpdb->prefix . "ytwd_youtube WHERE published = '1' ORDER BY id";				
		$rows = $wpdb->get_results($query);
		$embeds = array();
		foreach($rows as $row){
			$embeds[$row->id] = $row->title;
		}
		return $embeds;	
	}	

    public function get_shortcodes(){
        global $wpdb;
        // get rows
        $query = "SELECT *  FROM " . $wpdb->prefix . "ytwd_shortcodes ORDER BY id ASC";				
        $rows = $wpdb->get_results($query);
        return $rows;
    }	

    public function get_shortcode_max_id() {
        global $wpdb;
        $max_id = $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "ytwd_shortcodes");
        return $max_id;
    }    



}


?>