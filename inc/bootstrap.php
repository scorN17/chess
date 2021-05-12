<?php
defined('INC') or die();

session_start();
define('GMR_SESS', session_id());

define('DROOT', dirname(dirname(__FILE__)));

include_once(DROOT.'/inc/db.php');

include_once(DROOT.'/inc/functions.php');

define('REQURI', $_SERVER['REQUEST_URI']);

$http  = (
	(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ||
	(isset($_SERVER['HTTP_PORT']) && $_SERVER['HTTP_PORT']     == '443') ||
	(isset($_SERVER['HTTP_HTTPS']) && $_SERVER['HTTP_HTTPS']   == 'on') ||
	(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ||
	(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
		$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
		? 'https://' : 'http://');
$domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
$domain = explode(':', $domain);
$domain = $domain[0];
$www = '';
if (strpos($domain,'www.') === 0) {
	$www = 'www.';
	$domain = substr($domain,4);
}
define('PRTCL', $http);
define('WWW', $www);
define('DMN', $domain);

define('GMID', intval($_GET['gmid']));

// --------------------------------------

$h_simb = array(1=>'a',2=>'b',3=>'c',4=>'d',5=>'e',6=>'f',7=>'g',8=>'h');

/*$starting_position = 'brbnbbbqbkbbbnbrbpbpbpbpbpbpbpbp----------------------------------------------------------------wpwpwpwpwpwpwpwpwrwnwbwqwkwbwnwr';
$starting_position = array(
	18=>'br',28=>'bn',38=>'bb',48=>'bq',58=>'bk',68=>'bb',78=>'bn',88=>'br',
	17=>'bp',27=>'bp',37=>'bp',47=>'bp',57=>'bp',67=>'bp',77=>'bp',87=>'bp',
	12=>'wp',22=>'wp',32=>'wp',42=>'wp',52=>'wp',62=>'wp',72=>'wp',82=>'wp',
	11=>'wr',21=>'wn',31=>'wb',41=>'wq',51=>'wk',61=>'wb',71=>'wn',81=>'wr',
);*/
$starting_position = array(
	18 => array(2,5),
	28 => array(2,3),
	38 => array(2,4),
	48 => array(2,8),
	58 => array(2,9),
	68 => array(2,4),
	78 => array(2,3),
	88 => array(2,5),
	
	17 => array(2,1),
	27 => array(2,1),
	37 => array(2,1),
	47 => array(2,1),
	57 => array(2,1),
	67 => array(2,1),
	77 => array(2,1),
	87 => array(2,1),
	
	12 => array(1,1),
	22 => array(1,1),
	32 => array(1,1),
	42 => array(1,1),
	52 => array(1,1),
	62 => array(1,1),
	72 => array(1,1),
	82 => array(1,1),
	
	11 => array(1,5),
	21 => array(1,3),
	31 => array(1,4),
	41 => array(1,8),
	51 => array(1,9),
	61 => array(1,4),
	71 => array(1,3),
	81 => array(1,5),
);

$game = false;
if (GMID) {
	$res = $db->query("SELECT * FROM game WHERE id='".GMID."' AND sess='".GMR_SESS."' LIMIT 1");
	if ($res && $db->num_rows($res)) {
		$game = $db->fetch_assoc($res);
		$game['postn'] = json_decode($game['postn'],1);
	}
}
