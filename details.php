<?php
    // załączenie pliku z konfiguracją połączenie z bazą danych
    require_once "panel/config.php";
    
    $id = $_GET['EventID'];
    $sql = "SELECT Name, Description, Date, places.City, types.Type FROM events NATURAL JOIN places NATURAL JOIN types WHERE EventId = ".$id." LIMIT 1";

    $result = $link->query($sql);
    while ($rekord=$result->fetch_object()) {
    $eventName = $rekord->Name;
    $eventDesc = $rekord->Description;
    $eventCity = $rekord->City;
    $eventDate = $rekord->Date;
    $eventType = $rekord->Type;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szczegóły eventu</title>

    <!-- style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <!-- skrypty -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/style.css" type="text/css">
</head>
<body>
<?php include('components/navbar.html'); ?>
    <div class="container" style="min-height: 85vh;">
        <div class="col-md-10 mt-4">
            <h4><?php echo $eventType; ?></h4>
            <h1><?php echo $eventName; ?></h1>
            <p><?php echo $eventCity; ?>, <?php echo $eventDate;?></p>
            <p><?php echo $eventDesc; ?></p>
            <br>
            
        </div>
        
    </div>
<?php include('components/footer.html'); ?>
    
</body>
</html>