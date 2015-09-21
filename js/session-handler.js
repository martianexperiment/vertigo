/*Session Management*/

function prepareErrorToPrint(errorMsg)
{
	if(errorMsg.error)
		return '<p>'+errorMsg.error+'</p>';
	else if(errorMsg.interruption == 'MultipleSessionsInterruption')
		return '<p>Active Session: ' + errorMsg.aliveSession.browser+ ', '+ errorMsg.aliveSession.ip + ',' +errorMsg.aliveSession.lastActiveTime + '</p>\
				<p>Active Session: ' + errorMsg.currentSession.browser+ ', '+ errorMsg.currentSession.ip + ',' +errorMsg.currentSession.lastActiveTime + '</p>';
	return '';
}

function checkError(reply)
{
	reply = reply.replace(/\\(.)/mg, "$1");
	var isJSON = IsJsonString(reply);
	if(!isJSON)
	{
		var repDOM = $(reply);
	
		if(!isJSON && repDOM.find('#error-msg'))
		{
			$('html').html(reply);
		}
	}
	else if(isJSON && (reply.error!=null || reply.interruption!=null))
	{
		$('html').html(reply.html);
		$('#error-msg').html(prepareErrorToPrint(reply));
	}
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}