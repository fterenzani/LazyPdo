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

    $lazyPdo instanceof \PDO; // true
    $notLazyPdo instanceof \PDO; // true

    // Get the instance of \PDO
    $pdo = $lazyPdo->getPdo();

    // Shorthand method
    $results = $lazyPdo->query($sql, array($vars, $to, $bind));

    // It is the equivalent of:
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(array($vars, $to, $bind));
    // $results = $stmt;

    // Shorthand method
    $affectedRows = $lazyPdo->exec($sql, array($vars, $to, $bind));

    // It is the equivalent of:
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(array($vars, $to, $bind));
    // $affectedRows = $stmt->rowCount();

    $stmt = $lazyPdo->query($sql, array($vars, $to, $bind));

    $stmt->fetchObjects('\My\CustomClass', array($constructor, $arguments));
    // It is the equivalent of:
    $stmt->fetchAll(\PDO::FETCH_CLASS, '\My\CustomClass', array($constructor, $arguments));

    $stmt->fetchColumns(0);
    // It is the equivalent of:
    $stmt->fetchAll(\PDO::FETCH_COLUMN);
