<?
class Controller_tag extends Controller{
	
	function search($tag_id){
		$data['messages'] = $this->getModel()
			->message
			->select('message.id', 'message.topic', 'message.text')
			->innerJoin('message_tag', 'message.id=message_tag.message_id')
			->where('', "message_tag.tag_id=$tag_id")
			->query();
		
		$this->render('messages.tpl', $data);
	}
	
}
?>
