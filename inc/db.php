<?php
defined('INC') or die();

include_once(DROOT.'/config/db.php');

$db = new DB($db_prms);
$res = $db->connect();
if ( ! $res) exit('db connect error');

class DB
{
	private $w = false;
	private $prms = false;

	function DB($prms)
	{
		$this->prms = $prms;
	}

	function connect()
	{
		$this->w = new mysqli($this->prms['host'], $this->prms['user'], $this->prms['pswrd'], $this->prms['dbname']);
		if ($this->w->connect_error) return false;
		$res = $this->w->set_charset($this->prms['cnct_charset']);
		if ( ! $res) return false;
		return true;
	}

	function query($query)
	{
		return $this->w->query($query);
	}

	function escape($escapestr)
	{
		return $this->w->real_escape_string($escapestr);
	}

	function insert_id()
	{
		return $this->w->insert_id;
	}

	function num_rows($result)
	{
		return $result->num_rows;
	}

	function fetch_assoc($result)
	{
		return $result->fetch_assoc();
	}

	function result($result, $offset=0, $field=false)
	{
		$res = $result->data_seek($offset);
		if ( ! $res) return false;
		$row = $result->fetch_assoc();
		return $field ? $row[$field] : $row;
	}
}
