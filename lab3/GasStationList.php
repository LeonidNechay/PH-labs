<?php

class GasStationList
{
    public $gasStations;

    public function gasStationsData()
    {
        return $this->gasStations = [
            new GasStation(0, [
                "address" => "Mukachevo",
                "name" => "Shell",
                "liters" => 1000,
                "price" => 52,
            ]),
            new GasStation(1, [
                "address" => "Uzhhorod",
                "name" => "Okko",
                "liters" => 1400,
                "price" => 50,
            ])
        ];
    }

    public function getGasStationById($id)
    {
        foreach ($this->gasStations as $gasStation)
        {
            if($gasStation->id == $id)
            {
                return $gasStation;
            }
        }
        return null;
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
        foreach ($this->gasStations as $gasS) {
            echo "<tr>";
            foreach ($gasS as $item)
            {
                    echo "<td>$item</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function addGasStation($gasStation)
    {
        $this->gasStations[] = $gasStation;
    }

    public function editGasStation($array)
    {
        $gasStation = $this->getGasStationById($array['id']);
        if(!empty($array))
        {
            $gasStation->id = $array['id'];
            $gasStation->address = $array['address'];
            $gasStation->name = $array['name'];
            $gasStation->liters = $array['liters'];
            $gasStation->price = $array['price'];
            $this->gasStations[$array['id']] = $gasStation;
        }
    }

    public function isGasAvailable($name, $liters)
    {
        for($i = 0; $i < count($this->gasStations); $i++)
        {
            if($this->gasStations[$i]['name'] == $name && $this->gasStations[$i]['liters'] >= $liters)
            {
                echo "<table>";
                echo "<tr>
                <th>Id</th>
                <th>Adress</th>
                <th>Name</th>
                <th>Liters</th>
                <th>Price</th>
              </tr>";

                echo "<tr>";
                foreach ($this->gasStations[$i] as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
                echo "</table>";
                break;
            }
        }
    }

    public function saveGasStations()
    {
        $file = fopen("GasStation.txt", "w");
        fwrite($file, serialize($this->gasStations));
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
        $this->gasStations = unserialize($text);
        fclose($file);
        $_POST = null;
    }
}