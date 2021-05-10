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

function posblmov($postn, $posf, $fgrc, $fgrt)
{
	$posbl = array();
	if ($fgrt === 1) {
		if ($fgrc === 1) {
			if (substr($posf,1,1) == 2) $posbl[] = array($posf+2);
			$posbl[] = array($posf+1);
			$posbl[] = array($posf+11,'hit');
			$posbl[] = array($posf-9,'hit');
		}
		if ($fgrc === 2) {
			if (substr($posf,1,1) == 7) $posbl[] = array($posf-2);
			$posbl[] = array($posf-1);
			$posbl[] = array($posf-11,'hit');
			$posbl[] = array($posf+9,'hit');
		}
	}
	if ($fgrt === 3) {
		$posbl[] = array($posf+12);
		$posbl[] = array($posf-12);
		$posbl[] = array($posf+21);
		$posbl[] = array($posf-21);
		$posbl[] = array($posf+19);
		$posbl[] = array($posf-19);
		$posbl[] = array($posf+8);
		$posbl[] = array($posf-8);
	}
	if ($fgrt === 5 || $fgrt === 8 || $fgrt === 9) {
		for ($i=1;$i<=8;$i++) {
			$posbl[] = array($posf+1);
			$posbl[] = array($posf-1);
			$posbl[] = array($posf+10);
			$posbl[] = array($posf-10);
			if ($fgrt === 9) break;
		}
	}
	if ($fgrt === 4 || $fgrt === 8 || $fgrt === 9) {
		for ($i=1;$i<=8;$i++) {
			$posbl[] = array($posf+9);
			$posbl[] = array($posf-9);
			$posbl[] = array($posf+11);
			$posbl[] = array($posf-11);
			if ($fgrt === 9) break;
		}
	}
	foreach ($posbl AS $key => $pos) {
		$h = intval(substr($pos[0],0,1));
		$v = intval(substr($pos[0],1,1));
		if ($h < 1 || $h > 8 || $v < 1 || $v > 8) unset($posbl[$key]);
	}
	return $posbl;
}
