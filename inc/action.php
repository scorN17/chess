<?php
define('INC',true);
include_once(dirname(__FILE__).'/bootstrap.php');


$a = $_REQUEST['a'];
$b = $_REQUEST['b'];


if ('step' == $a) {
	if ( ! $game['start']) exit('{"res":"er","txt":"Начните игру"}');
	if ($game['finsh']) exit('{"res":"er","txt":"Игра завершена"}');

	$posf = intval($_GET['pf']);
	$post = intval($_GET['pt']);

	$fgr = $game['postn'][$posf] ? $game['postn'][$posf] : array(0,0);
	if ( ! $fgr) exit('{"res":"er"}');
	
	if ($game['side'] != $fgr[0]) exit('{"res":"er"}');
	
	$posbl = posblmov($game,$fgr,array($posf,$post));

	var_dump($posbl);
	print_r($posbl);

	exit();
}

if ('game' == $a) {
	if ('start' == $b) {
		$res = $db->query("SELECT * FROM game
			WHERE sess='".GMR_SESS."' AND `start`>0 AND finsh=0
			LIMIT 1");
		if ( ! $res) exit('{"res":"er","txt":"Ошибка базы данных"}');
		if ($db->num_rows($res)) exit('{"res":"er","txt":"Завершите другие игры"}');
		$res = $db->query("UPDATE game
			SET `start`='".time()."'
			WHERE id='".GMID."' AND sess='".GMR_SESS."' AND `start`=0 LIMIT 1");
		if ( ! $res) exit('{"res":"er","txt":"Ошибка базы данных"}');
		exit('{"res":"ok"}');
	}

	if ('gvup' == $b) {
		$res = $db->query("UPDATE game
			SET finsh='".time()."', won=IF(side='b','w','b'), why='gvup'
			WHERE id='".GMID."' AND sess='".GMR_SESS."' AND `start`>0 AND finsh=0 LIMIT 1");
		if ( ! $res) exit('{"res":"er","txt":"Ошибка базы данных"}');
		exit('{"res":"ok"}');
	}
}

if ('newgame' == $a) {

	$mode = in_array($_POST['gm_mode'],array('simple')) ? $_POST['gm_mode'] : 'simple';
	$side = $_POST['gm_side'] == '2' ? '2' : '1';
	
	$postn = json_encode($starting_position);
	$postn = $db->escape($postn);

	$res = $db->query("INSERT INTO game SET
		mode = '{$mode}',
		side = '{$side}',
		postn = '{$postn}',
		dt = '".time()."',
		sess = '".GMR_SESS."'
	");
	if ( ! $res) exit('{"res":"er","txt":"Ошибка базы данных"}');
	$gmid = $db->insert_id();

	exit('{"res":"ok","gmid":"'.$gmid.'"}');
}

exit('{"res":"ok"}');
