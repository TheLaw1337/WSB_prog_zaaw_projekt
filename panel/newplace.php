<?php
// Inicjalizacja sesji
session_start();
 
// Sprawdzenie, czy użytkownik jest zalogowany - jeśli nie, przekierowanie na stronę logowania
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login.php");
    exit;
}

// załączenie pliku z konfiguracją połączenie z bazą danych
require_once "config.php";

//wyczytywanie typów eventów
    // Przygotowanie zapytania SQL
    $sql = "SELECT * FROM types";

    if($types = mysqli_prepare($link, $sql)){
        // Uruchomienie zapytania
        if(mysqli_stmt_execute($types)){
            // Pobranie wyniku zapytania
            mysqli_stmt_store_result($types);
            // Przypisanie zmiennych do wyników zapytania
            mysqli_stmt_bind_result($types, $typeID, $type);
        }
    }

//wyczytywanie miejsc eventów
    // Przygotowanie zapytania SQL
    $sql = "SELECT * FROM places";

    if($places = mysqli_prepare($link, $sql)){
        // Uruchomienie zapytania
        if(mysqli_stmt_execute($places)){
            // Pobranie wyniku zapytania
            mysqli_stmt_store_result($places);
            // Przypisanie zmiennych do wyników zapytania
            mysqli_stmt_bind_result($places, $placeID, $city, $street, $number, $postal);
        }
    }

//dodawanie miejsca
    // Przetwarzanie danych z formularza po jego wysłaniu
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //dodawanie miejsca
        $sql = "INSERT INTO places (City, Street, Number, PostalCode) VALUES (?, ?, ?, ?)";
        if($place = mysqli_prepare($link, $sql)){
            // Przypisanie zmiennych jako parametrów do zapytania SQL
            mysqli_stmt_bind_param($place, "ssis", $param_city, $param_street, $param_number, $param_code);
            // Ustawienie wartości parametrów
            $param_city = $_POST['city'];
            $param_street = $_POST['street'];
            $param_number = (int)$_POST['number'];
            $param_code = $_POST['postal_code'];
            // Uruchomienie zapytania
            if(mysqli_stmt_execute($place))
                $_SESSION['done'] = 'Dodano miejsce';
        }

        // //dodawanie zdjęć
        // if(isset($_SESSION['done'])){
        //     //pobranie ostatniego EventID
        //     $sql = "SELECT EventId FROM events ORDER BY EventId DESC LIMIT 1";
        //     if($event = mysqli_prepare($link, $sql)){
        //         // Uruchomienie zapytania
        //         if(mysqli_stmt_execute($event)){
        //             // Pobranie wyniku zapytania
        //             mysqli_stmt_store_result($event);
        //             // Przypisanie zmiennych do wyników zapytania
        //             mysqli_stmt_bind_result($event, $last_id);
        //         }
        //     }

        //     if(mysqli_stmt_fetch($event))
        //         $lastID = $last_id;

        //     for($i=0 ; $i < count($_FILES['file']['name']); $i++){
        //         //walidacja plików
        //         $fileType = strtolower(pathinfo(basename($_FILES['file']['name'][$i]),PATHINFO_EXTENSION));
        //         if($fileType == "png" || $fileType="jpg"){
        //             $file_name = pathinfo(basename($_FILES['file']['name'][$i]), PATHINFO_FILENAME).'_'.$lastID.'.'.$fileType;

        //             $sql = "INSERT INTO photos (path, eventID) VALUES (?, ?)";
        //             if($photos = mysqli_prepare($link, $sql)){
        //                 // Przypisanie zmiennych jako parametrów do zapytania SQL
        //                 mysqli_stmt_bind_param($photos, "sd", $param_path, $param_eventID);
        //                 // Ustawienie wartości parametrów
        //                 $param_path = $file_name;
        //                 $param_eventID = $lastID;
        //                 // Uruchomienie zapytania
        //                 if(mysqli_stmt_execute($photos)){
        //                     //upload zdjęć na serwer
        //                     if(!move_uploaded_file($_FILES['file']['tmp_name'][$i], "../img/$file_name")){
        //                         unset($_SESSION['done']);
        //                         $_SESSION['failed'] = 'Wystąpił błąd podczas uploadowania zdjęć na serwer';
        //                         header('Location: events.php');
        //                     }
        //                 }
        //                 else{
        //                     unset($_SESSION['done']);
        //                     $_SESSION['failed'] = 'Wystąpił błąd podczas dodawania zdjęć';
        //                     header('Location: events.php');
        //                 }
        //             }
        //         }
        //     }
        //     if(!isset($_SESSION['failed'])){
        //         $_SESSION['done'] = 'Dodano event!';
        //         header('Location: events.php');
        //     }
        // }

        if(!isset($_SESSION['done']) && !isset($_SESSION['failed']))
            $_SESSION['failed'] = "Wystąpił błąd podczas dodawania miejsca";
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administracyjny</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="app.css" type="text/css">
</head>
    <!-- załączenie zawartości panelu -->
    <?php include('content.php');
        if(isset($_SESSION['failed'])){
            echo "<div class='alert alert-danger'>".$_SESSION['failed']."</div>";
            unset($_SESSION['failed']);
        }
        if(isset($_SESSION['done'])){
            echo "<div class='alert alert-success'>".$_SESSION['done']."</div>";
            unset($_SESSION['done']);
        }
    ?>
    <div class="col-md-8 mx-auto">
        <div class="alert alert-primary" role="alert">
            Pamiętaj, aby po dodaniu miejsca odświeżyć stronę dodawania/edycji eventu!
        </div>
        <div class="card">
            <div class="card-header bg-dark text-white">Nowe miejsce</div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" id='event_form'>
                    <div class="form-group row">
                        <label for="city" class="col-md-4 col-form-label text-md-right">Miasto</label>

                        <div class="col-md-6">
                            <input id="city" type="text" class="form-control" name="city" required autocomplete="on" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="street" class="col-md-4 col-form-label text-md-right">Ulica</label>

                        <div class="col-md-6">
                            <input id="street" type="text" class="form-control" name="street" required autocomplete="on"> 
                        </div>
                    </div>

                    

                    <div class="form-group row">
                        <label for="number" class="col-md-4 col-form-label text-md-right">Nr budynku</label>

                        <div class="col-md-6">
                            <input id="number" type="text" class="form-control" name="number" required autocomplete="on" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="postal_code" class="col-md-4 col-form-label text-md-right">Kod pocztowy</label>

                        <div class="col-md-6">
                            <input id="postal_code" type="text" class="form-control" name="postal_code" required autocomplete="on">
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3 text-right">
                        <a href="events.php" class='btn btn-primary text-white'>Wróć</a>
                        <button class='btn btn-success' form='event_form'>Dodaj</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js" type="text/javascript"></script>
    </body>
</html>