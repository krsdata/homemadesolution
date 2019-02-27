<?php

class Admin_base_ytwd{

    public $page;
    public $task;
    protected $per_page = 10;

	public function __construct() {
        $this->page = isset($_REQUEST["page"]) &&  $_REQUEST["page"] ? $_REQUEST["page"] : 'settings_ytwd';
        $this->task = isset($_REQUEST["task"]) &&  $_REQUEST["task"] ? $_REQUEST["task"] : 'display';

        if(!isset($_REQUEST["action"])){
            $user = get_current_user_id();
            $screen = get_current_screen();

            if($screen){
                $option = $screen->get_option('per_page', 'option');

                $this->per_page = get_user_meta($user, $option, true);

                if ( empty ( $this->per_page) || $this->per_page < 1 ) {
                  $this->per_page = $screen->get_option( 'per_page', 'default' );

                }
            }
            if($this->page == "youtube_ytwd" || $this->page == "settings_ytwd" || $this->page == "analytics_ytwd" || $this->page == "themes_ytwd" ){
				if(ytwd_get_option("api_key") == "" ){
					ytwd_api_key_notice();
				}
            }
			if($this->page == "youtube_ytwd" || $this->page == "settings_ytwd" || $this->page == "uninstall_ytwd" || $this->page == "overview_ytwd"){
				ytwd_upgrade_pro();
			}            

            ytwd_print_message();
        }

	}

    public function per_page(){
		return $this->per_page;

	}
    public function execute(){
        $task = $this->task;
        if(method_exists($this, $task)){
            $this->$task();
        }
    }

    public function remove($table_name = ""){
		global $wpdb;
		$ids = isset($_POST["ids"]) ? $_POST["ids"] :(isset($_POST["id"]) ? array($_POST["id"]) :  array());
		if($table_name == ""){
			$page = $this->page;
			$page = explode("_",$page);
			$table_name = $wpdb->prefix . "ytwd_".$page[0];

		}
		if(empty($ids) === false){
            $msg = __("Item(s) Succesfully Removed.","ytwd");
			foreach($ids as $id){
                $id = (int)$id;
				$where = array("id" => $id);
                $where_format = array('%d');
                if($this->page == 'themes_ytwd'){
                    $where["default"] = 0;
                    $where_format[] = "%d";
                    $msg = __("You Can Not Remove Default Theme.","ytwd");
                }
				$wpdb->delete($table_name, $where, $where_format);
			}
			ytwd_message($msg,'updated');
		}
		else{
			ytwd_message(__("You must select at least one item.","ytwd"),'error');
		}
        $this->display();
    }
	public function publish($table_name = ""){
		global $wpdb;
		if(isset($_POST["ids"])){
			$ids = $_POST["ids"] ;
		}
		elseif(isset($_POST["current_id"])){
			$ids = array($_POST["current_id"]) ;
		}
		else{
			$ids = array();
		}

		if(empty($ids) === false && isset($_POST["publish_unpublish"])){
			$data = array("published" => (int)$_POST["publish_unpublish"]);
			$where_format = array('%d');
			$format = array('%d');


			if($table_name == ""){
				$page = $this->page;
				$page = explode("_",$page);
				$table_name = $wpdb->prefix . "ytwd_".$page[0];

			}

			foreach ($ids as $id){
				$where = array("id"=>(int)$id);
				$wpdb->update($table_name, $data, $where, $format, $where_format );

			}
		}

        $publish_unpublish = $_POST["publish_unpublish"] == 1 ? __("Published","ytwd") : __("Unpublished","ytwd");
        ytwd_message(__("Item(s) Succesfully ","ytwd").$publish_unpublish.".",'updated');
        $this->display();

	}
    protected function duplicate($table_name_widthout_prefix = ""){
        global $wpdb;
		if(isset($_POST["ids"])){
			$ids = $_POST["ids"] ;
		}

        if($table_name_widthout_prefix == ""){
			$page = explode("_",$this->page);
			$table_name_widthout_prefix =  "ytwd_".$page[0];
		}

        $table_name = $wpdb->prefix . $table_name_widthout_prefix;
        $columns = YTWD_DB::get_columns($table_name_widthout_prefix);
		$column_types = YTWD_DB::column_types($table_name_widthout_prefix);
        if(empty($ids) === false){
            foreach($ids as $id){

                $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE id = '%d'", $id ));
                $data = array();
                $format = array();
                foreach($columns as $column_name){
                    $data[$column_name] = esc_html(stripslashes($row->$column_name));
                    $format[] = $column_types[$column_name];
                }
				if($table_name_widthout_prefix == 'ytwd_youtube'){
					$max_shortcode_id = $wpdb->get_var("SELECT MAX(id) FROM ". $wpdb->prefix . "ytwd_shortcodes");
					$max_shortcode_id = $max_shortcode_id + 1;
					$data["shortcode_id"] = $max_shortcode_id ;
				}				
                $data["id"] = "";
                $wpdb->insert( $table_name, $data, $format );
				
				if($table_name_widthout_prefix == 'ytwd_youtube'){
					
					$last_id = $wpdb->get_var("SELECT MAX(id) FROM ". $wpdb->prefix . "ytwd_youtube");
					$data = array();
					$data["tag_text"] = 'id='.$max_shortcode_id.' item='.$last_id;
					$format = array('%s');
					$wpdb->insert( $wpdb->prefix . "ytwd_shortcodes", $data, $format );					
				}
            }
        }

        ytwd_message(__("Item Succesfully Duplicated.","ytwd"),'updated');
		$this->display();

    }
	public function cancel(){
		ytwd_redirect("admin.php?page=".$this->page);
	}

    public function save_api_key(){
        $settings = json_decode(get_option("ytwd_settings"), true);

        $settings["api_key"] =  isset($_REQUEST["ytwd_api_key_general"]) ? esc_html(stripslashes($_REQUEST['ytwd_api_key_general'])) : '';

        $json_data = json_encode($settings);
        update_option("ytwd_settings", $json_data);
        ytwd_redirect("admin.php?page=".$this->page);
    }



}


?>
