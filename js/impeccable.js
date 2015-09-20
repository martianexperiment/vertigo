/*today = new Date();
var BigDay = new Date("September 21, 2015 00:00:00");

var countDownStartDate = new Date(BigDay);
countDownStartDate.setDate(countDownStartDate.getDate() - 100);
var actualTimeLeft = BigDay.getTime() - today.getTime();
var msPerHundredDays = 100 * 24 * 60 * 60 * 1000;
var elapseMilliSecs = (today.getTime() - countDownStartDate.getTime());
var elapseInSecs = -(Math.round(elapseMilliSecs / 1000.0));

jQuery(document).ready(function($) {

	var ua = window.navigator.userAgent;
	var msie = ua.indexOf("MSIE ");

	var isIE = false;

	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
	{   
		$(".time-part-wrapper").parents('.row').remove();
		$('#sign-in-IE').parents('.row').hide();
		$('#starts-text-row').hide();
		isIE = true;
	}
	else
	{ 
		$('#sign-in').hide();
		isIE = false;
	}

	if( !isIE)
	{

		$('.time-part.hundredths.ones').css('-webkit-animation-timing-function', 'cubic-bezier(1.000, -0.530, 0.405, 1.425)');
		$('.time-part.hundredths.ones').css('animation-timing-function', 'cubic-bezier(1.000, -0.530, 0.405, 1.425)');

		$('.time-part.hundredths.tens').css('-webkit-animation-timing-function', 'cubic-bezier(1.000, -0.530, 0.405, 1.425)');
		$('.time-part.hundredths.tens').css('animation-timing-function', 'cubic-bezier(1.000, -0.530, 0.405, 1.425)');

		$('.time-part.seconds.ones').css('-webkit-animation-timing-function', 'cubic-bezier(1.000, -0.530, 0.405, 1.425)');
		$('.time-part.seconds.ones').css('animation-timing-function', 'cubic-bezier(1.000, -0.530, 0.405, 1.425)');

		$('.time-part.seconds.tens').css('-webkit-animation-timing-function', 'cubic-bezier(1,0,1,0)');
		$('.time-part.seconds.tens').css('animation-timing-function', 'cubic-bezier(1,0,1,0)');

		$('.time-part.minutes.ones').css('-webkit-animation-timing-function', 'cubic-bezier(1,0,1,0)');
		$('.time-part.minutes.ones').css('animation-timing-function', 'cubic-bezier(1,0,1,0)');

		$('.time-part.minutes.tens .digit-wrapper').css('-webkit-animation-timing-function', 'step-end');
		$('.time-part.minutes.tens .digit-wrapper').css('animation-timing-function', 'step-end');

		$('.time-part.hours.ones .digit-wrapper').css('-webkit-animation-timing-function', 'step-end');
		$('.time-part.hours.ones .digit-wrapper').css('animation-timing-function', 'step-end');

		$('.time-part.hours.tens .digit-wrapper').css('-webkit-animation-timing-function', 'step-end');
		$('.time-part.hours.tens .digit-wrapper').css('animation-timing-function', 'step-end');

		$('.time-part.days.ones .digit-wrapper').css('-webkit-animation-timing-function', 'step-end');
		$('.time-part.days.ones .digit-wrapper').css('animation-timing-function', 'step-end');

		$('.time-part.days.tens .digit-wrapper').css('-webkit-animation-timing-function', 'step-end');
		$('.time-part.days.tens .digit-wrapper').css('animation-timing-function', 'step-end');

		$('.digit-wrapper').css('-webkit-animation-delay', elapseInSecs + 's');
		$('.digit-wrapper').css('-o-animation-delay', elapseInSecs + 's');
		$('.digit-wrapper').css('-moz-animation-delay', elapseInSecs + 's');
		$('.digit-wrapper').css('animation-delay', elapseInSecs + 's');

		$('.digit-wrapper').addClass('animation-running');

	}
});*/

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('B=y D();h C=y D("U T, W z:z:z");h u=y D(C);u.12(u.10()-P);h Z=C.r()-B.r();h 13=P*Y*J*J*O;h L=(B.r()-u.r());h m=-(S.V(L/O.0));1d(1j).15(4($){h N=1k.H.I;h G=N.1g("1h ");h q=F;K(G>0||!!H.I.1i(/1f.*1e\\:11\\./)){$(".6-5-8").Q(\'.E\').18();$(\'#R-M-17\').Q(\'.E\').A();$(\'#16-19-E\').A();q=1c}1b{$(\'#R-M\').A();q=F}K(!q){$(\'.6-5.n.d\').3(\'-a-2-7-4\',\'b-g(1.i, -0.k, 0.l, 1.j)\');$(\'.6-5.n.d\').3(\'2-7-4\',\'b-g(1.i, -0.k, 0.l, 1.j)\');$(\'.6-5.n.c\').3(\'-a-2-7-4\',\'b-g(1.i, -0.k, 0.l, 1.j)\');$(\'.6-5.n.c\').3(\'2-7-4\',\'b-g(1.i, -0.k, 0.l, 1.j)\');$(\'.6-5.p.d\').3(\'-a-2-7-4\',\'b-g(1.i, -0.k, 0.l, 1.j)\');$(\'.6-5.p.d\').3(\'2-7-4\',\'b-g(1.i, -0.k, 0.l, 1.j)\');$(\'.6-5.p.c\').3(\'-a-2-7-4\',\'b-g(1,0,1,0)\');$(\'.6-5.p.c\').3(\'2-7-4\',\'b-g(1,0,1,0)\');$(\'.6-5.w.d\').3(\'-a-2-7-4\',\'b-g(1,0,1,0)\');$(\'.6-5.w.d\').3(\'2-7-4\',\'b-g(1,0,1,0)\');$(\'.6-5.w.c .9-8\').3(\'-a-2-7-4\',\'e-f\');$(\'.6-5.w.c .9-8\').3(\'2-7-4\',\'e-f\');$(\'.6-5.v.d .9-8\').3(\'-a-2-7-4\',\'e-f\');$(\'.6-5.v.d .9-8\').3(\'2-7-4\',\'e-f\');$(\'.6-5.v.c .9-8\').3(\'-a-2-7-4\',\'e-f\');$(\'.6-5.v.c .9-8\').3(\'2-7-4\',\'e-f\');$(\'.6-5.t.d .9-8\').3(\'-a-2-7-4\',\'e-f\');$(\'.6-5.t.d .9-8\').3(\'2-7-4\',\'e-f\');$(\'.6-5.t.c .9-8\').3(\'-a-2-7-4\',\'e-f\');$(\'.6-5.t.c .9-8\').3(\'2-7-4\',\'e-f\');$(\'.9-8\').3(\'-a-2-x\',m+\'s\');$(\'.9-8\').3(\'-o-2-x\',m+\'s\');$(\'.9-8\').3(\'-X-2-x\',m+\'s\');$(\'.9-8\').3(\'2-x\',m+\'s\');$(\'.9-8\').14(\'2-1a\')}});',62,83,'||animation|css|function|part|time|timing|wrapper|digit|webkit|cubic|tens|ones|step|end|bezier|var|000|425|530|405|elapseInSecs|hundredths||seconds|isIE|getTime||days|countDownStartDate|hours|minutes|delay|new|00|hide|today|BigDay|Date|row|false|msie|navigator|userAgent|60|if|elapseMilliSecs|in|ua|1000|100|parents|sign|Math|21|September|round|2015|moz|24|actualTimeLeft|getDate||setDate|msPerHundredDays|addClass|ready|starts|IE|remove|text|running|else|true|jQuery|rv|Trident|indexOf|MSIE|match|document|window'.split('|'),0,{}))
