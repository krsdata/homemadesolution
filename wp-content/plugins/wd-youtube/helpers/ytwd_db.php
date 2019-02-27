<?php

class YTWD_DB {
	////////////////////////////////////////////////////////////////////////////////////////
	// Events                                                                             //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constants                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Variables                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Constructor & Destructor                                                           //
	////////////////////////////////////////////////////////////////////////////////////////  
	////////////////////////////////////////////////////////////////////////////////////////
	// Public Methods                                                                     //
	////////////////////////////////////////////////////////////////////////////////////////
	public static function get_columns($table_name){
		global $wpdb;
		$query = "SHOW COLUMNS  FROM " . $wpdb->prefix . $table_name ;			
		$columns = $wpdb->get_col( $query , 0 );
		return 	$columns;	
	}

	public static function column_types($table_name){
		global $wpdb;		
		$query = "SHOW COLUMNS  FROM " . $wpdb->prefix . $table_name ;					
		$columns_data_types = $wpdb->get_results( $query );

	
		$data_types = array();
		foreach($columns_data_types as  $column){
            if(strpos($column->Type, "int") !== false || strpos($column->Type, "tinyint") !== false){
                $data_types[$column->Field] = '%d';
            }
            else if(strpos($column->Type, "varchar") !== false || strpos($column->Type, "text") !== false || strpos($column->Type, "longtext") !== false || strpos($column->Type, "date") !== false || strpos($column->Type, "datetime") !== false){
                $data_types[$column->Field] = '%s';
            }            

		}
			
		return 	$data_types;		
	
	}
	
	public static function get_row_by_id($id , $table_name = ""){
		global $wpdb;
        
		if($table_name == ""){
			$page = isset($_GET["page"]) ? $_GET["page"] : "youtube_ytwd";
			$page = explode("_",$page);
			$table_name =  "ytwd_".$page[0];		
		}

		if($id){
			$query = "SELECT * FROM ". $wpdb->prefix . $table_name ." WHERE id='%d'";			
			$row = $wpdb->get_row($wpdb->prepare($query, $id));
		}
		else{					
			$columns = self::get_columns($table_name);			
			$row = new stdClass();
			foreach($columns as $column){
				$row->$column = "";
			}
		}

		return $row;
	}

	////////////////////////////////////////////////////////////////////////////////////////
	// Getters & Setters                                                                  //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Private Methods                                                                    //
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	// Listeners                                                                          //
	////////////////////////////////////////////////////////////////////////////////////////
}

?>