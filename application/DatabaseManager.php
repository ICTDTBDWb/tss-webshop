<?php

namespace application;

use PDO;

class DatabaseManager
{
    const CONFIG = [
        'dsn' => [
            'host' => 'host.docker.internal',
            'port' => 3308,
            'dbname' => 'tss',
            'charset' => 'utf8mb4'
        ],
        'username' => 'root',
        'password' => 'root'
    ];
    private ?PDO $connection;
    private ?\PDOStatement $statement; // Added nullable type for statement

    /**
     * DatabaseManager constructor.
     * Initializes a new instance of the DatabaseManager class.
     */
    public function __construct()
    {
        // Create a dsn string based on the given config.
        $dsn = 'mysql:' . http_build_query(self::CONFIG['dsn'], '', ';');

        // Create a new PDO connection to the database.
        $this->connection = new PDO(
            $dsn,
            self::CONFIG['username'],
            self::CONFIG['password'],
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false, // Disable emulated prepares to use real prepared statements
            ]
        );
    }

    /**
     * Execute a SQL query.
     *
     * @param string $query The SQL query to execute.
     * @param array $params An associative array of parameters to bind to the query.
     *
     * @return $this
     */
    public function query(string $query, array $params = []): DatabaseManager
    {
        $this->statement = $this->connection->prepare($query);

        // Bind parameters
        foreach ($params as $param => $value) {
            $this->bind($param, $value);
        }

        $this->statement->execute();

        return $this;
    }

    /**
     * Get all rows from the last executed query.
     *
     * @return array|false Returns an array of values on success and false on failure.
     */
    public function get(): false|array
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

    public function bind($param, $value, $type = null)
    {
        if (is_null($this->statement)) {
            throw new \Exception("Statement not initialized. Call query() before binding parameters.");
        }

        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->statement->bindValue($param, $value, $type);
    }
    public function getMedewerkers(): array
    {
        // Voer hier je databasequery uit om medewerkersgegevens op te halen
        $query = "SELECT * FROM tss.medewerkers";
        $this->query($query);

        // Haal de resultaten op
        return $this->get();
    }
    public function getMedewerkerById($id): ?array
    {
        $query = "SELECT * FROM tss.medewerkers WHERE id = :id";
        $this->query($query, [':id' => $id]);

        $result = $this->first();

        return $result ?: null;
    }
}

