<?php
/* Nazwa bazy, tabeli oraz poświadczenia do bazy */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'projekt');
 
/* Ustanowienie połączenia z bazą danych */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
/* Sprawdzenie połączenia */
if($link === false){
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
?>