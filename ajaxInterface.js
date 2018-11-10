function addChatMessage(htmlString){
    chatDisplay.innerHTML += "<p style='margin: 0px;'>" + htmlString + "</p>";
    chatDisplay.scrollTop = chatDisplay.scrollHeight;
}
function sendMessage () {
    var messageEntry = document.getElementById("messageEntry");
    var message = messageEntry.value;
    if(message.length == 0){
        return;
    }
    messageEntry.value = "";

    sendRequest = new XMLHttpRequest();
    
    sendRequest.onreadystatechange = function () {
        if((sendRequest.readyState == 4) && (sendRequest.status == 200)) {
            if(sendRequest.responseText.length != 0) {
                console.log(sendRequest.responseText);
            }
        }
    };
    
    sendRequest.open("POST", "sendMessage.php", true);
    sendRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    sendRequest.send("username=" + username + "&message="+message);
    //console.log("Sent: " + username + " : " + message);
}

function checkForNewMessage () {
    updateChatRequest = new XMLHttpRequest();
    updateChatRequest.onreadystatechange = newMessageCallback;
    
    updateChatRequest.open("POST", "checkForNewMessages.php", true);
    updateChatRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    updateChatRequest.send("lastTimestamp="+lastTimestamp);
    //console.log("Sent update request");
}
function newMessageCallback() {
    if ((updateChatRequest.readyState == 4) && (updateChatRequest.status == 200)) {
        var messageString = updateChatRequest.responseText;
        var messages = JSON.parse(messageString);
        if(messages.length > 0){
            chatDisplay = document.getElementById("chatDisplay");
            lastTimestamp = messages[messages.length - 1].timestamp;
            for(var i = 0; i < messages.length; ++i){
                addChatMessage(messages[i].username + ": " + messages[i].message);
            }
        }
    }
}

function updateNameList() {
    updateNameListRequest = new XMLHttpRequest();
    updateNameListRequest.onreadystatechange = updateNameListCallback;
    
    updateNameListRequest.open("POST", "nameQuery.php", true);
    updateNameListRequest.send();
}
function updateNameListCallback(){
    if ((updateNameListRequest.readyState == 4) && (updateNameListRequest.status == 200)) {
        var response = updateNameListRequest.responseText;
        var names = JSON.parse(response);
        
        // Has a user entered the chat
        for(var i = 0; i < names.length; i++){
            if(!currentNameList.includes(names[i])){

                currentNameList.push(names[i]);

                // Output event only if the entered the chat after the user
                var selfNameIndex = currentNameList.indexOf(username);
                if(currentNameList.indexOf(names[i], selfNameIndex+1) > 0){
                    var arriveMessage = "<span style='color: grey;'>" + 
                        names[i] + " has joined the chat</span>";
                    addChatMessage(arriveMessage);
                }
            }
        }

        // Has a user left the chat
        for(var i = currentNameList.length - 1; i >= 0 ; i--){
            if(!names.includes(currentNameList[i])){
                var leaveMessage = "<span style='color: grey;'>" + 
                    currentNameList[i] + " has left the chat</span>";
                currentNameList.splice(i, 1);
                addChatMessage(leaveMessage);
            }
        }
        
        var displayString = "";
        for(var i = 0; i < names.length; ++i) {
            displayString += "<p style='margin: 0px;'>" + currentNameList[i] + "</p>";
        }
        document.getElementById("nameList").innerHTML = displayString;
    }
}

function addSelfToNameList() {
    var addSelfRequest = new XMLHttpRequest();
    addSelfRequest.onreadystatechange = function(){
        if((addSelfRequest.readyState == 4) && (addSelfRequest.status == 200)) {
            if(addSelfRequest.responseText.length != 0) {
                lastTimestamp = addSelfRequest.responseText;
            }
        }
    };
    addSelfRequest.open("POST", "addSelf.php", true);
    addSelfRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    addSelfRequest.send("username="+username);
}
function removeSelfFromNameList() {
    var removeSelfRequest = new XMLHttpRequest();
    removeSelfRequest.onreadystatechange = function(){
        if((removeSelfRequest.readyState == 4) && (removeSelfRequest.status == 200)) {
            if(removeSelfRequest.responseText.length != 0) {
                console.log(removeSelfRequest.responseText);
            }
        }
    };

    // Leave this synchronous so teardown waits for this to send
    removeSelfRequest.open("POST", "removeUser.php", false);
    removeSelfRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    removeSelfRequest.send("username="+username);
}