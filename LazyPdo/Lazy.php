<?php
/**
 * (c) 2013 Francesco Terenzani
 */
 namespace LazyPdo;

/**
 * Lazy connection and a bit of sugar in PDO
 */
class Lazy implements LazyPdo
{

	protected $pdo;
	protected $arguments = array();
	protected $attributes = array(
		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
	);

	function __construct($dsn, $username = '', $password = '', array $driver_options = array()) {
		$this->arguments = array($dsn, $username, $password, $driver_options);

	}


	function getPdo() {

		if (!isset($this->pdo)) {
			$a = $this->arguments;
			$this->pdo = new \PDO($a[0], $a[1], $a[2], $a[3]);

			foreach ($this->attributes as $key => $value) {			
				$this->pdo->setAttribute($key, $value);

			}

		}

		return $this->pdo;

	}

	function execute($sql, $params = array()) {

		$stmt = $this->getPdo()->prepare($sql);
		if (!is_array($params)) {
			$params = array($params);
		}

		$stmt->execute($params);
		return $stmt;
	}

	function __call($method, $arguments) {
		return call_user_func_array(array($this->getPdo(), $method), $arguments);
	}

	function setAttribute($attribute, $value) {

		if (!isset($this->pdo)) {
			$this->atributes[$attribute] = $value;	

		} else {
			$this->pdo->setAttribute($attribute, $value);

		}

	}

}