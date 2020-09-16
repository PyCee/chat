function addChatMessage(message){
    chatDisplay.innerHTML += message;
    chatDisplay.scrollTop = chatDisplay.scrollHeight;
}
function handleEvent(event){
    switch(event.type){
        case "user_joined":
            addChatMessage("<p style='margin: 0px;'>" + 
                event.username + " has joined the chat</p>");
            break;
        case "user_left":
            addChatMessage("<p style='margin: 0px;'>" + 
                event.username + " has left the chat</p>");
            break;
        case "message_sent":
            addChatMessage("<p style='margin: 0px;'>" + 
                event.username + ": " + event.message + "</p>");
            break;
        default:
            console.log("Unrecognized event type: '" + event.type);
            break;
    }
    // The event list is ordered by timestamp ASC, 
    //   so the last event processed will be the most recent
    lastEventTimestamp = event.timestamp;
}
function ajaxHandleNewEvents(timestamp){
    $.ajax({
        url: "getNewEvents.php",
        type: "post",
        data: "timestamp="+timestamp,
        dataType: "json"
    }).done(function(response, status, XHR){
        for(var key in response){
            handleEvent(response[key]);
        }
    }).fail(function(response, status, XHR){
        console.error("Failed to get new events: " + response);
    });
}
function ajaxEnterChat(username){
    $.ajax({
        url: "enterChat.php",
        type: "post",
        data: "username="+username
    }).done(function(response, status, XHR){
        lastEventTimestamp = response;
    }).fail(function(response, status, XHR){
        console.error("Failed to enter chat: " + response);
    });
}
function ajaxLeaveChat(username){
    $.ajax({
        url: "leaveChat.php",
        type: "post",
        data: "username="+username,
        async: false
    }).fail(function(response, status, XHR){
        console.error("Failed to leave chat: " + response);
    });
}
function ajaxSendMessage(username, message) {
    $.ajax({
        url: "sendMessage.php",
        type: "post",
        data: "username="+username+"&message="+message
    }).fail(function(response, status, XHR){
        console.error("Failed to send message: " + response);
    });
}
function ajaxUpdateUserList(){
    $.ajax({
        url: "getUserList.php",
        type: "post",
        dataType: "json"
    }).done(function(response, status, XHR){
        var displayString = "";
        for(key in response){
			displayString += "<div>" + response[key]['username'] + "</div>";
        }
        document.getElementById("nameList").innerHTML = displayString;
    }).fail(function(response, status, XHR){
        console.error("Failed to get user list: " + response);
    });
}
function ajaxQueryUserActive(username) {
    $.ajax({
        url: "isUserActive.php",
        type: "post",
        data: "username="+username
    }).done(function(response, status, XHR){
        if(response == 1){
            $('#usernameInUseMessageBox').show();
            usernameInUse = true;
        } else {
            $('#usernameInUseMessageBox').hide();
            usernameInUse = false;
        }
    }).fail(function(response, status, XHR){
        console.error("Failed to query user active: " + response);
    });
}