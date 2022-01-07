<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Speedtest</title>
    <style>
        th {
            background-color: #f2f2f2 !important;
            position: sticky;
            top: 0;
        }
    </style>
</head>

<body>
    <table class="table table-striped" id="speed">
        <tr>
            <th>Timestamp (Date Time)</th>
            <th>Download (Mb/s)</th>
            <th>Upload (Mb/s)</th>
            <th>Ping (ms)</th>
            <th>Server name</th>
            <th>Server country</th>
            <th>ISP</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "networking";
        $password = "networkingPass";
        $dbname = "network";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "select timestamp, download, upload, ping, server_name, server_country, client_isp from speedtest order by timestamp desc";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>'.$row['timestamp'].'</td>';
                echo '<td>'.round($row['download']*10**-6,2).'</td>';
                echo '<td>'.round($row['upload']*10**-6,2).'</td>';
                echo '<td>'.round($row['ping'],2).'</td>';
                echo '<td>'.$row['server_name'].'</td>';
                echo '<td>'.$row['server_country'].'</td>';
                echo '<td>'.$row['client_isp'].'</td>';
                echo '</tr>';
            }
        } else {
            echo "No results";
        }
        $conn->close();
        ?>

    </table>
</body>

</html>

