<?php
/**
 * (c) 2013 Francesco Terenzani
 */
 namespace LazyPdo;

/**
 * Lazy PDO interface
 */
interface LazyPdo
{

	function getPdo();
	function execute($sql, $params = array());

}