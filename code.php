<?php 
// Database connection settings 
$hostname = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "sensor_db"; 
// Connect to the database 
$conn = mysqli_connect($hostname, $username, $password, $database); 
// Check for connection error 
if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error()); 
} 
echo "Database Connection Success"; 
// Check if POST variables are set 
if (isset($_POST["Temparature"], $_POST["Humidity"], $_POST["WaterLevel"], 
$_POST["MoistureLevel"], $_POST["LightIntensity"])) { 
    $t = (float)$_POST["Temparature"]; 
    $h = (float)$_POST["Humidity"]; 
    $w = (float)$_POST["WaterLevel"]; 
    $m = (float)$_POST["MoistureLevel"]; 
    $l = (float)$_POST["LightIntensity"]; 
    // Insert data into the database 
    $sql = "INSERT INTO sensors_data (Temparature, Humidity, WaterLevel, 
MoistureLevel, LightIntensity) VALUES ($t, $h, $w, $m, $l)"; 
    // Execute the query and provide feedback 
    if (mysqli_query($conn, $sql)) { 
        echo "New record created successfully"; 
    } else { 
        echo "Error: " . $sql . "<br>" . mysqli_error($conn); 
    } 
} else { 
    echo "Required data not provided"; 
} 
// Close the connection 
mysqli_close($conn); 
?> 

<?php 
$conn = mysqli_connect("localhost", "root", "", "sensor_db"); 
if ($conn) { 
$result = mysqli_query($conn, "SELECT * FROM sensors_data"); 
if (mysqli_num_rows($result) > 0) { 
$sums = ["Temperature" => 0, "Humidity" => 0, "WaterLevel" => 0, 
"MoistureLevel" => 0, "LightIntensity" => 0]; 
$count = 0;   
while ($row = mysqli_fetch_assoc($result)) { 
foreach ($sums as $key => &$value) { 
$value += $row[$key]; 
} 
$count++; 
} 
  $averages = array_map(fn($sum) => $sum / $count, $sums); 
echo json_encode($averages); 
} else { 
echo json_encode([]); 
}   
mysqli_close($conn); 
} else { 
die("Connection failed: " . mysqli_connect_error()); 
} 
?>
