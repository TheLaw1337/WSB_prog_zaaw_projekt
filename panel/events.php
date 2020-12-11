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

//usuwanie event'u
    // Przetwarzanie danych z formularza po jego wysłaniu
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])){
        $msgs = array();
        $sql = "DELETE FROM photos WHERE eventID = ?";
        if($del = mysqli_prepare($link, $sql)){
            // Przypisanie zmiennej $param_username jako parametru do zapytania SQL
            mysqli_stmt_bind_param($del, "s", $param_event);
            // Ustawienie wartości parametru
            $param_event = $_POST['id'];
            // Uruchomienie zapytania
            if(mysqli_stmt_execute($del)){
                $sql = "DELETE FROM events WHERE eventID = ?";
                if($delete = mysqli_prepare($link, $sql)){
                    // Przypisanie zmiennej $param_username jako parametru do zapytania SQL
                    mysqli_stmt_bind_param($delete, "s", $param_event);
                    // Ustawienie wartości parametru
                    $param_event = $_POST['id'];
                    // Uruchomienie zapytania
                    if(mysqli_stmt_execute($delete))
                        $_SESSION['done'] = "Usunięto event";
                }
            }
        }

        if(!isset($_SESSION['done']))
            $_SESSION['failed'] = "Wystąpił błąd podczas usuwania event'u";
    }


//wyczytywanie wszystkich eventów
    // Przygotowanie zapytania SQL
    $sql = "SELECT * FROM events";

    if($events = mysqli_prepare($link, $sql)){
        // Uruchomienie zapytania
        if(mysqli_stmt_execute($events)){
            // Pobranie wyniku zapytania
            mysqli_stmt_store_result($events);
            // Przypisanie zmiennych do wyników zapytania
            mysqli_stmt_bind_result($events, $id, $name, $descr, $placeID, $typeID, $date);
        }
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
            if(isset($_SESSION['done'])){
                echo "<div class='alert alert-success'>".$_SESSION['done']."</div>";
                unset($_SESSION['done']);
            }
            
            if(isset($_SESSION['failed'])){
                echo "<div class='alert alert-danger'>".$_SESSION['failed']."</div>";
                unset($_SESSION['failed']);
            }
        ?>

        <div class='row align-items-center pb-2'>
            <h2 style='text-decoration: underline;' class='col-md-10'>Eventy</h2>
            <div class='col-md-2 text-right'>
                <a href="newevent.php" role="button" class="btn btn-success">Dodaj</a>
            </div>
        </div>

        <table class="table table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th></th>
                    <th>Nazwa</th>
                    <th>Data</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while(mysqli_stmt_fetch($events)){
                    // Przygotowanie zapytania SQL
                    $sql = "SELECT path FROM photos WHERE eventID = ? ORDER BY id DESC LIMIT 1";

                    if($photos = mysqli_prepare($link, $sql)){
                        // Przypisanie zmiennej $param_username jako parametru do zapytania SQL
                        mysqli_stmt_bind_param($photos, "s", $param_event);
                        // Ustawienie wartości parametru
                        $param_event = $id;
                        // Uruchomienie zapytania
                        if(mysqli_stmt_execute($photos)){
                            // Pobranie wyniku zapytania
                            mysqli_stmt_store_result($photos);
                            // Przypisanie zmiennych do wyników zapytania
                            mysqli_stmt_bind_result($photos, $path);
                        }
                    }?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form_delete"></form>
                    <tr>
                        <?php echo "
                            <td class='align-middle'>".$i.".</td>";
                            if(mysqli_stmt_fetch($photos) && file_exists('../img/'.$path))
                                echo "<td class='align-middle' style='width: 40%;'><img src='../img/".$path."' class='img-thumbnail align-middle' style='max-width:50%; min-width:6rem; height:auto;'/></td>";
                            else
                                echo "<td class='align-middle' style='width: 40%;'><img src='../img/default.png' class='img-thumbnail align-middle' style='max-width:50%; min-width:6rem; height:auto;'/></td>";
                            echo "
                            <td class='align-middle'>".$name."</td>
                            <td class='align-middle'>".$date."</td>
                            <td class='align-middle'><a href='editevent.php?id=".$param_event."'><svg class='bi bi-pencil' width='1.5rem' height='1.5rem' viewBox='0 0 16 16' fill='#2842AB' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z' clip-rule='evenodd'/><path fill-rule='evenodd' d='M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z' clip-rule='evenodd'/></svg></a></td>";?>
                            <td class="align-middle"><button class='btn' data-target="#delete" data-toggle="modal" value="<?php echo $id;?>" onclick="modal_delete(this.value)"><svg class="bi bi-trash" width="1.5rem" height="1.5rem" viewBox="0 0 16 16" fill="red" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/></svg></button></td>
                            <!-- modal -->
                                <div class="modal fade" tabindex="-1" role="dialog" role="dialog" id="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Czy na pewno chcesz usunąć ten event?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <span>Spowoduje to równiez usunięcie wszystkich zdjęć tego event'u.</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                                            <button class="btn btn-danger" name='id' form="form_delete" id='delete_button'>Usuń</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- koniec modal -->
                    </tr>
                <?php $i++; }?>
            </tbody>
                        </main>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js" type="text/javascript"></script>
    </body>
</html>