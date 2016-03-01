// This file handles the chat operations on a box insatanc of a chat.

function ImInstance(user_id, other_id) {

    // Init local variables.
    this.user_id = user_id;
    this.other_id = other_id;
    this.boxId = user_id + '_' + other_id;
    this.firstime = true;
    this.prev_msg_id = -1;
    console.log("Chat instance created : " + this.user_id + ", " + this.other_id );

    // Init the chat instance, i.e. add event handler codes and stuffs.
    this.init = function() {
        var prototype = document.querySelector('#prototype_box_instance');
        var newBox = document.createElement('div');
        var im_instances = document.getElementById('im-instances');
        newBox.id = this.boxId;
        newBox.className = "im-instance";
        newBox.innerHTML = prototype.innerHTML;
        im_instances.appendChild(newBox);

        var title = newBox.querySelector('.title');
        var _this = this;
        title.addEventListener('click', function() {
            _this.toggleInstance.call(_this);
        });

        this.getMessages();
    };

    // Expands or collapses the chat box when click on the title.
    this.toggleInstance = function() {
        var instance = this.getImInstance();
        var messageList = instance.getElementsByClassName('instance-content')[0];
        var currentDisplay = messageList.style.display;
        messageList.style.display = currentDisplay == "none" ? "block" : "none";
        messageList.style.display = currentDisplay == "none" ? "block" : "none";
    };

    // Gets the im instance from the html this object represents.
    this.getImInstance = function() {
        var instance = document.getElementById(this.boxId);

        return instance;
    };

    // Gets any new chats from the server.
    // If it's the first time fetching for the list, get some history.
    this.getMessages = function() {

        var urlForMessages = "/chatcraft/im/messages.php?";
        urlForMessages += "user_id=" + this.user_id;
        urlForMessages += "&other_id=" + this.other_id;
        urlForMessages += "&prev_msg_id=" + this.prev_msg_id;

        if(this.firstime == true) {
            urlForMessages += "&firstime=true";
            this.firstime = false;
        }

        var request = new XMLHttpRequest();
        var _this = this;
        request.onreadystatechange = function() {
            if(request.readyState == 4) {
                // Got new messages from the server.
                console.log(request.responseText);
                var data = JSON.parse(request.responseText);
                _this.addMessages.call(_this, data['messages']);
            }
        };
        console.log(urlForMessages);
        request.open("GET", urlForMessages, true);
        request.send();
    };

    // Appends the chat messages to the chat box.
    this.addMessages = function(messages) {
        if(messages.length == 0) return;

        // Get the messages container.
        var chat_instance = document.getElementById(this.boxId);
        var message_container = chat_instance.querySelector('.message-list');

        // For each of the message, create an element.
        for(var i = 0; i < messages.length; ++i) {
            var entry = "<p class='im-message'>";
            entry += "<span class='username'>" + messages[i]['sender_name'] + "</span>:";
            entry += "<span class='message-entry'>" + messages[i]['message'] + "</span>";
            entry += "</p>";

            message_container.innerHTML += entry;
        }
    };

    this.init();
}
