<?php


function posbl($pos,$fgr)
{
	$vectrs = array(
		1 => array(
			1 => array(1,-9,11),
			2 => array(-1,9,-11),
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
		for ($o=1; $o<=8; $o++) {
			$p = $pos[0]+($o*$w);
			$h = intval(substr($p,0,1));
			$v = intval(substr($p,1,1));
			if ($p<11 || $p>88 || $h<1 || $h>8 || $v<1 || $v>8) break;
			$posbl[] = $p;
			if (in_array($fgr[1],array(1,3,9))) break;
		}
	}

	// sort($posbl);

	return $posbl;
}

$posbl = posbl(array(58,14),array(1,3));

print_r($posbl);