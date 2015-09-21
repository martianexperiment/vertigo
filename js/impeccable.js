today = new Date();
var BigDay = new Date("September 21, 2015 00:00:00");

var countDownStartDate = new Date(BigDay);
countDownStartDate.setDate(countDownStartDate.getDate() - 100);
var actualTimeLeft = BigDay.getTime() - today.getTime();
var msPerHundredDays = 100 * 24 * 60 * 60 * 1000;
var elapseMilliSecs = (today.getTime() - countDownStartDate.getTime());
var elapseInSecs = -(Math.round(elapseMilliSecs / 1000.0));

jQuery(document).ready(function($) {

	var ua = window.navigator.userAgent;
	var msie = ua.indexOf("MSIE");

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
