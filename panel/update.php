<?php session_start();
require_once 'config.php';
        
//dodawanie event'u
$sql = "UPDATE events SET Name=?, Description=?, PlaceID=?, TypeID=?, Date=? WHERE EventID=".$_SESSION['eventID'];
// $sql = "UPDATE events SET Name=\'".$_POST['name']."\', description=\'".$_POST['descr']."\', PlaceID=".(int)$_POST['place'].", TypeID=".(int)$_POST['type']." Date=\'".$_POST['date']."'";
if($event = mysqli_prepare($link, $sql)){
    // Przypisanie zmiennych jako parametrów do zapytania SQL
    mysqli_stmt_bind_param($event, "ssdds", $param_name, $param_descr, $param_place, $param_type, $param_date);
    // Ustawienie wartości parametrów
    $param_name = $_POST['name'];
    $param_descr = $_POST['descr'];
    $param_place = (int)$_POST['place'];
    $param_type = (int)$_POST['type'];
    $param_date = $_POST['date'];
    // Uruchomienie zapytania
    if(mysqli_stmt_execute($event))
        $_SESSION['done'] = 'Zaktualizowano event';
}

//dodawanie zdjęć
if(isset($_SESSION['done'])){
    //pobranie EventID wydarzenia celem podmiany zdjęcie
    $sql = "SELECT EventId FROM events WHERE EventId =".$_SESSION['eventID'];
    if($event = mysqli_prepare($link, $sql)){
        // Uruchomienie zapytania
        if(mysqli_stmt_execute($event)){
            // Pobranie wyniku zapytania
            mysqli_stmt_store_result($event);
            // Przypisanie zmiennych do wyników zapytania
            mysqli_stmt_bind_result($event, $last_id);
        }
    }

    if(mysqli_stmt_fetch($event))
        $lastID = $last_id;

    for($i=0 ; $i < count($_FILES['file']['name']); $i++){
        //walidacja plików
        $fileType = strtolower(pathinfo(basename($_FILES['file']['name'][$i]),PATHINFO_EXTENSION));
        if($fileType == "png" || $fileType="jpg"){
            $file_name = pathinfo(basename($_FILES['file']['name'][$i]), PATHINFO_FILENAME).'_'.$lastID.'.'.$fileType;

            $sql = "INSERT INTO photos (path, eventID) VALUES (?, ?)";
            if($photos = mysqli_prepare($link, $sql)){
                // Przypisanie zmiennych jako parametrów do zapytania SQL
                mysqli_stmt_bind_param($photos, "sd", $param_path, $param_eventID);
                // Ustawienie wartości parametrów
                $param_path = $file_name;
                $param_eventID = $lastID;
                // Uruchomienie zapytania
                if(mysqli_stmt_execute($photos)){
                    //upload zdjęć na serwer
                    if(!move_uploaded_file($_FILES['file']['tmp_name'][$i], "../img/$file_name")){
                        unset($_SESSION['done']);
                        $_SESSION['failed'] = 'Wystąpił błąd podczas uploadowania zdjęć na serwer';
                        header('Location: events.php');
                    }
                }
                else{
                    unset($_SESSION['done']);
                    $_SESSION['failed'] = 'Wystąpił błąd podczas dodawania zdjęć';
                    header('Location: events.php');
                }
            }
        }
    }
    if(!isset($_SESSION['failed'])){
        $_SESSION['done'] = 'Zaktualizowano event!';
        header('Location: events.php');
    }
}

if(!isset($_SESSION['done']) && !isset($_SESSION['failed']))
    $_SESSION['failed'] = "Wystąpił błąd podczas dodawania event'u";
?>