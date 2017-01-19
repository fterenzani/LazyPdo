<?php
/**
 * (c) 2013 Francesco Terenzani
 */

namespace LazyPdo;

/**
 * Just a bit of sugar in PDO
 */
class Pdo extends \PDO
{

	function __construct($dsn, $username = '', $password = '', array $driver_options = array()) {

		parent::__construct(
			$dsn, $username, $password, 
			array(
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
					\PDO::ATTR_STATEMENT_CLASS => array('\LazyPdo\Statement'),
				) + $driver_options
		
		);

	}

	function getPdo() {
		return $this;
	}

	function execute($sql, $params = array()) {

		$stmt = $this->getPdo()->prepare($sql);
		if (!is_array($params)) {
			$params = array($params);
		}

		$stmt->execute($params);
		return $stmt;

	}

	function query($sql) {
		return $this->execute($sql);
	}

	function quote($string, $parameter_type = \PDO::PARAM_STR) {
				
		if (is_array($string)) {
			return implode(',', array_map(function($item) use ($parameter_type) {
				return parent::quote($item, $parameter_type);
			}, $string));
		}

		return parent::quote($string, $parameter_type);	

	}

}

/**
 * Just a bit of sugar in PDOStatement
 */
class Statement extends \PDOStatement
{

	function fetchObjects($className = 'stdClass', array $constructorArgs = array()) {
		return $this->fetchAll(\PDO::FETCH_CLASS, $className, $constructorArgs);
	}

	function fetchColumns($column_number = 0) {
		return $this->fetchAll(\PDO::FETCH_COLUMN, $column_number);
	}

}