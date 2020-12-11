<?php
// Inicjalizacja sesji
session_start();
 
// Sprawdzenie, czy użytkownik jest zalogowany - jeżeli tak, to przekierowanie do panelu administracyjnego
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: panel/admin.php");
    exit;
}
 
// załączenie pliku z konfiguracją połączenie z bazą danych
require_once "panel/config.php";
 
// Zdefiniowanie zmiennych oraz ich inicjalizacja z domyślnymi pustymi wartościami
$username = $password = "";
$errors = array();
 
// Przetwarzanie danych z formularza po jego wysłaniu
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Sprawdzenie, czy nazwa użytkownika nie jest pusta
    if(empty(trim($_POST["username"]))){
        array_push($errors, "Please enter username.");
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Sprawdzenie, czy hasło nie jest puste
    if(empty(trim($_POST["password"]))){
        array_push($errors, "Please enter your password.");
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Walidacja nazwy użytkownika i hasła
    if(empty($username_err) && empty($password_err)){
        // Przygotowanie zapytania SQL
        $sql = "SELECT UserID, Name, Password FROM users WHERE Name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Przypisanie zmiennej $param_username jako parametru do zapytania SQL
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Ustawienie wartości parametru
            $param_username = $username;
            
            // Uruchomienie zapytania
            if(mysqli_stmt_execute($stmt)){
                // Pobranie wyniku zapytania
                mysqli_stmt_store_result($stmt);
                // Sprawdzenie, czy nazwa użytkownika isnieje - jeśli tak, przejście do sprawdzenia hasła
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Przypisanie zmiennych do wyników zapytania
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Przechowanie danych w zmiennych sesji
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Przekierowanie do panelu administracyjnego
                            header("location: panel/admin.php");
                        } else{
                            // Wyświetlenie błędu w przypadku nieprawidłowego hasła
                            array_push($errors, "Nieprawidłowe dane logowania");
                        }
                    }
                } else{
                    // Wyświetlenie błędu w przypadku nieprawidłowej nazwy użytkownika
                    array_push($errors, "Nieprawidłowe dane logowania");
                }
            } else{
                array_push($errors, "Ups! Coś poszło nie tak. Spróbuj ponownie później");
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
    <title>Logowanie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <!-- navbar -->
    <?php include('components/navbar.html'); ?>
    <!-- kontener z panelem logowania -->
    <div class="container" style="margin-top: 10vh; height: 85vh;">
        <?php
            if(count($errors) > 0)
            {
                foreach($errors as $error)
                {
                    echo "<div class='alert alert-danger'>".$error."</div><br/>";
                    array_shift($errors);
                }
            }
        ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- karta z formularzem logowania -->
                <div class="card">
                    <div class="card-header">Logowanie</div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group row">
                                <label for="login" class="col-md-4 col-form-label text-md-right">Login</label>

                                <div class="col-md-6">
                                    <input id="login" type="text" class="form-control" name="username" required autocomplete="on" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Hasło</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Zaloguj
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- stopka -->
    <?php include('components/footer.html'); ?>
</body>
</html>