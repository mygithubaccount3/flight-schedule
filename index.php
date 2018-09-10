<!DOCTYPE html>
<html>
    <head>
        <title>Airport Departure Schedule</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="airport.js"></script>
        <link rel="stylesheet" type="text/css" href="airport.css">
    </head>
    <body onload="getTime(); setInterval(getTime, 1000); setupdt();">
        <form>
            <input type='text' id='inp' placeholder='Search: type destination'>
        </form>
        <div id = 'time'>
        </div>
        <script type="text/javascript"></script>
        <div id="dv">
        <table id="tbl">
            <tr>
                <th>Flight</th>
                <th>Time</th>
                <th>Destination</th>
                <th>Carrier</th>
                <th>Terminal</th>
                <th>Status</th>
            </tr>
        <?php
        $statuses = array("Delay", "Canceled");
        $n = count($statuses);
        function uniqRand($min, $max, $quantity) {
            $numbers = range($min, $max);
            shuffle($numbers);
            return array_slice($numbers, 0, $quantity);
        }
        $conn = new mysqli ('localhost', 'admin', 'nimda', 'airport');
        if ($conn->connect_error) die('Fatal error');
        date_default_timezone_set("Europe/Kiev");
        $qr = "SELECT COUNT(*) FROM flights";
        $result = $conn->query($qr);
        $rows_count = $result->fetch_array(MYSQLI_NUM);
        $accRow = uniqRand(0, $rows_count[0], 5);
        echo count($accRow);
        for ($i=0; $i < count($accRow); $i++) { 
           $accElLength = rand(0, $n - 1);
            $schedule_event = "CREATE EVENT IF NOT EXISTS random_status_$i ON SCHEDULE EVERY 1 DAY STARTS CURRENT_TIMESTAMP DO UPDATE flights SET status='$statuses[$accElLength]' WHERE id='$accRow[$i]'";
            //echo $schedule_event."<br>";

            $conn->query($schedule_event);
        }
        
        $query = "SELECT * FROM flights ORDER BY departure_time";
        //$query = "UPDATE flights SET departure_time='23:15:00' WHERE destination='Kyiv'";
        //$conn->query($query);
        $result = $conn->query($query);
        $row = "";
        if (!result) die("Fatal error");
        $n = 0;
    while($row = $result->fetch_assoc()) {
        echo "<tr>" . "<td>". $row["flight"] . "</td>" . "<td>" . $row["departure_time"] . "</td>" . "<td>" . $row["destination"] . "</td>" . "<td>" . $row["carrier"] . "</td>" . "<td>" . $row["terminal"] . "</td>" . "<td>" . $row["status"] . "</td>" . "</tr>";
    }
$conn->close();
        ?>
    </table>
    <script>
    </script>
    </div>
    </body>
    </html>