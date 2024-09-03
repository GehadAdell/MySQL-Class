<?php

include "env.php";

class Db
{

    public $connection;
    public $sql;
    public $query;

    public function __construct()
    {
        $this->connection = mysqli_connect(SERVER, USER, PASS, DBNAME);
    }

    public function select($table, $column)
    {
        $this->sql = "SELECT $column FROM `$table` ";
        return $this;
    }

    public function where($column, $compare, $value)
    {
        $this->sql .= "WHERE `$column` $compare '$value' ";
        return $this;
    }

    public function andWhere($column, $compare, $value)
    {
        $this->sql .= "AND `$column` $compare '$value' ";
        return $this;
    }

    public function orWhere($column, $compare, $value)
    {
        $this->sql .= "OR `$column` $compare '$value' ";
        return $this;
    }

    public function getAll()
    {
        $this->query();
        while ($row = mysqli_fetch_assoc($this->query)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getRow()
    {
        $this->query();
        return mysqli_fetch_assoc($this->query);
    }

    public function insert($table, $data)
    {
        $row = $this->prepareData($data);
        $this->sql = "INSERT INTO `$table` SET $row";
        return $this;
    }

    public function update($table, $data)
    {
        $row = $this->prepareData($data);
        $this->sql = "UPDATE `$table` SET $row ";
        return $this;
    }

    public function delete($table)
    {
        $this->sql = "DELETE FROM `$table`";
        return $this;
    }

    public function excu()
    {
        $this->query();
        if (mysqli_affected_rows($this->connection) > 0) {
            return true;
        } else {
            return $this->showError();
        }
    }

    public function query()
    {
        try {
            $this->query = mysqli_query($this->connection, $this->sql);
        } catch (Exception) {
            echo $this->showError();
            die;
        }
    }

    public function prepareData($data)
    {
        $row = "";
        foreach ($data as $key => $value) {
            $row .= " `$key` = " . ((gettype($value) == 'string') ? "'$value'" : "$value") . ",";
        }
        $row = rtrim($row, ",");
        return $row;
    }

    public function showError()
    {
        $errors = mysqli_error_list($this->connection);
        foreach ($errors as $error) {
            return "<h2 style='color:red'>Error</h2> : " . $error['error'] . "<br> <h3 style='color:red'>Error Code : </h3>" . $error['errno'];
        }
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }
}
