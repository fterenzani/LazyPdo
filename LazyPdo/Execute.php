<?php

/**
 * (c) 2013 Francesco Terenzani
 */
 namespace LazyPdo;

/**
 * The sweet LazyPdo execute method
 */

trait Execute 
{

	function execute($sql, $params = array()) {

		$stmt = $this->getPdo()->prepare($sql);
		if (!is_array($params)) {
			$params = array($params);
		}

		$stmt->execute($params);
		return new Statement($stmt);

	}

	function query($sql) {
		return $this->execute($sql);
	}

}