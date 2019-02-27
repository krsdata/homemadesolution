<?php
class Frontend_base_ytwd{

    public $task;
    public $params;

	public function __construct($params) {
        if(isset($_GET["f_p"]) && $_GET["f_p"] == 1){
            error_reporting(0);
        }
        $this->task = isset($_REQUEST["task"]) ? $_REQUEST["task"] : 'display';
        $this->params = $params;
	}
    
    public function execute(){
        $task = $this->task;
        if(method_exists($this, $task)){
            $this->$task();
        }
    }



}


?>