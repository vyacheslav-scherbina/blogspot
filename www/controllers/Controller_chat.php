<?php

class Controller_chat extends Controller{
	
	function view(){
		$this->render('chat.tpl');
	}
	
	function new_message(){
		$message = @$this->request->get('message');
		$this->getModel()->chat->insert(array('message' => $message, 'date' => date('Y-m-d H:i:s'), 'owner_id' => $_SESSION['id']))->execute();
	}
	
	function get_json($last_message_id = 0) {
		if(empty($last_message_id)) $last_message_id = 0;
		$qry = 'SELECT chat.id, message, date, user.first_name, user.last_name FROM chat INNER JOIN user ON(user.id=chat.owner_id) WHERE chat.id>? ORDER BY date';
		$statement = $this->getModel()->chat->db->prepare($qry);
		$statement->bindValue(1, $last_message_id);
		$s = $statement->execute();
		$s = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$v = new View('');
		$s = $v->filter($s);
		
		echo $v->json($s);
	}
}

?>
