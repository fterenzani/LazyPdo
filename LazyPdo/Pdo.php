<?php
/**
 * (c) 2013 Francesco Terenzani
 */
 namespace LazyPdo;

/**
 * Just a bit of sugar in PDO
 */
class Pdo extends \PDO implements LazyPdo
{

	use Execute;

	function __construct($dsn, $username = '', $password = '', array $driver_options = array()) {
		parent::__construct($dsn, $username, $password, $driver_options);
		$this->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
		$this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
	}


	function getPdo() {
		return $this;
	}

}