<?php

namespace AddressBook\Core;

class Database
{
    private $handler;

    private $error;

    private $statement;

    private static $instances = [];

    /**
     * Initialize the PDO connection. Set the handler as
     * the new instance to be used throughout each additional
     * function.
     */
    protected function __construct()
    {
        try {
            $this->handler = new \PDO("sqlite:" . PATH_TO_SQLITE_FILE);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();

            if (APP_DEBUG) {
                echo $this->error;
            }
        }
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public static function getInstance(): Database
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Prepare a statement.
     */
    public function query($query)
    {
        $this->statement = $this->handler->prepare($query);
    }

    /**
     * Bind the variables to the proper type. Allows
     * for integer, string, null, and boolean.
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }

        $this->statement->bindValue($param, $value, $type);
    }

    /**
     * Execute a prepared statement.
     */
    public function execute()
    {
        try {
            return $this->statement->execute();
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();

            if (APP_DEBUG) {
                echo $this->error;
            }
        }
    }

    /**
     * Fetch a single row as a result of a query.
     */
    public function result()
    {
        $this->execute();

        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a set of rows as a result of a query.
     */
    public function resultset()
    {
        $this->execute();

        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get the row count of the statement.
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * Get the id of the last inserted item into the database.
     */
    public function lastInsertId()
    {
        return $this->handler->lastInsertId();
    }

    /**
     * Fetch a single row as a result of a query.
     */
    public function fetch()
    {
        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }
}
