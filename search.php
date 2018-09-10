<?php
        $conn = new mysqli ('localhost', 'admin', 'nimda', 'airport');
        if ($conn->connect_error) die('Fatal error');
        $t = $_POST["suggest"];
        if ($t != null) {
            $query = "SELECT * FROM flights WHERE destination LIKE \"$t%\"";
        }
        else {
            $query = "SELECT * FROM flights";
        }
        $result = $conn->query($query);
        if (!result) die("Fatal error");
        echo "<tr><th>Flight</th><th>Time</th><th>Destination</th><th>Carrier</th><th>Terminal</th><th>Status</th></tr>";
        while($row = $result->fetch_assoc()) {
        echo "<tr>" . "<td>". $row["flight"] . "</td>" . "<td>" . $row["departure_time"] . "</td>" . "<td>" . $row["destination"] . "</td>" . "<td>" . $row["carrier"] . "</td>" . "<td>" . $row["terminal"] . "</td>" . "<td>" . $row["status"] . "</td>" . "</tr>";
    }
$conn->close();
        ?>