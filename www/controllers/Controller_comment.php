<?php
class Controller_comment extends Controller_parent{
 
    function create($message_id){
        if($this->request->getRequestMethod() == 'POST'){
            $comment_text = $this->request->get('comment_text');
            $tmp = $this->getModel()->message->select('id')->where('id=?', $message_id)->query();
            if(!empty($tmp[0]['id']) && !empty($comment_text)){
		$this->getModel()->comment->insert()->set('text=?, message_id=?, owner_id=?', $comment_text, $message_id, $_SESSION['id'])->execute();
            }
        }
        $url = absolute_path . 'message/view/' . $message_id;
        $this->redirect($url);
    }
    
}

?>

