<style>
    table{
        border-collapse: collapse;
        border: 1px solid black;
    }
    th{
        border: 1px solid black;
        background-color: lightgray;
        padding: 3px;
    }
    td{
        padding: 3px;
        border: 1px solid black;
    }
</style>
<?php

function gasStations()
{
    return [
        [
            "id" => 0,
            "address" => "Mukachevo",
            "name" => "Shell",
            "liters" => 1000,
            "price" => 52,
        ],
        [
            "id" => 1,
            "address" => "Uzhhorod",
            "name" => "Okko",
            "liters" => 1400,
            "price" => 50,
        ],
    ];
}
session_start();

if (isset($_SESSION['gasStation'])) {
    $gasStations = $_SESSION['GasStation'];
} else {
    $gasStations = gasStations();
}
$_SESSION["GasStation"] = $gasStations;



echo "<table>";
echo "<tr>
        <th>Id</th>
        <th>Adress</th>
        <th>Name</th>
        <th>Liters</th>
        <th>Price</th>
      </tr>";
for ($i = 0; $i < count($gasStations); $i++) {
    echo "<tr>";
    foreach (addGasStation($_SESSION["GasStation"], $i) as $key => $value)
    {
        echo "<td>$value</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo "<br>";


function addGasStation($array, $id) {
    return [
        "id" => $id,
        "address" => $array[$id]["address"],
        "name" => $array[$id]["name"],
        "liters" => $array[$id]["liters"],
        "price" => $array[$id]["price"],
    ];
}

function checkGasStation($array) {
    if(
        empty($array["address"]) ||
        empty($array["name"]) ||
        $array["liters"] < 0 ||
        $array["price"] < 0 ||
        !isset($array)
    )
    {
        return false;
    }
    return true;
}

if ($_GET['action'] == 'add') {
    if (checkGasStation($_GET)) {
        $counter = count($_SESSION['GasStation']);
        $_SESSION['GasStation'][$counter] = addGasStation($_POST, $counter);
    }
}



if ($_GET['action'] == 'edit') {
    if (checkGasStation($_GET)) {
        for ($i = 0; $i < count($gasStations); $i++) {
            if ($_GET['id'] == $gasStations[$i]['id']) {
                $gasStations = addGasStation($_GET, $i+1);
                break;
            }
        }
    }
}
$_SESSION["GasStation"] = $gasStations;
function isGasAvailable($name, $liters, $arr) {
    $newArr = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i]["name"] == $name && $arr[$i]["liters"] >= $liters) {
            array_push($newArr, $arr[$i]);
        }
    }
    return $newArr;
}

$arr = isGasAvailable($_GET['name'],$_GET['liters'],$gasStations);

echo "<table>";
echo "<tr>
        <th>Id</th>
        <th>Adress</th>
        <th>Name</th>
        <th>Liters</th>
        <th>Price</th>
      </tr>";
for ($i = 0; $i < count($arr); $i++) {
    echo "<tr>";
    foreach ($arr[$i] as $key => $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";
}
//echo "</table>";
var_dump($_SESSION["GasStation"]);
echo '<br>';
var_dump($_GET);
echo '<br>';
var_dump($_POST);
?>
<br>

<form method='post' action="">
    Add new gas station <br>
    <table>
        <tr>
            <th>Address</th>
            <th>Name</th>
            <th>Liters</th>
            <th>Price</th>
        </tr>
        <tr>
            <td><input type="text" name="address"></td>
            <td><input type="text" name="name"></td>
            <td><input type="number" name="liters"></td>
            <td><input type="number" name="price"></td>
        </tr>
    </table>
    <input type='hidden' name='action' value='add'>
    <input type='submit'>
</form>
<br>
<form method='get' action="">
    Edit gas station <br>
    <table>
        <tr>
            <th>Id</th>
            <th>Address</th>
            <th>Name</th>
            <th>Liters</th>
            <th>Price</th>
        </tr>
        <tr>
            <td><input type="number" name="id"></td>
            <td><input type="text" name="address"></td>
            <td><input type="text" name="name"></td>
            <td><input type="number" name="liters"></td>
            <td><input type="number" name="price"></td>
        </tr>
    </table>
    <input type='hidden' name='action' value='edit'>
    <input type='submit'>
</form>
<br>
<form method="get" action="">
    Is gas available <br>
    <table>
        <tr>
            <th>Name</th>
            <th>Liters</th>
        </tr>
        <tr>
            <td><input type="text" name="name"></td>
            <td><input type="number" name="liters"></td>
        </tr>
    </table>
    <input type="submit">
</form>