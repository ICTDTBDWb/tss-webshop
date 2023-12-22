<?php

class Database
{
    const CONFIG = [
        'dsn' => [
            'host' => 'host.docker.internal',
            'port' => 3308,
            'dbname' => 'tss',
            'charset' => 'utf8mb4',
        ],
        'username' => 'root',
        'password' => 'root',
    ];

    private ?PDO $connection = null;
    private PDOStatement $statement;

    /**
     * Database constructor.
     * Initializes a new instance of the Database class.
     */
    public function __construct()
    {
        $dsn = 'mysql:' . http_build_query(self::CONFIG['dsn'], '', ';');

        try {
            $this->connection = new PDO(
                $dsn,
                self::CONFIG['username'],
                self::CONFIG['password'],
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            $this->connection = null;
            error_log('PDOException in Database constructor: ' . $e->getMessage());
        }
    }

    /**
     * Execute a SQL query.
     *
     * @param string $query The SQL query to execute.
     * @param array $params An associative array of parameters to bind to the query.
     *
     * @return $this
     */
    public function query(string $query, array $params = []): self
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    /**
     * Get all rows from the last executed query.
     *
     * @return array|false Returns an array of values on success and false on failure.
     */
    public function get(): array|false
    {
        return $this->statement->fetchAll();
    }

    /**
     * Get the first row from the last executed query.
     *
     * @return mixed Returns the value on success and false on failure.
     */
    public function first(): mixed
    {
        return $this->statement->fetch();
    }

    public function insert(): mixed
    {
        return  $this->connection->lastInsertId();
    }

    /**
     * Close the PDO connection.
     */
    public function close(): void
    {
        $this->connection = null;
    }

    /**
     * Destruct the current class instance. This gets called automatically.
     */
    public function __destruct()
    {
        try {
            // Close the PDO connection
            $this->connection = null;
        } catch (\PDOException $e) {
            // Log or handle the exception appropriately
            error_log('PDOException in DatabaseManager __destruct: ' . $e->getMessage());
        }
    }
}
