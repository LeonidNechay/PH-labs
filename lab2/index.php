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

//if (isset($_SESSION['GasStation'])) {
//
//    $gasStations = $_SESSION['GasStation'];
//} else {
//    $gasStations = gasStations();
//}
//$_SESSION["GasStation"] = $gasStations;

if (empty($_SESSION)) {
    $_SESSION['GasStation'] = gasStations();
}

echo "<table>";
echo "<tr>
        <th>Id</th>
        <th>Adress</th>
        <th>Name</th>
        <th>Liters</th>
        <th>Price</th>
      </tr>";

for ($i = 0; $i < count($_SESSION['GasStation']); $i++) {
    echo "<tr>";
    foreach ($_SESSION['GasStation'][$i] as $key => $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";
}
echo "</table>";


function addGasStation($array, $id) {
    return [
        "id" => $id,
        "address" => $array["address"],
        "name" => $array["name"],
        "liters" => $array["liters"],
        "price" => $array["price"],
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


function isGasAvailable($name, $liters, $arr) {
    $newArr = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i]["name"] == $name && $arr[$i]["liters"] >= $liters) {
            array_push($newArr, $arr[$i]);
        }
    }
    return $newArr;
}
$arr = isGasAvailable($_POST['name'],$_POST['liters'],$_SESSION['GasStation']);
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
echo "</table>";


if($_POST['action'] =="save"){
    $file = fopen("GasStation.txt", "w");
    fwrite($file, serialize($_SESSION["GasStation"]));
    fclose($file);
    $_POST = null;
}
elseif ($_POST['action'] =="load")
{
    $file = fopen("GasStation.txt", "r");
    $text = "";
    while(!feof($file)){
        $part = fread($file, 1);
        $text .= $part;
    }
    $_SESSION['GasStation'] = unserialize($text);
    fclose($file);
    $_POST = null;

}
elseif ($_POST['action'] == 'add') {
    if (checkGasStation($_POST)) {
        $counter = count($_SESSION['GasStation']);
        $_SESSION['GasStation'][] = addGasStation($_POST, $counter);
    }
    $_POST = null;
}
elseif ($_POST['action'] == 'edit') {
    if (checkGasStation($_POST)) {
        $idToEdit = $_POST['id'];
        foreach ($_SESSION['GasStation'] as $key => $value) {
            if ($value['id'] == $idToEdit) {
                $_SESSION['GasStation'][$key] = addGasStation($_POST, $idToEdit);
                break;
            }
        }
    }
    $_POST = null;
}

?>
<br>
<form method="post" >
    <input type="hidden" name="action" value="save">
    <input type="submit" value="Save">
</form>
<br>
<form method="post">
    <input type="hidden" name="action" value="load">
    <input type="submit" value="Load">
</form>
<br>
<form method='post' action='<?= $_SERVER['PHP_SELF'] ?>'>
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
<form method='post' action='<?= $_SERVER['PHP_SELF'] ?>'>
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
<form method="post" action='<?= $_SERVER['PHP_SELF'] ?>'>
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
    <input type="hidden" name="action" value="isGasAvailable">
    <input type="submit">
</form>