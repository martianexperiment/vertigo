function bindUser(userModel, userDOMNode)
{
	// var userImageElement = userDOMNode.find('#user-image');
	var userScreenNameElement = userDOMNode.find('#user-screen-name');
	var userDetailsElement = userDOMNode.find('#user-details');

	// userImageElement.attr('src',userModel.profilePic);
	userScreenNameElement.html(userModel.emailId);
	userDetailsElement.html(userModel.collegeName);	
}

function bindCharacterInfo(gameState, sidebarDOM)
{
	if(sidebarDOM.hasClass('user-panel'))
	{
		var charImgElement = sidebarDOM.find('#characterImage');
		var charNameElement = sidebarDOM.find('#characterName');	

		var charModel = JSON.parse(gameState.playsAsCharacter);

		if(charImgElement)
			charImgElement.attr('src',charModel.profilePic);
		if(charNameElement)
			charNameElement.html(charModel.name);
	}
	
}