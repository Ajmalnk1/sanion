<?php
include 'config.php';
// $array = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

// $serialized_array = serialize($array); 


// $sql = "INSERT INTO ser_unser (data) VALUES ('$serialized_array')";

// if (mysqli_query($conn, $sql)) {
//     echo "inserted";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
// }

// $sql = "SELECT data FROM ser_unser";
// $result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//         $ser_data =  $row["data"];
//         $unserialized_array = unserialize($ser_data); 
//         print_r($unserialized_array);
//         echo "<br>";
//     }
    
// } else {
//     echo "0 results";
// }

// $products = array();
echo "<pre>";
print_r($_REQUEST);
?>

<form action="array.php" method="post">
Product Name: <input type="text" name="product1" value="Prod A"><br>
Quantity: <input type="text" name="quantity1" value="3"><br>
Product Name: <input type="text" name="product2" value="Prod B"><br>
Quantity: <input type="text" name="quantity2" value="4"><br>
<input type="submit">
</form>