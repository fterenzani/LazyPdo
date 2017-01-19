<?php

require_once __DIR__ . '/../LazyPdo/Pdo.php';
require_once __DIR__ . '/../LazyPdo/Lazy.php';

class FooBar {}

class PdoTestCase extends \PHPUnit_Framework_TestCase
{

	function testInstanceOfLazyPdo()
	{
		$this->assertEquals(true, new \LazyPdo\Pdo('sqlite::memory:') instanceof \LazyPdo\Pdo);
		$this->assertEquals(true, new \LazyPdo\Lazy('sqlite::memory:') instanceof \LazyPdo\Pdo);
	}

	function testInstanceOfPdo()
	{
		$this->assertEquals(true, new \LazyPdo\Pdo('sqlite::memory:') instanceof PDO);
		$this->assertEquals(true, new \LazyPdo\Lazy('sqlite::memory:') instanceof PDO);
	}

	function testGetPdo()
	{
		$this->assertEquals(true, (new \LazyPdo\Pdo('sqlite::memory:'))->getPdo() instanceof PDO);
		$this->assertEquals(true, (new \LazyPdo\Lazy('sqlite::memory:'))->getPdo() instanceof PDO);
	}

	function testExecute()
	{
		$this->assertEquals(date('Y-m-d'), (new \LazyPdo\Pdo('sqlite::memory:'))->execute("SELECT DATE(?)", 'now')->fetchColumn());
		$this->assertEquals(date('Y-m-d'), (new \LazyPdo\Lazy('sqlite::memory:'))->execute("SELECT DATE(?)", ['now'])->fetchColumn());
	}

	function testQuery()
	{
		$this->assertEquals(true, (new \LazyPdo\Pdo('sqlite::memory:'))->query("SELECT DATE('NOW')") instanceof PDOStatement);
		$this->assertEquals(true, (new \LazyPdo\Lazy('sqlite::memory:'))->query("SELECT DATE('NOW')") instanceof PDOStatement);
	}

	function testQuote()
	{
		$this->assertEquals("'a','b'", (new \LazyPdo\Pdo('sqlite::memory:'))->quote(['a', 'b']));
		$this->assertEquals("'a','b'", (new \LazyPdo\Lazy('sqlite::memory:'))->quote(['a', 'b']));
		$this->assertEquals("'a'", (new \LazyPdo\Pdo('sqlite::memory:'))->quote('a'));
		$this->assertEquals("'a'", (new \LazyPdo\Lazy('sqlite::memory:'))->quote('a'));
	}

	function testFetchColumns()
	{
		$this->assertEquals([date('Y-m-d')], (new \LazyPdo\Pdo('sqlite::memory:'))->execute("SELECT DATE(?)", ['now'])->fetchColumns(0));
		$this->assertEquals([date('Y-m-d')], (new \LazyPdo\Lazy('sqlite::memory:'))->execute("SELECT DATE(?)", ['now'])->fetchColumns(0));
	}

	function testObjects()
	{

		$test = new FooBar();
		$test->t = date('Y-m-d');

		$this->assertEquals([$test], (new \LazyPdo\Pdo('sqlite::memory:'))->execute("SELECT DATE(?) as t", ['now'])->fetchObjects('FooBar'));
		$this->assertEquals([$test], (new \LazyPdo\Lazy('sqlite::memory:'))->execute("SELECT DATE(?) as t", ['now'])->fetchObjects('FooBar'));
	}

	function testProxy()
	{

		$la = new \LazyPdo\Lazy('sqlite::memory:');

		$la->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$this->assertEquals(PDO::FETCH_ASSOC, $la->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE));
		$this->assertEquals(['t' => date('Y-m-d')], $la->execute("SELECT date(?) as t", ['now'])->fetch());

		$this->assertEquals(false, $la->inTransaction());
		$la->beginTransaction();
		$this->assertEquals(true, $la->inTransaction());
		$la->rollback();
		$this->assertEquals(false, $la->inTransaction());
		$la->beginTransaction();
		$this->assertEquals(true, $la->prepare("SELECT date(?)", ['now']) instanceof PDOStatement);
		$la->commit();
		$this->assertEquals(false, $la->inTransaction());

		$this->assertEquals("'te''st'", $la->quote("te'st"));
		
		$la->exec("create table articles (title)");
		$stmt = $la->prepare("insert into articles (title) values (?)");
		$stmt->execute(['test 1']);
		$stmt->execute(['test 2']);
		$this->assertEquals(2, $la->lastInsertId());
		$this->assertEquals(2, $la->exec("delete from articles"));

		$this->assertEquals('0000', $la->errorCode());
		$info = $la->errorInfo();
		$this->assertEquals('0000', $info[0]);
	
	}

}