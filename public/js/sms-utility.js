
/* global baseURL, utilities, globals */

/**
 * Dependencies: utilities.js, globals.js
 * @type type
 */

var SMSUtility = {
    noHttpBaseURL: null,
    SMSUtility: null
};

SMSUtility.initialize = function () {
    SMSUtility.noHttpBaseURL = utilities.trimPort(utilities.trimHttp(baseURL));
    SMSUtility.WSConnection = null;

    SMSUtility.WSConnection = new WebSocket('ws://' + SMSUtility.noHttpBaseURL + ':' + globals.socketPort);
    SMSUtility.WSConnection.onopen = function (e) {
        //  for checking
        console.log("Connection established!");
        console.log(e);
    };

    SMSUtility.WSConnection.onmessage = function (e) {
        console.log("Ignored message", e);
    };

};

SMSUtility.sendSMS = function (sendToNumber, message) {

    var notification = {
        type: "NOTIFICATION_SIMPLE_SMS",
        contact: sendToNumber,
        message: message
    };
    try {
        SMSUtility.WSConnection.send(JSON.stringify(notification));
        console.log("Notification Sent", notification);
    } catch (e) {
        console.error(e);
        console.error("Failed to send message to " + sendToNumber);
    }

};