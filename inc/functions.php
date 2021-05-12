<?php
defined('INC') or die();

function icon($n)
{
	return '<svg class="svgi svgi_'.$n.'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><use xlink:href="#svgi-'.$n.'" /></svg>';
}

function transf($num, $tof)
{
	if ('s' == $tof) {
		$v = ceil($num /8) -1;
		$h = $num - ($v*8) -1;
		$k = 17 - ($v*9) + ($h*9);
		$res = $num + $k;
	} elseif ('i' == $tof) {
		$v = 8 - (substr($num,1,1)-1) -1;
		$h = substr($num,0,1) -1;
		$k = 17 - ($v*9) + ($h*9);
		$res = $num - $k;
	}
	return $res;
}

function posblmov($game, $fgr, $pos)
{
	$vectrs = array(
		1 => array(
			1 => array(1,2,-9,11),
			2 => array(-1,-2,9,-11),
		),
		3 => array(8,12,19,21, -8,-12,-19,-21),
		4 => array(9,11, -9,-11),
		5 => array(1,10, -1,-10),
		8 => array(1,9,10,11, -1,-9,-10,-11),
		9 => array(1,9,10,11, -1,-9,-10,-11),
	);
	$vectr = $vectrs[$fgr[1]];
	if (is_array($vectr[1])) $vectr = $vectr[$fgr[0]];
	$posbl = array();
	foreach ($vectr AS $w) {
		$abs_w = abs($w);
		for ($o=1; $o<=8; $o++) {
			$p = $pos[0]+($o*$w);

			if ($p<11 || $p>88) break;
			$h = intval(substr($p,0,1));
			if ($h<1 || $h>8) break;
			$v = intval(substr($p,1,1));
			if ($v<1 || $v>8) break;

			$posfgr = $game['postn'][$p];

			if (in_array($fgr[1],array(3,4,5,8,9))) {
				if ($posfgr[0] == $game['side']) break;
				if ($posfgr[1] == 9) break;
			}
			if ($fgr[1] == 1) {
				if ($abs_w == 1) {
					if ($posfgr[1]) break;
				} elseif ($abs_w == 2) {
					if ($posfgr[1]) break;
					if ($fgr[0] == 1 && $v != 4) break;
					if ($fgr[0] == 2 && $v != 5) break;
					$p_1 = $p+($w/2*(-1));
					if ($game['postn'][$p_1][1]) break;
				} else {
					if ($posfgr[0] == $game['side']) break;
					if ($posfgr[1] == 9) break;
					//TODO взятие пешки на проходе
				}
			}

			$posbl[] = $p;

			if (in_array($fgr[1],array(4,5,8))) {
				if ($posfgr[1]) break;
			}

			if (in_array($fgr[1],array(1,3,9))) break;
		}
	}
	if ($pos[1]) return in_array($pos[1],$posbl);
	return $posbl;
}
