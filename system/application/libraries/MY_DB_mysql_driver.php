<?php

class MY_DB_mysql_driver extends CI_DB_mysql_driver {
	var $dblog;
	var	$user_id;
	var $CI;
	var $container_id ;
	var $action;
	var $table;
	var $insert_id;
	var $sql_string;
	
	function __construct($params){
    	parent::__construct($params);
    	log_message('debug', 'Extended DB driver class instantiated!');
    	$this->dblog = $this->dbprefix."logs";
    	$this->CI =& get_instance();
   	}
  	
  	/* harusnya ngambil dr session user id , ga bisa ambil */
  	function setUserId($id){
		$this->user_id  = $id;
  	}
	
	function setTableName($tablename){
		$this->table=$tablename;
	}
	
	function setContainerId($id){
		$this->container_id = $id;
	}
	
	function setAction($action){
		$this->action = $action;
	}
	
	/* Only logs table base on config */
	function insertLogs(){
		$toLog = $this->CI->config->item('history_logs');
		//$arrTable = $this->CI->config->item('table_to_log');
		$arrTable = $this->CI->config->item('table_notto_log');
		if ($toLog && !in_array($this->table, $arrTable)) {
			$sql = "insert into ".$this->dblog . " ( ";
	  		$sql .= " logs_table_name, logs_container_id, logs_action, logs_timestamp, logs_action_by,logs_sql_string ";
	  		$sql .= " )  values ( ";
	  		$sql .= " '".$this->table."','".$this->container_id."' , ";
	  		$sql .= " '".$this->action."','".date("Y-m-d H:i:s")."' , '".$this->user_id."' , '".$this->escape_str($this->sql_string)."'  ) ";
	  		
  			parent::_execute($sql);
  		}
	}
  	function get($table = '', $limit = null, $offset = null) {
  	
		$res = parent::get($table,$limit,$offset);
		
		return $res;
  	}

  	/*
  	Extend insert , and log into table logs
  	*/
  	function insert($table = '', $set = NULL) {
		$result = parent::insert($table,$set);
  		$sql = parent::last_query();
  		$this->sql_string = $sql;
  		
  		$this->insert_id = parent::insert_id();
  		$this->setContainerId($this->insert_id );
  		
  		$this->setAction('insert');
		$this->setTableName($table);
  		$this->insertLogs();

  		return $result;
  	}
  	
  	function insert_id(){
  		return $this->insert_id;
  	}
  	
  	/*
  	Extend insert , and log into table logs
  	*/
  	function update($table = '',  $set = NULL, $where = NULL, $limit = NULL){
		$result = parent::update($table,$set,$where,$limit);
  		$sql = parent::last_query();
  		$this->sql_string = $sql;
  		$this->setAction('update');
  		$this->setTableName($table);
  		$this->insertLogs();
  	
  		return $result;
  	}
  	
  	/*
  	Extend insert , and log into table logs
  	*/
	function delete($table = '', $where = '', $limit = NULL, $reset_data = TRUE) {
		$result = parent::delete($table,$where,$limit,$reset_data);
  		
  		$this->setAction('delete');
  		$this->setTableName($table);
  		$this->insertLogs();
  	
  		return $result;
  	}
  	
  	function where($key, $value = NULL, $escape = TRUE) {
  		$result = parent::where($key,$value,$escape);
  		
  		$this->setContainerId($value);
  		return $result;
  	}

}
?>