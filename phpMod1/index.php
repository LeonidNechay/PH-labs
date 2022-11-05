<!--2. (20 балів) На сервері зберігається список студентів (Id, ПІБ, курс,-->
<!--спеціальність). Розробити Web сторінку для перегляду всього списку-->
<!--студентів. Розмістити поле з для вводу курсу навчання (від 1 до 4) . При-->
<!--натисканні відповідної кнопки показати тільки список студентів обраного-->
<!--курсу.-->
<!--3. (10 балів) Реалізувати завдання 2 з використанням бази даних.-->

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

$dbh = new PDO('mysql:host=127.0.0.1;dbname=lab4_db;charset=utf8', 'atum', '27092004');

session_start();

echo "<table>";
echo "<tr>
        <th>Id</th>
        <th>Name</th>
        <th>Course</th>
        <th>Specialty</th>
      </tr>";

foreach ($dbh->query('SELECT * from students') as $item) {
    $values = "";
    $values .= "<td>" .$item['id'] . "</td><td>" .$item['fullname'] ."</td><td>" .$item['course'] ."</td><td>" .$item['specialty'] ."</td>";
    echo "<tr>";
        echo $values;
    echo "</tr>";
}
echo "</table>";

echo "<br>";

function filterByCourse($course, $arr)
{
    $newArr = [];
    foreach($arr as $item)
    {
        if($item['course'] == $course)
        {
            array_push($newArr, $item);
        }
    }
    return $newArr;
}

$arr = filterByCourse($_POST['course'], $dbh->query('SELECT * from students'));

echo "<table>";
echo "<tr>
        <th>Id</th>
        <th>Name</th>
        <th>Course</th>
        <th>Specialty</th>
      </tr>";
for ($i = 0; $i < count($arr); $i++) {
    $values = "";
    $values .= "<td>" .$arr[$i]['id'] . "</td><td>" .$arr[$i]['fullname'] ."</td><td>" .$arr[$i]['course'] ."</td><td>" .$arr[$i]['specialty'] ."</td>";
    echo "<tr>";
    echo $values;
    echo "</tr>";
}
echo "</table>";

?>

<br>
<form method="post">
    <label>Enter course:<input type="number" name="course" min="1" max="6"></label>
    <input type="submit">
</form>