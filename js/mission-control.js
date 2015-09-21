/*Requires jQuery*/

var accessPoint = 'php/HackinRequestReceiver.php';

function bindLocation(locationDOM, locationStr)
{

	locationDOM.html(locationStr);
}

function bindQuestion(htmlStr, quesDOM)
{
	quesDOM.html(htmlStr);
}

function fetchGameState()
{
	$.post(
		accessPoint,
		{'function': 'getGameState()'},
		function(data, textStatus, xhr)
		{
			console.log(data);
			data = JSON.parse(data);
			checkError(data);
			bindCharacterInfo(data, $('.user-panel'));
		}
	);
}

function fetchUserInfo()
{
	$.post(
		accessPoint,
		{'function': 'getUserInfo()'},
		function(data, textStatus, xhr)
		{
			console.log(data);
			data = JSON.parse(data);
			checkError(data);
			bindUser(data, $('#user-account-menu'));
		}
	);
}

function fetchQuestion()
{
	$('.box').append(overlay);
	$.post(
		accessPoint,
		{'function': 'getNextQuestion()'},
		function(data, textStatus, xhr)
		{
			console.log(data);
			data = JSON.parse(data);
			checkError(data);
			return data;
			/*$('section.content').html(quesContainer);

			var chars = data.charactersInvolved;
			var charsView = $('#characters');
			loadCharacters(chars, charsView);
			loadConversation(chars, data.messages,$('#conversation'));
			bindLocation($('#location'), data.location.city + ', '+ data.location.state);
			$('#question-holder').html(data.question);
			*/
		}
	);
}