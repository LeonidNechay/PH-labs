<?php

include "GasStation.php";
include "GasStationList.php";

session_start();

$gasStations = new GasStationList();

if($_POST['action'] =="save"){
    $gasStations->saveGasStations();
}
elseif ($_POST['action'] =="load")
{
    $gasStations->loadGasStations();
}
elseif ($_POST['action'] == 'add') {
    $gasStations->addGasStation($_POST);
    $_POST = null;
}
elseif ($_POST['action'] == 'edit') {
    $gasStations->editGasStation($_POST);
    $_POST = null;
}
elseif ($_POST['action'] == 'isGasAvailable'){
    $gasStations->isGasAvailable($_POST['fullname'], $_POST['liters']);
}

$gasStations->showTable();
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
            <th>Id</th>
            <th>Address</th>
            <th>Name</th>
            <th>Liters</th>
            <th>Price</th>
        </tr>
        <tr>
            <td><input type="number" name="id"></td>
            <td><input type="text" name="address"></td>
            <td><input type="text" name="fullname"></td>
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
            <td><input type="text" name="fullname"></td>
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
            <td><input type="text" name="fullname"></td>
            <td><input type="number" name="liters"></td>
        </tr>
    </table>
    <input type="hidden" name="action" value="isGasAvailable">
    <input type="submit">
</form>


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