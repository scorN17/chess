(function($){

$(document).ready(function(){

	$('form').each(function(){
		$(this).submit(function(){
			return false;
		});
	});

	$('.newgamewrp .inp_submt button').on('click',function(){
		var b = $(this).parents('.newgamewrp');
		if (b.hasClass('pr')) return;
		b.addClass('pr');
		var r = b.find('.frow_res .res');
		r.removeClass('a');
		var frm = b.find('form');
		$.post(frm.attr('action'),frm.serialize())
		.done(function(data){
			b.removeClass('pr');
			var res = $.parseJSON(data);
			if (res.res == 'ok') {
				window.location = '/?gmid='+res.gmid;
			} else {
				r.html(res.txt).addClass('a');
			}
		});
	});

	$('.botpanel .bttns .pbtn').on('dblclick',function(){
		var cb = $('.chessboard');
		if (cb.hasClass('pr')) return;
		cb.addClass('pr');
		var body = $('body');
		var gmid = body.data('gmid');
		var a = $(this).data('a');
		var b = $(this).data('b');
		$.ajax({
			url: '/inc/action.php?a='+a+'&b='+b+'&gmid='+gmid,
			dataType: 'JSON',
		}).done(function(data){
			if (data.res == 'ok') {
				location.reload();
			} else {
				var n = $('.ntcwrp');
				n.removeClass('ok er').addClass(data.res);
				if (data.txt) n.html(data.txt);
				cb.removeClass('pr');
			}
		});
	});

	$('.chessboard .field .figure').on('click',function(){
		var cb = $('.chessboard');
		if (cb.hasClass('pr')) return;

		var body = $('body');
		var gmid = body.data('gmid');

		var fgr = $(this);
		var fld = fgr.parents('.field');
		var pxy = fld.data('pxy');
		var fgrt = fgr.data('fgrt');
		var my = fgr.hasClass('my') ? true : false;

		if (
			$('.chessboard .field .figure.sel').length
			&& (
				! my
				|| ($('.chessboard .field .figure.sel').data('fgrt')=='9' && fgrt=='5')
			)
		) {
			cb.addClass('pr');
			var posf = cb.data('posf');
			var post = pxy;
			$.ajax({
				url: '/inc/action.php?a=step&gmid='+gmid+'&pf='+posf+'&pt='+post,
				dataType: 'JSON',
			}).done(function(data){
				if (data.res == 'ok') {
					console.log('+');
				} else {
					var n = $('.ntcwrp');
					n.removeClass('ok er').addClass(data.res);
					if (data.txt) n.html(data.txt);
				}
				cb.removeClass('pr');
			});
		} else {
			$('.chessboard .field .figure.sel').removeClass('sel');
			if ( ! my) return;
			cb.data('posf',pxy);
			fgr.addClass('sel');
		}
	});

});

})(jQuery);
