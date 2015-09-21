/*Sessiom Management*/

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
	var repDOM = $(reply);
	if(repDOM.find('#error-msg'))
	{
		$('html').html(reply);
	}
	else if(reply.error!=null || reply.interruption!=null)
	{
		$('html').html(reply.html);
		$('#error-msg').html(prepareErrorToPrint(reply));
	}
}