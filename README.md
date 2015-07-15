    // Lazy database connection
    $lazyPdo = new \LazyPdo\Lazy('sqlite:::memory:');
 
    // Normal connection
    $notLazyPdo = new \LazyPdo\Pdo('sqlite:::memory:');

    // It is the equivalent of
    // $pdo = new PDO('sqlite:::memory:');
    // $pdo->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
    // $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

    $lazyPdo instanceof \LazyPdo\LazyPdo; // true
    $notLazyPdo instanceof \LazyPdo\LazyPdo; // true

    $lazyPdo instanceof \PDO; // false
    $notLazyPdo instanceof \PDO; // true

    // Get the instance of \PDO
    $pdo = $lazyPdo->getPdo();

    // Shorthand method
    $results = $lazyPdo->execute($sql, array($vars, $to, $bind));

    // It is the equivalent of:
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(array($vars, $to, $bind));
    // $results = $stmt;

*New in version 2*

New shorthand methods:

    $stmt = $lazyPdo->execute($sql, array($vars, $to, $bind));

    $stmt->getAll('\My\CustomClass', array($constructor, $arguments));
    // It is the equivalent of:
    $stmt->fetchAll(\PDO::FETCH_CLASS, '\My\CustomClass', array($constructor, $arguments));

    $stmt->get('\My\CustomClass', array($constructor, $arguments));
    // It is the equivalent of:
    $stmt->fetchObject('\My\CustomClass', array($constructor, $arguments));
