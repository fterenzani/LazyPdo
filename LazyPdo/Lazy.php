<?php
/**
 * (c) 2013 Francesco Terenzani
 */
namespace LazyPdo;

/**
* Lazy connection and a bit of sugar in PDO
*/
class Lazy extends Pdo
{

	protected $pdo;
	protected $arguments = array();
	protected $attributes = array();

	function __construct($dsn, $username = '', $password = '', array $driver_options = array()) {
		$this->arguments = array($dsn, $username, $password, $driver_options);
	}

	function getPdo() {

		if (!isset($this->pdo)) {
			$a = $this->arguments;
			$this->pdo = new Pdo($a[0], $a[1], $a[2], $a[3]);


			foreach ($this->attributes as $key => $value) {			
				$this->pdo->setAttribute($key, $value);
			}

		}

		return $this->pdo;

	}

	function setAttribute($attribute, $value) {

		if (!isset($this->pdo)) {
			$this->attributes[$attribute] = $value;	

		} else {
			$this->pdo->setAttribute($attribute, $value);

		}

	}

	function getAttribute($attribute) {
		if (!isset($this->pdo) && isset($this->attributes[$attribute])) {
			return $this->attributes[$attribute];
		} else {
			return $this->getPdo()->getAttribute($attribute);
		}
	}
	
	function beginTransaction() {
		return $this->getPdo()->beginTransaction();
	}
	function inTransaction() {
		return $this->getPdo()->inTransaction();
	}
	function commit() {
		return $this->getPdo()->commit();
	}
	function rollBack() {
		return $this->getPdo()->rollBack();
	}
	function errorCode() {
		return $this->getPdo()->errorCode();
	}
	function errorInfo() {
		return $this->getPdo()->errorInfo();
	}
	/*function exec($statement) {
		return $this->getPdo()->exec($statement);
	}*/
	function lastInsertId($name = null) {
		return $this->getPdo()->lastInsertId($name);
	}
	function prepare($statement, $driver_options = array()) {
		return $this->getPdo()->prepare($statement, $driver_options);
	}
/*	function query($statement) {
		return $this->getPdo()->query($statement);
	}*/
	function quote($string, $parameter_type = \PDO::PARAM_STR) {				
		return $this->getPdo()->quote($string, $parameter_type);
	}
}