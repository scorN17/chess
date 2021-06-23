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

	$('.chessboard .cells .cell').on('click',function(){
		var cb = $('.chessboard');
		if (cb.hasClass('pr')) return;

		var body = $('body');
		var gmid = body.data('gmid');

		var cll = $(this);
		var pxy = cll.data('pxy');
		var fgr = $('.chessboard .figures .figure.pxy_'+pxy);
		var fgrt, my;
		if (fgr.length) {
			fgrt = fgr.data('fgrt');
			my = fgr.hasClass('my') ? true : false;
		}
		if (
			$('.chessboard .cells .cell.sel').length
			&& (
				! my
				|| (cb.data('fgrt')=='9' && fgrt=='5')
			)
		) {
			cb.addClass('pr');
			cll.addClass('sel');
			var posf = cb.data('posf');
			var post = pxy;
			$.ajax({
				url: '/inc/action.php?a=step&gmid='+gmid+'&pf='+posf+'&pt='+post,
				dataType: 'JSON',
			}).done(function(data){
				if (data.res == 'ok') {
					$('.chessboard .cells .cell.lst').removeClass('lst');
					$('.chessboard .cells .cell.sel').addClass('lst');
					$('.chessboard .cells .cell.sel').removeClass('sel');
					board_set(data.chgs);
				} else {
					$('.chessboard .cells .cell.sel').removeClass('sel');
					var n = $('.ntcwrp');
					n.removeClass('ok er').addClass(data.res);
					if (data.txt) n.html(data.txt);
				}
				cb.removeClass('pr');
			});
		} else {
			$('.chessboard .cells .cell.sel').removeClass('sel');
			if ( ! my) return;
			cb.data('posf',pxy);
			cb.data('fgrt',fgrt);
			cll.addClass('sel');
		}
	});

});

function board_set(chgs)
{
	chgs.forEach(function(val,key){
		if ('move' == val.act) {
			console.log(val);
			$('.chessboard .figures .figure.pxy_'+val.posf).css({
				left: val.left,
				top: val.top,
			});
		}
	});
}

})(jQuery);
