<?php
abstract class Table{
	
	protected $db;
        protected $table_name;
        protected $qry;
        protected $params = array();
    
	function __construct($db, $table_name){
                $this->db = $db;
		$this->table_name = $table_name;
	}
		
	function getLastInsertId(){
		return $this->db->lastInsertId();
	}
                
        function execute(){
                //echo "<br>";
		//echo $this->qry;
		$statement = $this->db->prepare($this->qry);
		$i = 1;
		
		if(!empty($this->params)){
			foreach($this->params as &$value){
				//echo $value . ' ';
				$statement->bindValue($i, $value);
				$i ++;
			}
		}
                
		unset($this->params);
                
		$res = $statement->execute();
                
                if(!$res){ 
                    $message = $statement->errorInfo(); 
                    throw new Exception($message[2]);
                }
                
		return $statement;
	}
	
        function query(){
		return $this->execute()->fetchAll(PDO::FETCH_ASSOC);
	}
        
	function select(){
                $fields = func_get_args();
		$this->qry = 'SELECT ' . implode(', ', $fields) . ' FROM ' . $this->table_name;
                return $this;
	}
        
        function insert($params = NULL){
		$this->qry =  'INSERT ' . $params . ' INTO ' . $this->table_name;
                return $this;
	}
        
        function update($params = NULL){
            $this->qry =  'UPDATE ' . $params . $this->table_name;
            return $this;
        }
	
        function set(){
            $args = func_get_args();
            $isFirst = true;
            foreach($args as $value){
                if(!$isFirst) $this->params[] = $value;
                $isFirst = false;
            }
            $this->qry .= ' SET ' . $args[0];
            return $this;
        }
        
        function delete($params = NULL){
            $this->qry =  'DELETE ' . $params . 'FROM ' . $this->table_name;
            return $this;
        }
        
	function where(){
                $args = func_get_args();
                $isFirst = true;
                foreach($args as $value){
                    if(!$isFirst) $this->params[] = $value;
                    $isFirst = false;
                }
                $this->qry .= ' WHERE ' . $args[0];
                return $this;
	}
	
	function join($type, $table_name, $condition = NULL){
		$this->qry .= ' ' . $type . ' JOIN ' . $table_name;
		if(!empty($condition)){
			$this->qry .= ' ON(' . $condition . ')';
		}
		return $this;
	}
        
        function orderBy($field){
           $this->qry .= ' ORDER BY ' . $field;
           return $this;
        }
        
	
}

?>
