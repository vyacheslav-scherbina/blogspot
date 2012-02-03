var id;

$(document).ready(function(){
	$("#message").focus();
	updateChat(0);	
	setInterval('updateChat(id)', 4000);
});

$("#btn_send").click(function(){
	new_message();
});

$("#message").keypress(function(event){
	if(event.which !== 10) return;
	event.preventDefault();
	new_message();
});

function updateChat(param){
	
	$.get(
		"/chat/get_json/" + param,		
		function(data){
			var chat_content = $("#chat_content");
			if(data == null) return;
			leng = data.length;
			
			for(var i = 0; i < leng; i++) {
				chat_content.append(					
					"<div>" + data[i].first_name + " " + data[i].last_name + " " + data[i].date + "</div>" + 
					"<div class='chat_message_content'>" + data[i].message + "</div>"   
				)
				
			}
			
			chat_content.scrollTop(chat_content[0].scrollHeight);
			id = data[leng-1].id;
		},
		"json"
	);
	
}

function new_message(){
	
	var message = $("#message");
	if(message.val() == '') return;
	data = 'message=' + message.val();
	$.post(
		"/chat/new_message/",
		data,
		function(){
			updateChat(id);
		}
	);
	
    message.val('');
	message.focus();
	
}
