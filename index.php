<?php
define('INC',true);
include_once(dirname(__FILE__).'/inc/bootstrap.php');


include_once(DROOT.'/tpl/head.php');
?>


<div class="mcolswrp">

	<div class="mcol mcol_l">
	
		<div class="newgamewrp">
			<form action="/inc/action.php?a=newgame">
				<div class="frow">
					<div class="lbl">Режим игры</div>
					<div class="inp"><select name="gm_mode">
						<option value="simple">Обычный</option>
					</select></div>
				</div>
				<div class="frow">
					<div class="lbl">Сторона</div>
					<div class="inp"><select name="gm_side">
						<option value="w">Белые</option>
						<option value="b">Черные</option>
					</select></div>
				</div>
				<div class="frow">
					<div class="inp inp_submt"><button type="button">Создать игру</button></div>
				</div>
				<div class="frow frow_res">
					<div class="res"></div>
				</div>
			</form>
		</div>

		<div class="mygamelistwrp">
<?php
$res = $db->query("SELECT * FROM game WHERE sess='".GMR_SESS."' ORDER BY id DESC");
if ($res && $db->num_rows($res)) {
	while ($row = $db->fetch_assoc($res)) {
		print '<div class="gm">'.$row['id'].'. <a href="/?gmid='.$row['id'].'">'.date('d.m.Y, H:i',$row['dt']).'</a></div>';
	}
}
?>
		</div>
	
	</div><!--mcol mcol_l-->


	<div class="mcol mcol_c">
<!-- ---------------------------------------------------- -->

<div class="toppanelwrp">
	<div class="toppanel">
	1
	</div>
</div>


<div class="chessboardwrp">

	<div class="chessboard <?=($game['side']=='b' ? 'myblack' : '')?>">
<?php
$num = 0;
$clr = true;
for ($v=8; $v>=1; $v--) {
	$clr = ! $clr;
	for ($h=1; $h<=8; $h++) {
		$num++;
		$clr = ! $clr;
		$hh = $h_simb[$h];
		$pxy = $h.$v;

		$fgr = $game['postn'][$pxy] ? $game['postn'][$pxy] : 0;
		if ($fgr) {
			$fgrc = $fgr>20?2:1;
			$fgrt = $fgr-($fgr>20?20:10);
		} else $fgrc = $fgrt = 0;

		$my = $game['side'] && $game['side']==$fgrc ? true : false;

		$p .= '<div class="field clr_'.($clr?'1':'0').' pxy_'.$pxy.'" data-pxy="'.$pxy.'">';
		$p .= '<div class="figure fgr_'.$fgr.' '.($my?'my':'').'" data-fgrt="'.$fgrt.'">&nbsp;</div>';
		if ($h == 1) $p .= '<span class="vv">'.$v.'</span>';
		if ($h == 8) $p .= '<span class="vv vv2">'.$v.'</span>';
		if ($v == 8) $p .= '<span class="hh hh2">'.$hh.'</span>';
		if ($v == 1) $p .= '<span class="hh">'.$hh.'</span>';
		$p .= '</div>';
	}
}
print $p;
?>
	</div><!--chessboard-->

</div><!--chessboardwrp-->


<div class="botpanelwrp">
	<div class="botpanel">
		<div class="cols bttns">
			<?php if ( ! $game['start']) {?>
				<div class="col"><div class="pbtn" data-a="game" data-b="start"><button type="button">Начать игру</button></div></div>
			<?php } elseif ( ! $game['finsh']) {?>
				<div class="col"><div class="pbtn" data-a="game" data-b="gvup"><button type="button">Сдаться</button></div></div>
			<?php }?>
		</div>

		<div class="ntcwrp"></div>
	</div>
</div>

<!-- ---------------------------------------------------- -->
	</div><!--mcol mcol_c-->


	<div class="mcol mcol_r">
	</div><!--mcol mcol_r-->

</div><!--mcolswrp-->


<?php
include_once(DROOT.'/tpl/bottom.php');
