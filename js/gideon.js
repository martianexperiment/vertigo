/*NOTE: Works with gideon.css*/

function pauseGideon()
{
	$('.gideon .gideon-loader').removeClass('gideon-loader-playing');
}

function playGideon()
{
	$('.gideon .gideon-loader').addClass('gideon-loader-playing');
}

function speakGideon(text)
{
	$('.gideon .response').html(text);
}