<script>
	var id=0;
	window.onload = function(){
		updateChat();
		setInterval('updateChat()', 4000) ;
	} 
</script>
<div id='chat_content'>
</div>
<div>
	<textarea id='message' cols='40' rows='3' name='message'></textarea>
</div>
<div>
	<input type='button' name='send_msg' value='Отправить' onClick='new_message()'/>
</div>

