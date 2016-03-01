
/* These help make my things go easy LOL */
function out(something) {
    console.log("Printing :3 " + something);
}

function initFixedChat() {
    // Get the recent chat box and the add the click event.
    var recentChat = document.getElementById('recent-chats');
    out("initFixedChat: Fetching the recent chats ...");
    out(recentChat);


    // Hide the recent chats box when the user clicks on its title.
    recentChat.addEventListener('click', function() {
        // Get the list and hide it.
        var recentList = recentChat.querySelector(".list");
        out("Recent list :");
        out(recentList);
        var currentDisplay = recentList.style.display;
        recentList.style.display = currentDisplay == "block" ? "none" : "block";

    });


    // Add the chat starter code if there is a button to open a chat.
    var start_chat_btn = document.getElementById('start_chat');
    if(start_chat_btn) {

        // When the user clicks on start chat button, open
        // open a new chat with the other user.
        start_chat_btn.addEventListener('click', function() {
            window.im_instances.push(
                new ImInstance(window.user_id, window.profile_user_id)
            );
        });
    }



}

initFixedChat();
