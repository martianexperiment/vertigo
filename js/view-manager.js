/*Requires jQuery*/

var mainContainer = $('.content-wrapper');
var accessPoint = 'php/HackinRequestReceiver.php';

var overlay = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';

var quesContainer = '<div class="row"> <div class="col-lg-4"> <div class="row"> <div class="col-lg-12"> <div class="box box-primary direct-chat direct-chat-primary" id="conversation"> <div class="box-header with-border"> <h3 class="box-title">Conversation</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body"> <div class="direct-chat-messages nano"> </div></div></div></div></div><div class="row"> <div class="col-lg-12"> <div class="box box-danger" id="characters" > <div class="box-header with-border"> <h3 class="box-title">Characters</h3> <div class="box-tools pull-right"> <span class="label label-danger" id="num-of-characters">0</span> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body no-padding"> <ul class="users-list clearfix"> </ul> </div></div></div></div></div><div class="col-lg-4 fill-height-or-more"> <div class="row"> <div class="col-lg-12"> <div class="box box-warning"> <div class="box-header with-border"> <h3 class="box-title" id="location">{{location}}</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool"><i class="fa fa-map-marker"></i></button> </div></div></div></div></div><div class="row"> <div class="col-lg-12"> <div class="box box-success"> <div class="box-header with-border"> <h3 class="box-title">Mission Description</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body" id="question-holder"> </div></div></div></div></div><div class="col-lg-4"> <div class="box box-primary"> <div class="box-header with-border"> <h3 class="box-title">Gideon</h3> <div class="box-tools pull-right"> </div></div><div class="box-body"> <div class="gideon"> <h1> <div class="gideon-holder"> <span class="gideon-loader"></span> </div><p class="response">Response Text</p></h1> </div></div></div></div></div>';

function gideonRoutine()
{
	playGideon();
	speakGideon('Look at the conversation to grasp the plot.');
	setTimeout(
	function()
	{
		speakGideon('Input will be enabled soon. You may continue to work on the solution in the mean time');
	},
	10*1000
	);
	setTimeout(pauseGideon, 25*1000);
}

function getNextViewFromPrologue()
{
	$('.box').append(overlay);
	$.post(
		accessPoint,
		{'function': 'getNextQuestion()'},
		function(data, textStatus, xhr)
		{
			checkError(data);
			data = data.replace(/\\(.)/mg, "$1")
			data = JSON.parse(data);
			$('section.content').html(quesContainer);

			var chars = data.charactersInvolved;
			//console.log(chars);
			var charsView = $('#characters');
			loadCharacters(chars, charsView);
			loadConversation(chars, data.messages,$('#conversation'));
			bindLocation($('#location'), data.location.city + ', '+ data.location.state);
			$('#question-holder').html(data.question);
			
			gideonRoutine();
			setInterval(gideonRoutine,40*1000);

		}
	);
}

function getCurrentView()
{
	var ret='';
	$('.box').append(overlay);
	setTimeout(function(){
		$('section.content').html(quesContainer)},
		2500);
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
