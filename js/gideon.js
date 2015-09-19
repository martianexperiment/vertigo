/*NOTE: Works with gideon.css*/

var gideon = $('div.gideon');
var gideonHolder = $('.gideon .golder-holder');
var gideonLoader = $('.gideon .gideon-loader');
var gideonResponse = $('.gideon .response');

function pauseGideon()
{
	gideonLoader.removeClass('gideon-loader-playing');
}

function playGideon()
{
	gideonLoader.addClass('gideon-loader-playing');
}

function speakGideon(text)
{
	gideonResponse.html(text);
}