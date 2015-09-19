/*Sessiom Management*/

function logout()
{
	$.post('./HackinRequestReceiver.php', {'function': 'logOut()'});
}