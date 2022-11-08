<?php

class GasStationList
{
    public $gasStations = [];
    public $dbh;

    public function __construct()
    {
        $this->dbh = new PDO('mysql:host=127.0.0.1;dbname=lab4_db;charset=utf8', 'atum', '27092004');
    }

    public function showTable()
    {
        echo "<table>";
        echo "<tr>
                <th>Id</th>
                <th>Address</th>
                <th>Name</th>
                <th>Liters</th>
                <th>Price</th>
               </tr>";
        foreach ($this->dbh->query('SELECT * from GasStations') as $item) {
            $values = "";
            $values .= "<td>" .$item['id'] . "</td><td>" .$item['address'] ."</td><td>" .$item['fullname'] ."</td><td>" .$item['liters'] ."</td><td>" .$item['price'] ."</td>";
            echo "<tr>";
            echo $values;
            echo "</tr>";
        }
        echo "</table>";
    }

    public function addGasStation($arr)
    {
        $this->dbh->query('INSERT INTO GasStations(id, address, fullname, liters, price) VALUES (' .
            "'" . $arr['id'] . "', " .
            "'" . $arr['address'] . "', " .
            "'" . $arr['fullname'] . "', " .
            "'" . $arr['liters'] . "', " .
            "'" . $arr['price'] . "')"
        );
    }

    public function editGasStation($arr)
    {
        $this->dbh->exec('UPDATE GasStations SET ' .
            'address = "' . $arr['address'] . '" , ' .
            'fullname = "' . $arr['fullname'] . '" , ' .
            'liters = ' . $arr['liters'] . ', ' .
            'price = ' . $arr['price'] .
            ' WHERE `id` = ' . $arr['id']);
    }

    public function isGasAvailable($name, $liters)
    {
        $arr = $this->dbh->query('SELECT * FROM GasStations');
        $newArr = [];
        foreach($arr as $item)
        {
            if($item['fullname'] == $name && $item['liters'] >= $liters)
            {
                array_push($newArr, $item);
            }
        }
        echo "<table>";
        echo "<tr>
                    <th>Id</th>
                    <th>Address</th>
                    <th>Name</th>
                    <th>Liters</th>
                    <th>Price</th>
                  </tr>";
        for($i = 0; $i < count($newArr); $i++)
        {
            $values = "";
            $values .= "<td>" .$newArr[$i]['id'] . "</td><td>" .$newArr[$i]['address'] ."</td><td>" .$newArr[$i]['fullname'] ."</td><td>" .$newArr[$i]['liters'] ."</td><td>" .$newArr[$i]['price'] ."</td>";
            echo "<tr>";
            echo $values;
            echo "</tr>";
            break;
        }
        echo "</table>";
        echo "<br>";
        $_POST = null;
    }

    public function saveGasStations()
    {
        $arr = [];
        foreach($this->dbh->query('SELECT * FROM GasStations') as $item)
        {
            array_push($arr, $item);
        }
        $file = fopen("GasStation.txt", "w");
        fwrite($file, serialize($arr));
        fclose($file);
        $_POST = null;
    }

    public function loadGasStations()
    {
        $file = fopen("GasStation.txt", "r");
        $text = "";
        while(!feof($file)){
            $part = fread($file, 1);
            $text .= $part;
        }
        foreach (unserialize($text) as $item)
        {
            $this->dbh->query('INSERT INTO GasStations(id, address, fullname, liters, price) VALUES ('
                . $item['id'] . ", " .
                "'" . $item['address'] . "', " .
                "'" . $item['fullname'] . "', " .
                $item['liters'] . ", " .
                $item['price'] . ")");
        };
        var_dump($this->dbh->errorInfo());
        fclose($file);
        $_POST = null;
    }
}