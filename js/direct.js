//IMPORTANT: Requires jQuery

//Added feature
/*
	Typing indicator -- refers root/css/typing-indicator.css
*/

// Model that is used to bind to the direct and charaters
/*
conversation: {	characters:	[ {name: '', imgUrl:''}, {}],
				texts: [ { characterIndex: <index>, msg:'' }, {}]
			  }
*/

var strRight ='right';
var pullLeft = 'pull-left';
var pullRight = 'pull-right';

var chatMsgHTML = 
'<div class="direct-chat-msg">  \
	<div class="direct-chat-info clearfix">  \
		<span class="direct-chat-name">name</span>  \
		<span class="direct-chat-timestamp">timeStamp</span>  \
	</div>  \
	<img class="direct-chat-img" src="" alt="message user image" /> \
	<div class="direct-chat-text">  \
		text  \
	</div>  \
</div>';

var characterHTML=
'<li> \
	<img src="#" alt="Character Image">  \
	<span class="users-list-name">Character Name</span> \
</li>';

var typingIndicatorHTML=
'<div class="typing-indicator"> \
	<span></span> \
	<span></span> \
  <span></span> \
</div>
'

/*Returns a DOM Object for ChatMsgHTML*/
function createChatMsgDOMNode()
{
	return $(chatMsgHTML);
}

/*Returns a DOM Object for CharacterHTML*/
function createCharacterDOMNode()
{
	return $(characterHTML);
}

function bindChatMsgModel(chatMsgModel, chatMsgDOMNode, pullDirection)
{
	if (chatMsgNode.hasClass('direct-chat-msg'))
	{
		var nameElement = chatMsgNode.find('.direct-chat-name');
		var timeStampElement = chatMsgNode.find('.direct-chat-timestamp');
		var imgElement = chatMsgNode.find('.direct-chat-img');
		var msgElement = chatMsgNode.find('.direct-chat-text');

		if (model_directChatMsg.user.isUser)
		{
			chatMsgNode.addClass(strRight);
			nameElement.addClass(pullRight);
			timeStampElement.addClass(pullLeft);
		}
		else
		{
			nameElement.addClass(pullLeft);
			timeStampElement.addClass(pullRight);
		}
		nameElement.html(model_directChatMsg.user.name);
		timeStampElement.html(model_directChatMsg.timestamp);
		imgElement.attr('src',model_directChatMsg.imgUrl);
		msgElement.html(model_directChatMsg.text);

		return chatMsgDOMNode;
	};
	return null;
}

function bindCharacterModel(characterModel, characterDOMNode)
{
	if(characterDOMNode != null)
	{
		var nameElement=characterDOMNode.find('.users-list-name');
		var imgElement = characterDOMNode.find('img');

		nameElement.html(characterModel.name);
		imgElement.attr('src',characterModel.imgUrl);
	}
	return characterDOMNode;
}

/*
Given the list of character models.
And a character container node.
Loops thro the list and populates the characters
*/
function loadCharacters(charactersModel, charactersDOMNode)
{
	var charactersUL = charactersDOMNode.find('ul.users-list');
	if(charactersUL != null)
	{
		for (characterModel in charactersModel)
		{
			var characterDOMNode = createCharacterDOMNode();
			bindCharacterModel(character, characterDOMNode);
			charactersUL.append(characterDOMNode);
		}
		return charactersDOMNode;
	}
	return null;
}