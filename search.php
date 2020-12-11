<?php
    // załączenie pliku z konfiguracją połączenie z bazą danych
    require_once "panel/config.php";


    // Przygotowanie zapytania SQL
    $sql = "SELECT * FROM events NATURAL JOIN places";
    // jeżeli jest wybrany typ eventu i nie jest pusty
    if(isset($_GET['type']) and ($_GET['type'] != ''))
    {
        $sql .= " WHERE TypeID = ".$_GET['type'];
    }
    // jeżeli jest wybrany niepusty typ eventu oraz niepuste miejsce
    if(isset($_GET['type']) and ($_GET['type'] != '') and isset($_GET['place']) and ($_GET['place'] != ''))
    {
        $sql .= " AND City = '".$_GET['place']."'";
    }
    //jeżeli jest wybrany pusty typ eventu oraz niepuste miejsce
    elseif (isset($_GET['type']) and ($_GET['type'] == '') and isset($_GET['place']) and ($_GET['place'] != '')) {
        $sql .= " WHERE City = '".$_GET['place']."'";
    }

    if($events = mysqli_prepare($link, $sql)){
        // Uruchomienie zapytania
        if(mysqli_stmt_execute($events)){
            // Pobranie wyniku zapytania
            mysqli_stmt_store_result($events);
            // Przypisanie zmiennych do wyników zapytania
            mysqli_stmt_bind_result($events, $placeID, $eventID, $name, $descr, $typeID, $date, $city, $street, $number, $postalcode);
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <!-- skrypty -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/style.css" type="text/css">
    
    <title>Wyszukiwanie</title>
</head>
<body>
<?php include('components/navbar.html'); ?>
    <div class="container" style="min-height: 85vh;">
        <div class="row">
            <div class="col-md-2 mt-4">
                <div class="card text-center">
                    <div class="card-header">Filtry</div>
                    <div class="card-body">
                        <div class="card-text">
                            <form class="filters-form" method="GET">
                            <div class="form-group">
                                <label for="inputType" class="input-label">Typ eventu</label>
                                    <select id="inputType" name="type" class="form-control"">
                                        <option value="">Wybierz</option>
                                        <?php
                                        $result = mysqli_query($link, "SELECT TypeID, Type FROM types ORDER BY TypeID ASC" );
                                        
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            echo "<option value=".$row['TypeID'].">".$row['Type']."</option>";
                                        }
                                        ?>
                                    </select> 
                            </div>
                            <div class="form-group">
                                <label for="inputType" class="input-label">Miasto</label>
                                    <select id="inputType" name="place" class="form-control"">
                                        <option value="">Wybierz</option>
                                        <?php
                                        $result = mysqli_query($link, "SELECT DISTINCT(City) FROM places ORDER BY PlaceID ASC" );
                                        
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            echo "<option value=".$row['City'].">".$row['City']."</option>";
                                        }
                                        ?>
                                    </select> 
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Filtruj</button>
                            </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 mt-4">
                <?php while(mysqli_stmt_fetch($events)){ 
                    // Przygotowanie zapytania SQL
                    $sql = "SELECT path FROM photos WHERE eventID = ? ORDER BY id DESC LIMIT 1";

                    if($photos = mysqli_prepare($link, $sql)){
                        // Przypisanie zmiennej $param_username jako parametru do zapytania SQL
                        mysqli_stmt_bind_param($photos, "s", $param_event);
                        // Ustawienie wartości parametru
                        $param_event = $eventID;
                        // Uruchomienie zapytania
                        if(mysqli_stmt_execute($photos)){
                            // Pobranie wyniku zapytania
                            mysqli_stmt_store_result($photos);
                            // Przypisanie zmiennych do wyników zapytania
                            mysqli_stmt_bind_result($photos, $path);
                        }
                    }?>
                    <!-- karta eventu -->
                    <a href="details.php?EventID=<?php echo $eventID;?>" style="color: black; text-decoration: none;">
                        <div class='card col-md-10 mb-3 mx-auto'>
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <?php   if(mysqli_stmt_fetch($photos) && file_exists('img/'.$path))
                                                    echo "<img src='img/".$path."' class='card-img' style='height:100%;'/>";
                                            else
                                                echo "<img src='img/default.png' class='card-img' style='height:100%;'/>";
                                    ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $name;?></h5>
                                        <p class="card-text"><?php echo $descr;?></p>
                                        <p class="card-text"><small class="text-muted"><?php echo $date;?></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php include('components/footer.html'); ?>
</body>
</html>