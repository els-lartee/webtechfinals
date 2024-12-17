<?php

define('DB_NAME', 'jewelquest');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'jewelquest');

        if ($this->conn->connect_error) {
            die('Database connection error: ' . $this->conn->connect_error);
        }
    }

    public function connect(): mysqli {
        return $this->conn;
    }

    public function disconnect(): void {
        $this->conn->close();
    }

    /**
     * Execute a query on the database. Sanitize inputs.
     * Log errors to the error log.
     *
     * @param string $query
     * @return bool|mysqli_result
     */
    public function query(string $query):
    bool|mysqli_result{
        $result = $this->conn->query($query);

        if (!$result) {
            error_log($this->conn->error);
        }

        return $result;
    }

    /**
     * Insert a new row into the database. Sanitize inputs.
     *
     * @param string $table
     * @param array $data
     * @return bool|mysqli_result
     */
    public function insert(string $table, array $data):
    bool|mysqli_result{
        $columns = implode(', ', array_keys($data));
        $values = implode("', '", array_values($data));

        $query = "INSERT INTO $table ($columns) VALUES ('$values')";

        return $this->query($query);
    }

    /**
     * Update a row in the database. Sanitize inputs.
     *
     * @param string $table
     * @param array $data
     * @param string $where
     * @return bool|mysqli_result
     */
    public function update(string $table, array $data, string $where):
    bool|mysqli_result{
        $set = '';
        foreach ($data as $column => $value) {
            $set .= "$column = '$value', ";
        }
        $set = rtrim($set, ', ');

        $query = "UPDATE $table SET $set WHERE $where";
        return $this->query($query);
    }

    /**
     * Delete a row from the database. Sanitize inputs.
     *
     * @param string $table
     * @param string $where
     * @return bool|mysqli_result
     */
    public function delete(string $table, string $where):
    bool|mysqli_result{
        $query = "DELETE FROM $table WHERE $where";
        return $this->query($query);
    }

    /**
     * Fetch a single row from the database. Sanitize inputs.
     *
     * @param string $table
     * @param string $where
     * @return array|null
     */
    public function fetch(string $table, string $where):
    ?array{
        $query = "SELECT * FROM $table WHERE $where";
        $result = $this->query($query);

        if ($result->num_rows === 0) {
            return null;
        }

        return $result->fetch_assoc();
    }

    /**
     * Fetch all rows from the database. Sanitize inputs.
     *
     * @param string $table
     * @param string $where
     * @return array
     */
    public function fetchAll(string $table, string $where):
    array {
        $query = "SELECT * FROM $table WHERE $where";
        $result = $this->query($query);
        if ($result->num_rows === 0) {
            return [];
        }
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function prepare($query) {
        return $this->conn->prepare($query);
    }

}
?>
