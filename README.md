    // Lazy database connection
    $lazyPdo = new \LazyPdo\Lazy('sqlite:::memory:');
 
    // Normal connection
    $notLazyPdo = new \LazyPdo\Pdo('sqlite:::memory:');

    // Is the equivalent of
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

    // Is the equivalent of:
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(array($vars, $to, $bind));
    // $results = $stmt;