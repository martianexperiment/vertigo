/*Requires jQuery*/

/*var mainContainer = $('.content-wrapper');
var accessPoint = 'php/HackinRequestReceiver.php';

var overlay = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';

var quesContainer = '<div class="row"> <div class="col-lg-4"> <div class="row"> <div class="col-lg-12"> <div class="box box-primary direct-chat direct-chat-primary" id="conversation"> <div class="box-header with-border"> <h3 class="box-title">Conversation</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body"> <div class="direct-chat-messages nano"> </div></div></div></div></div><div class="row"> <div class="col-lg-12"> <div class="box box-danger" id="characters" > <div class="box-header with-border"> <h3 class="box-title">Characters</h3> <div class="box-tools pull-right"> <span class="label label-danger" id="num-of-characters">0</span> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body no-padding"> <ul class="users-list clearfix"> </ul> </div></div></div></div></div><div class="col-lg-4 fill-height-or-more"> <div class="row"> <div class="col-lg-12"> <div class="box box-warning"> <div class="box-header with-border"> <h3 class="box-title" id="location">{{location}}</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool"><i class="fa fa-map-marker"></i></button> </div></div></div></div></div><div class="row"> <div class="col-lg-12"> <div class="box box-success"> <div class="box-header with-border"> <h3 class="box-title">Mission Description</h3> <div class="box-tools pull-right"> <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div></div><div class="box-body" id="question-holder"> </div></div></div></div></div><div class="col-lg-4"> <div class="box box-primary"> <div class="box-header with-border"> <h3 class="box-title">Gideon</h3> <div class="box-tools pull-right"> </div></div><div class="box-body"> <div class="gideon"> <h1> <div class="gideon-holder"> <span class="gideon-loader"></span> </div><p class="response">Response Text</p></h1> </div></div></div></div></div>';

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
}*/
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('c 17=$(\'.t-10\');c J=\'O/19.O\';c w=\'<1 2="w"><i 2="5 5-11 5-14"></i></1>\';c N=\'<1 2="j"> <1 2="a-9-4"> <1 2="j"> <1 2="a-9-12"> <1 2="3 3-u z-A z-A-u" m="18"> <1 2="3-h n-k"> <6 2="3-f">16</6> <1 2="3-d g-e"> <7 2="8 8-3-o" l-v="x"><i 2="5 5-C"></i></7> </1></1><1 2="3-r"> <1 2="z-A-V W"> </1></1></1></1></1><1 2="j"> <1 2="a-9-12"> <1 2="3 3-K" m="I" > <1 2="3-h n-k"> <6 2="3-f">Y</6> <1 2="3-d g-e"> <q 2="P P-K" m="13-15-I">0</q> <7 2="8 8-3-o" l-v="x"><i 2="5 5-C"></i></7> </1></1><1 2="3-r R-Q"> <F 2="S-X T"> </F> </1></1></1></1></1><1 2="a-9-4 U-Z-1n-1t"> <1 2="j"> <1 2="a-9-12"> <1 2="3 3-1s"> <1 2="3-h n-k"> <6 2="3-f" m="G">{{G}}</6> <1 2="3-d g-e"> <7 2="8 8-3-o"><i 2="5 5-1r-1p"></i></7> </1></1></1></1></1><1 2="j"> <1 2="a-9-12"> <1 2="3 3-1q"> <1 2="3-h n-k"> <6 2="3-f">1v 1w</6> <1 2="3-d g-e"> <7 2="8 8-3-o" l-v="x"><i 2="5 5-C"></i></7> </1></1><1 2="3-r" m="1a-M"> </1></1></1></1></1><1 2="a-9-4"> <1 2="3 3-u"> <1 2="3-h n-k"> <6 2="3-f">1u</6> <1 2="3-d g-e"> </1></1><1 2="3-r"> <1 2="y"> <L> <1 2="y-M"> <q 2="y-1o"></q> </1><p 2="1f">1e 1d</p></L> </1></1></1></1></1>\';b 1b(){c s=\'\';$(\'.3\').1c(w);1g(b(){$(\'1h.t\').E(N)},1m)}b D(1l){c s=\'\';$.1k(J,{b:\'D\'}).1i(b(l){s=l});H s}b 1j(t,B){B.E(t);H B}',62,95,'|div|class|box||fa|h3|button|btn|lg|col|function|var|tools|right|title|pull|header||row|border|data|id|with|tool||span|body|ret|content|primary|widget|overlay|collapse|gideon|direct|chat|container|minus|getView|html|ul|location|return|characters|accessPoint|danger|h1|holder|quesContainer|php|label|padding|no|users|clearfix|fill|messages|nano|list|Characters|height|wrapper|refresh||num|spin|of|Conversation|mainContainer|conversation|HackinRequestReceiver|question|getCurrentView|append|Text|Response|response|setTimeout|section|done|fillContainer|post|selector|2500|or|loader|marker|success|map|warning|more|Gideon|Mission|Description'.split('|'),0,{}))
