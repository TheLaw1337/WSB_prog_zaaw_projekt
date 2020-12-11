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

//dodawanie event'u
    // Przetwarzanie danych z formularza po jego wysłaniu
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //dodawanie event'u
        $sql = "INSERT INTO events (Name, description, PlaceID, TypeID, Date) VALUES (?, ?, ?, ?, ?)";
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
                $_SESSION['done'] = 'Dodano event';
        }

        //dodawanie zdjęć
        if(isset($_SESSION['done'])){
            //pobranie ostatniego EventID
            $sql = "SELECT EventId FROM events ORDER BY EventId DESC LIMIT 1";
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
                $_SESSION['done'] = 'Dodano event!';
                header('Location: events.php');
            }
        }

        if(!isset($_SESSION['done']) && !isset($_SESSION['failed']))
            $_SESSION['failed'] = "Wystąpił błąd podczas dodawania event'u";
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
    ?>
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-dark text-white">Nowy event</div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" id='event_form'>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Nazwa</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" required autocomplete="on" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="type" class="col-md-4 col-form-label text-md-right">Typ</label>

                        <div class="col-md-6">
                            <select id='type' name='type' class='custom-select' required>
                            <option value="" disabled selected>Wybierz typ</option>
                                <!-- placeholder rozwijalnego pola -->
                                <?php
                                    while(mysqli_stmt_fetch($types)){
                                        echo "<option value='".$typeID."'>".$type."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="place" class="col-md-4 col-form-label text-md-right">Miejsce</label>

                        <div class="col-md-6">
                            <select id='place' name='place' class='custom-select' required>
                                <option value="" disabled selected>Wybierz miejsce</option>
                                <!-- placeholder rozwijalnego pola -->
                                <?php
                                    while(mysqli_stmt_fetch($places)){
                                        echo "<option value='".$placeID."'>".$postal." ".$city." / ".$street." ".$number."</option>";
                                    }
                                ?>
                            </select>
                            <span>Dodaj nowe miejsce:
                                <a href="newplace.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill-rule="evenodd" d="M11.75 4.5a.75.75 0 01.75.75V11h5.75a.75.75 0 010 1.5H12.5v5.75a.75.75 0 01-1.5 0V12.5H5.25a.75.75 0 010-1.5H11V5.25a.75.75 0 01.75-.75z"></path></svg></a>
                            </span>
                        </div>
                    </div>

                    

                    <div class="form-group row">
                        
                        <label for="date" class="col-md-4 col-form-label text-md-right">Data</label>

                        <div class="col-md-6">
                            <input type='datetime-local' class='form-control' name='date' id='date' required/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="descr" class="col-md-4 col-form-label text-md-right">Opis</label>

                        <div class="col-md-6">
                            <textarea class='form-control' rows='7' id='descr' name='descr' style="resize:none;" placeholder='Opis' required></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label text-md-right">Zdjęcia</label>
                        <div class="custom-file col-md-6">
                            <label class="custom-file-label" for="inputFile">Wybierz zdjęcie</label>
                            <input type="file" id="filepicker" class="custom-file-input" id="inputFile" name="file[]" multiple/>
                        </div>
                        <div class="col-md-4"></div>
                        <ul class='col-md-6' id="labelFilepicker" style="list-style-type: none;">

                        </ul>
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