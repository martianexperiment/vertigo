/*Requires jQuery*/

var mainContainer = $('.content-wrapper');
var accessPoint = 'HackinRequestReceiver.php';

function getCurrentView()
{
	var ret='';
	$.post( accessPoint, { function: "getCurrentView"})
     .done( function( data )
     		{
   				ret = data;
  			}
  		  );
     return ret;
}

function getView(selector)
{
	var ret='';
	$.post( accessPoint, {function: 'getView'})
	.done(function(data){ret=data});
	return ret;
}

function fillContainer(content, container)
{
	container.html(content);
	return container;
}