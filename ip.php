<!DOCTYPE html>
<html lang="hr">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <title>IP info</title>

    </head>

    <body>
        <?php
        $servername = "localhost";
        $username = "networking";
        $password = "networkingPass";
        $dbname = "network";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $result = $conn->query("CALL last_ip_change();");
        echo '<h3>Last IP change happened:<h3>';
        echo '<h4>' . $result->fetch_assoc()["since"] . '<h4>';
        $result = $conn->query("SELECT COUNT(DISTINCT ip), COUNT(*) FROM ip_history;");
        $row = $result->fetch_assoc();
        echo '<h3>Number of distinct IPs:<h3>';
        echo '<h4>' . $row["COUNT(DISTINCT ip)"] . ' of ' . $row["COUNT(*)"] . ' total IPs ' . '<h4>';
        $conn->close();
        ?>
    </body>
</html>


