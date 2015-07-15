<?php

/**
 * (c) 2013 Francesco Terenzani
 */
 namespace LazyPdo;
 
 use PDOStatement;
 use PDO;
 use IteratorAggregate;

/**
 * Just a bit of sugar in PDOStatement
 */
 class Statement implements IteratorAggregate
 {

 	protected $statement; 

 	function getIterator() {
 		return $this->statement;
 	}

 	function __construct(PDOStatement $statement) {
 		$this->statement = $statement;
 	}

 	function get($className = 'stdClass', array $constructorArgs = array()) {
 		return $this->fetchObject($className, $constructorArgs);
 	}

 	function getAll($className = 'stdClass', array $constructorArgs = array()) {
 		return $this->fetchAll(PDO::FETCH_CLASS, $className, $constructorArgs);
 	}

	function __call($method, $arguments) {
		return call_user_func_array(array($this->statement, $method), $arguments);
	}

	function __get($variable) {
		return $this->statement->{$variable};
	}

 }