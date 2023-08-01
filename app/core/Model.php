<?php

abstract class Model extends Database
{

    protected $table = '';
    protected $allowedColumns = [];
    protected $limit = 10;
    protected $offset = 0;

    function test()
    {
        $query = "select * from users";
        $result = $this->query($query);
        show($result);
    }

    public function findAll()
    {        
        $query = "select * from $this->table";       

        return $this->query($query);
    }

    public function where($data, $dataNot = [])
    {
        $keys = array_keys($data);
        $keysNot = array_keys($dataNot);

        $query = "select * from $this->table where ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }
        foreach ($keysNot as $key) {
            $query .= $key . " != :" . $key . " && ";
        }

        $query = trim($query, " && ");

        $query .= " limit $this->limit offset $this->offset";

        $data = array_merge($data, $dataNot);

        return $this->query($query, $data);
    }

    public function first($data, $dataNot = [])
    {
        $keys = array_keys($data);
        $keysNot = array_keys($dataNot);

        $query = "select * from $this->table where ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }
        foreach ($keysNot as $key) {
            $query .= $key . " != :" . $key . " && ";
        }

        $query = trim($query, " && ");

        $query .= " limit $this->limit offset $this->offset";

        $data = array_merge($data, $dataNot);

        $result = $this->query($query, $data);

        if ($result)
            return $result[0];

        return false;
    }

    public function insert($data)
    {
        //remove unwanted data
        if(!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "insert into $this->table (" . implode(", ", $keys) . ") values (:" . implode(", :", $keys) . ")";

        $this->query($query, $data);

        return false;
    }

    public function update($id, $data, $idColumn = "id")
    {
        //remove unwanted data
        if(!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);

        $query = "update $this->table set ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . ", ";
        }

        $query = trim($query, ", ");

        $query .= " where $idColumn = :$idColumn";

        $data[$idColumn] = $id;        
        $this->query($query, $data);
        return false;
    }

    public function delete($id, $idColumn = "id")
    {
        $data[$idColumn] = $id;
        $query = "delete from $this->table where $idColumn = :$idColumn";

        $this->query($query, $data);

        return false;
    }
}
