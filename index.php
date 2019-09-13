<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php

setlocale(LC_MONETARY, 'sv_SE');
header('Content-Type: text/html; charset=latin-1');
ini_set('default_charset', 'latin-1');
error_reporting( E_ERROR );

$servername = "se-production-inteleon-db02.cbzmrhqpvsxe.eu-central-1.rds.amazonaws.com";
$username = "alexander_levin";
$password = "457s1RikZNceyDd0Ytp";

// Parkowners we want to sort
$parkowners_id = 241;

$connection = new mysqli(
	$servername, 
	$username, 
	$password
);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 

echo '<table style="border-collapse: collapse; border: 1px solid black;">';
echo "<th>Zonecode</th>";
echo "<th>Owner</th>";
echo "<th>Disabled</th>";
echo "<th>Created_date</th>";
echo "<th>Rate</th>";
echo "<th>Parkings_last_6m</th>";
echo "<th></th>";
echo "<th></th>";echo "<th></th>";
echo "<th></th>";echo "<th></th>";
echo "<th></th>";
echo "<th></th>";
echo "<th></th>";
echo "<th></th>";echo "<th></th>";echo "<th></th>";

//echo "hello world!";

function mb_unserialize($string) {
    $string = preg_replace_callback('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $string);
    return unserialize($string);
}

$sql = "
	SELECT zones.id, zones.ratedesc, zones.location, zones.zonecode, zones.place, zones.owner, zones.disabled, from_unixtime(zones.created_date, '%Y-%m-%d') as created_date, count(p.id) as parkeringar
	FROM smspark.parkings p
        JOIN smspark.zones on smspark.zones.id = smspark.p.zoneid 
	JOIN smspark.parkowners on smspark.zones.owner = smspark.parkowners.id
	WHERE smspark.zones.owner = 241
        AND from_unixtime(smspark.p.starttime, '%Y-%m-%') > '2019-03-11'
        GROUP BY smspark.zones.id
";

$result = $connection->query($sql);
if ($result->num_rows > 0) {

	//var_dump($result->fetch_assoc()); die;
	echo '<tr style="border: 1px solid black">';
	
	while($row = $result->fetch_assoc()) {
		echo "<td>".$row['zonecode']."</td>";
		echo "<td>".$row['owner']."</td>";
		echo "<td>".($row['disabled'] ? 'Yes' : 'No') ."</td>";
                echo "<td>".$row['created_date']."</td>";
                echo "<td>".$row['parkeringar']."</td>";

		foreach (mb_unserialize($row['ratedesc']) as $key => $value) {
			echo "<td>".implode(" ", $value)."</td>";
		}
		echo "</tr>";
	}
}

echo "</table>";

$connection->close();

?>
    </body>
</html>
