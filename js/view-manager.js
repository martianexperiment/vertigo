/*Requires jQuery*/

var mainContainer = $('.content-wrapper');
var accessPoint = 'php/HackinRequestReceiver.php';

var overlay = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';

var quesContainer = '<div class="row"> <div class="col-lg-4"> <div class="row"> <div class="col-lg-12"> <div class="box box-primary direct-chat direct-chat-primary" id="conversation"> <div class="box-header with-border"> <h3 class="box-title">Conversation</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body"> <div class="direct-chat-messages nano"> </div></div></div></div></div><div class="row"> <div class="col-lg-12"> <div class="box box-danger" id="characters" > <div class="box-header with-border"> <h3 class="box-title">Characters</h3> <div class="box-tools pull-right"> <span class="label label-danger" id="num-of-characters">0</span> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body no-padding"> <ul class="users-list clearfix"> </ul> </div></div></div></div></div><div class="col-lg-4 fill-height-or-more"> <div class="row"> <div class="col-lg-12"> <div class="box box-warning"> <div class="box-header with-border"> <h3 class="box-title" id="location">{{location}}</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool"><i class="fa fa-map-marker"></i></button> </div></div></div></div></div><div class="row"> <div class="col-lg-12"> <div class="box box-success"> <div class="box-header with-border"> <h3 class="box-title">Mission Description</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body" id="question-holder"> </div></div></div></div></div><div class="col-lg-4"> <div class="box box-primary"> <div class="box-header with-border"> <h3 class="box-title">Gideon</h3> <div class="box-tools pull-right"> </div></div><div class="box-body"> <div class="gideon"> <h1> <div class="gideon-holder"> <span class="gideon-loader"></span> </div><p class="response">Response Text</p></h1> </div></div></div></div></div>';

var tb1 = '<div class="box-footer"> \
                    <div class="input-group"> \
                      <input type="text" name="message" placeholder="Answer Here.." class="form-control"> \
                      <span class="input-group-btn"> \
                        <button type="button" class="btn btn-primary btn-flat" onclick="javascript:verifyAnswer(';
var tb2 =');" >Verify</button> \
                      </span> \
                    </div> \
                </div>';

function gideonRoutine()
{
	playGideon();
	speakGideon('Mission 2 & 3 added');
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

			$('#question-holder').parent().append(tb1+1+tb2 );
			
			$.post(
				accessPoint,
				{function: 'getQuestionState()', questionNum:1},
				function(data, textStatus, xhr)
				{
					checkError(data);
					data = data.replace(/\\(.)/mg, "$1")
					data = JSON.parse(data);

					if(data.hasSolved)
					{
						$('.box-footer').remove();
					}
				}
			);
			
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

function getMission(qNum)
{
	$('.box').append(overlay);
	$.post(
		accessPoint,
		{'function': 'getQuestion('+qNum+')'},
		function(data, textStatus, xhr)
		{
			checkError(data);
			data = data.replace(/\\(.)/mg, "$1")
			data = JSON.parse(data);
			$('section.content').html(quesContainer);

			var chars = data.charactersInvolved;
			//console.log(chars);
			var charsView = $('#characters');
			//Clear the list;
			//charsView.find('ul.users-list').html('');
			loadCharacters(chars, charsView);
			//$('#conversation .direct-chat-messages').html('');
			loadConversation(chars, data.messages,$('#conversation'));
			bindLocation($('#location'), data.location.city + ', '+ data.location.state);
			$('#question-holder').html(data.question);

			$('#question-holder').parent().append(tb1+qNum+tb2 );

			$.post(
				accessPoint,
				{function: 'getQuestionState()', questionNum:qNum},
				function(data, textStatus, xhr)
				{
					checkError(data);
					data = data.replace(/\\(.)/mg, "$1")
					data = JSON.parse(data);

					if(data.hasSolved)
					{
						$('.box-footer').remove();
					}
				}
			);
			
			gideonRoutine();
			setInterval(gideonRoutine,40*1000);
			$('.overlay').remove();
		}
	);
}


function verifyAnswer(qNum)
{
	$('#input-holder').append(overlay);
	$.post('php/HackinRequestReceiver.php',
		{
			function: 'verifyAnswer()',
			questionNum: qNum,
			answer: $('input[name=message]').val()
		}
		, function(data, textStatus, xhr) 
		{
			checkError(data);
			data = data.replace(/\\(.)/mg, "$1")
			data = JSON.parse(data);

			console.log(data);
			playGideon();
			if(data.hasSolved)
			{
				speakGideon('Solved');
				$('.box-footer').remove();
			}
			else if(data.noOfAttemptsMade < data.maxNoOfAttemptsAllowed)
				speakGideon('Try Again <br/>'+'Attempts '+data.noOfAttemptsMade+'/'+data.maxNoOfAttemptsAllowed);
			else
			{
				$('.box-footer').remove();
				speakGideon('Closed');
			}
		}
	);
}