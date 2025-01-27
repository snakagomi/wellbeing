<!DOCTYPE html>
<html>
<body>

<?php

    //error logs
    error_reporting(E_ALL); 
    ini_set('display_errors','1'); 

    date_default_timezone_set('Asia/Tokyo');

    $fileName = "tempData.txt";
    $line = file($fileName);
    $lastLine = array_pop($line);
    $name = $_POST["name"];
    $tempTdy = $_POST["temperature"]; // temperature today
    $timestamp = date("m-d-Y H:i");

    //temperature yesterday (if exists)
    if (!empty($lastLine)) {
        $tempYdy = substr($lastLine, strpos($lastLine, ":") + 4);   
    }

    // output messsages
    echo "Oh, $name-san.<br>";
    echo "Your temperature today is $tempTdy.<br>";
    if ($tempTdy < 37.5) {
        echo "That's good.<br>";
    } elseif (!empty($lastLine) && $tempTdy < $tempYdy) {
        echo "That's better.<br>";
    } else {
        echo "That's high.<br>";
    }
    echo "<br>";

    // open the file
    $file = fopen($fileName, "a+");

    // output old records until EOF is reached
    while(! feof($file)) {
      $oldRecord = fgets($file);
      ?>
      <input type="checkbox" name="check_delete[]"> 
<?php
      echo $oldRecord."<br>";
    }
    ?>

     <input type="submit" name="delete" value="Delete">

<?php
    // input temperature today into the file
    fwrite($file, $timestamp);
    fwrite($file, " ");
    fwrite($file, $tempTdy);
    fwrite($file, "\n");
    fclose($file);

?>

<?php
if(isset($_POST['delete'])){//to run PHP script on submit
    echo "clicked!";
if(!empty($_POST['check_delete'])){
// Loop to store and display values of individual checked checkbox.
foreach($_POST['check_delete'] as $selected){
echo $selected."</br>";
}
}
}
?>

</body>
</html>
