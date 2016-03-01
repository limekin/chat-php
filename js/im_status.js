/* ===================
    This file updates the user's online status.
    And also view the status of other users on their
    profiles.

   ===================
*/

// Sends a request to the server, informing the server
// that the user is currently using the browser (i.e. he is online).
function ping() {
    var ajax = new XMLHttpRequest();
    var urlToPing = "/chatcraft/im/ping.php?id=" + window.user_id;
    ajax.onreadystatechange = function() {

        // If the request is successfully completed.
        if(ajax.readyState == 4) {
            console.log("Pinged the server. Updated the online status.");
            console.log("Got response : ");
            console.log(ajax.responseText);
            console.log();console.log();
            // Update again after 4 seconds.
            setTimeout(ping, 10000);
        }
    };

    ajax.open("GET", urlToPing, true);
    ajax.send();
}


setTimeout(ping, 10000);