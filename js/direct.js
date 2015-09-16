/*IMPORTANT: Requires jQuery*/

/*Added feature*/
/*
	Typing indicator -- refers root/css/typing-indicator.css
*/

/*Model that is used to bind to the direct and charaters*/
/*
conversation: {	characters:	[ {name: '', imgUrl:''}, {}],
				texts: [ { characterIndex: <index>, msg:'' }, {}]
			  }
*/

var strRight ='right';
var pullLeft = 'pull-left';
var pullRight = 'pull-right';
var _RIGHT_ = 'right'

var chatMsgHTML = '<div class="direct-chat-msg">  \
	<div class="direct-chat-info clearfix">  \
		<span class="direct-chat-name">name</span>  \
		<span class="direct-chat-timestamp">timeStamp</span>  \
	</div>  \
	<img class="direct-chat-img" src="" alt="message user image" /> \
	<div class="direct-chat-text">  \
		text  \
	</div>  \
</div>';

var characterHTML='<li> \
	<img src="#" alt="Character Image">  \
	<span class="users-list-name">Character Name</span> \
</li>';

var typingIndicatorHTML='<div class="typing-indicator"> \
	<span></span> \
	<span></span> \
  <span></span> \
</div>';

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

function createTypingIndicator(direction)
{
	var typingIndicatorDOM = $(typingIndicatorHTML);
	if(direction == _RIGHT_)
		typingIndicatorDOM.addClass('typing-indicator-right').addClass('pull-right');
	return typingIndicatorDOM;
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function bindChatMsgModel(textModel, characterModel, characterIndex, directMsgDOMNode)
{
	if (directMsgDOMNode.hasClass('direct-chat-msg'))
	{
		var nameElement = directMsgDOMNode.find('.direct-chat-name');
		var timeStampElement = directMsgDOMNode.find('.direct-chat-timestamp');
		var imgElement = directMsgDOMNode.find('.direct-chat-img');
		var msgElement = directMsgDOMNode.find('.direct-chat-text');

		if (characterIndex == 0)
		{
			directMsgDOMNode.addClass(strRight);
			nameElement.addClass(pullRight);
			timeStampElement.addClass(pullLeft);
		}
		else
		{
			nameElement.addClass(pullLeft);
			timeStampElement.addClass(pullRight);
		}
		nameElement.html(characterModel.name);
		timeStampElement.html((new Date()).toLocaleTimeString());
		imgElement.attr('src',characterModel.imgUrl);
		msgElement.html(textModel.msg);

		return directMsgDOMNode;
	}
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
	var numOfCharactersElement = charactersDOMNode.find('#num-of-characters');
	if(charactersUL != null)
	{
		var iter = 0;
		var len = charactersModel.length;
		numOfCharactersElement.html(len);
		for (; iter < len; iter++)
		{
			var characterModel = charactersModel[iter];
    		var characterDOMNode = createCharacterDOMNode();
			bindCharacterModel(characterModel, characterDOMNode);
			charactersUL.append(characterDOMNode);
		}
		return charactersDOMNode;
	}
	return null;
}

/*
Given the list of texts.
and the chat container
Loops thro the list and populates the chat
*/
function loadConversation(directModel, directDOMNode)
{
	var characters = directModel.characters;
	var texts = directModel.texts;
	var directListElement = directDOMNode.find('.direct-chat-messages');

	if(directListElement != null)
	{
		var iter = 0;
		var len = texts.length;
		for( ; iter <len; iter++)
		{
			var textModel = texts[iter];
			var characterIndex = textModel.characterIndex;
			var characterModel = characters[characterIndex];
			var directMsgDOMNode = createChatMsgDOMNode();
			var pullDirection='';

			if(characterIndex==0)
				pullDirection= _RIGHT_;

			var typingIndicator = createTypingIndicator(pullDirection);
			bindChatMsgModel(textModel, characterModel, characterIndex, directMsgDOMNode);

			var delay = calculateDelay(textModel.msg);
			directListElement.append(typingIndicator);
			sleep(delay);
			directListElement.children().last().remove();
			directListElement.append(directMsgDOMNode);
		}
		return directDOMNode;
	}
	return null;
}

var __CPS__ = 5;
function calculateDelay(text)
{
	return ( text.length/__CPS__ )*1000;
}