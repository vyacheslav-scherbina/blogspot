function new_message(){
    var message = document.getElementById('message');

    if(message.value == ''){
        alert('Введите сообщение');
        return;
    }
    
    var request = getXmlHttp();
    request.onreadystatechange = function(){
        if (request.readyState == 4){
            if (request.status == 200){
                updateChat();
            }
        }
    }
    request.open('POST', '/chat/new_message', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    data = 'message=' + message.value;
    request.send(data);
    message.value='';
}

function updateChat(){
    var request = getXmlHttp();
    request.open('GET', '/chat/get_json/' + id, true);
    request.onreadystatechange = function() {
        if (request.readyState == 4){
            if (request.status == 200) {
                var response = eval('('+request.responseText+')');
                if(response == null) return;
                parent = document.getElementById('chat_content');
                for(var i=0; i<response.length; i++) {
					parent.innerHTML += '<div>' + response[i].first_name + ' ' + response[i].last_name + ' ' + response[i].date;
					parent.innerHTML += '<div class="chat_message_content">' + response[i].message + '</div>';
					id=response[i].id;   
                }
            }
        }
    }
    request.send(null);
}

function getXmlHttp() {
  if (typeof XMLHttpRequest === 'undefined') {
    XMLHttpRequest = function() {
      try { return new ActiveXObject("Msxml2.XMLHTTP.6.0"); }
        catch(e) {}
      try { return new ActiveXObject("Msxml2.XMLHTTP.3.0"); }
        catch(e) {}
      try { return new ActiveXObject("Msxml2.XMLHTTP"); }
        catch(e) {}
      try { return new ActiveXObject("Microsoft.XMLHTTP"); }
        catch(e) {}
      throw new Error("This browser does not support XMLHttpRequest.");
    };
  }
  return new XMLHttpRequest();
}
