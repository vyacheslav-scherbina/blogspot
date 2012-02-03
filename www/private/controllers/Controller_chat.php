<?php

class Controller_chat extends Controller_parent{
	
	function view(){
		$this->render('chat.tpl');
	}
	
	function new_message(){
		$message = @$this->request->get('message');
		$this->getModel()->chat->insert()->set('message=?, date=?, owner_id=?', $message, date('Y-m-d H:i:s'), $_SESSION['id'])->execute();
	}
	
	function get_json($last_message_id) {
                $data = $this->getModel()
                        ->chat
                        ->select('chat.id, message, date, user.first_name, user.last_name')
                        ->join('INNER', 'user', 'user.id=chat.owner_id')
                        ->where('chat.id>?', $last_message_id)
                        ->orderBy('date')
                        ->query(); 
		$v = new View('');
		$data = $v->filter($data);
		
		echo $v->json($data);
	}
}

?>
