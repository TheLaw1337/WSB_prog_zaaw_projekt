<?php
//Inicjacja sesji
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany - jeśli nie, przekierowanie do strony logowania
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login.php");
    exit;
}
 
// Załączenie pliku z konfiguracją połączenie z bazą danych
require_once "config.php";
 
// Zdefiniowanie zmiennych oraz ich inicjalizacja z domyślnymi pustymi wartościami
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Przetwarzanie danych z formularza po jego wysłaniu
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Walidacja nowego hasła
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Wprowadź nowe hasło";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Hasło musi zawierać co najmniej 6 znaków";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Walidacja potwierdzenia nowego hasła
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Potwierdź hasło";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Hasła nie pasują";
        }
    }
        
    // Sprawdzenie, czy wystąpiły błędy nowego/potwierdzenia nowego hasła
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Przygotowanie zapytania do aktualizacji hasła
        $sql = "UPDATE users SET Password = ? WHERE UserID = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Przypisanie zmiennych $param_password i $param_id jako parametrów do zapytania SQL
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Ustawienie parametrów
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Uruchomienie zapytania
            if(mysqli_stmt_execute($stmt)){
                // Po udanej zmianie hasła - zniszczenie sesji i przekierowanie na stronę logowania
                header("location: logout.php");
                exit();
            } else{
                echo "Ups! Coś poszło nie tak. Spróbuj ponownie później";
            }

            // Zamknięcie prepared statementu
            mysqli_stmt_close($stmt);
        }
    }
    
    // Zamknięcie połączenia
    mysqli_close($link);
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
        <?php include('content.php'); ?>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- karta z formularzem resetu hasła -->
                    <div class="card">
                        <div class="card-header">Resetowanie hasła</div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> 
                                    <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                                        <label>Nowe hasło</label>
                                        <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                                        <span class="help-block" style="color: red;"><?php echo $new_password_err; ?></span>
                                    </div>
                                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                        <label>Potwierdź hasło</label>
                                        <input type="password" name="confirm_password" class="form-control">
                                        <span class="help-block" style="color: red;"><?php echo $confirm_password_err; ?></span>
                                    </div>
                                    <div class="form-group float-right">
                                        <a class="btn btn-danger" href="admin.php">Anuluj</a>
                                        <input type="submit" class="btn btn-success" value="Zmień hasło">
                                    </div>
                                </form>
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
    </body>
</html>