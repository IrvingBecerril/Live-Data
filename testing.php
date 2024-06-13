<!DOCTYPE html>
<html>
<head>
    <title>PHP Table</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <?php
    $data = array(
        array("Name"=>"John", "Age"=>25, "Country"=>"USA"),
        array("Name"=>"Anna", "Age"=>24, "Country"=>"UK"),
        array("Name"=>"Peter", "Age"=>22, "Country"=>"Germany"),
    );
    echo "<table>";
    echo "<tr><th>Name</th><th>Age</th><th>Country</th></tr>";
    foreach($data as $row) {
        echo "<tr>";
        echo "<td>".$row["Name"]."</td>";
        echo "<td>".$row["Age"]."</td>";
        echo "<td>".$row["Country"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>
</html>
