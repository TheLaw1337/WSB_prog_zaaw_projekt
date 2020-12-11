<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">

    <!-- skrypty -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- fonty -->
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Fredericka+the+Great&family=Lato:wght@300;400;700&family=Metal+Mania&display=swap" rel="stylesheet">

    <title>FindYourEvent - strona główna</title>
</head>

<body>
    <!-- pasek nawigacyjny -->
    <?php include('components/navbar.html'); ?>

    <!-- karuzelka -->
    <div id="myCarousel" class="carousel slide" style="max-height: 60vh;">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" style="max-height: 60vh;">
            <div class="carousel-item active" data-interval="10000">
                <div class="carousel-caption">
                    <span style="font-family: 'Metal Mania', cursive; font-size: 6vh;">KONCERTY</span><br/>
                    <p class='caption-describe d-none d-md-block'>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet rem, magni omnis earum sed minima delectus culpa animi quo nisi!</p>
                    <a class="btn btn--carousel" style="background-color: #0B7FA2;" href="search.php?type=2">Przeglądaj</a>
                </div>
                <img src="img/page/music-3507317_1280.jpg" alt="" class='w-100'>
            </div>
            <div class="carousel-item" data-interval="10000">
                <div class="carousel-caption">
                    <span style="font-family: 'Fredericka the Great', cursive; font-size: 5vh">WYSTAWY</span><br/>
                    <p class='caption-describe d-none d-md-block'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae, vero? Obcaecati rerum, officiis molestias corrupti eum totam aut maxime assumenda ad magnam commodi!</p>
                    <a class="btn btn--carousel" style="background-color: #D0C9BA;" href="search.php?type=3">Wybierz się</a>
                </div>
                <img src="img/page/art.jpg" alt="" class=" w-100">
            </div>
            <div class="carousel-item" data-interval="10000">
                <div class="carousel-caption">
                    <span style="letter-spacing: 0.8rem; font-family: 'Alfa Slab One', cursive; font-size: 6vh; ">KINO</span><br/>
                    <p class="caption-describe d-none d-md-block">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo neque exercitationem tenetur, sit facilis incidunt nostrum. Adipisci cum placeat.</p>
                    <a class="btn btn--carousel" style="background-color: #B61C2C;" href="search.php?type=1">Zobacz więcej</a>
                </div>
                <img src="img/page/cinema.png" alt="" class=" w-100">
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- galeria przykładowych eventów -->
    <div class="container text-center">
        <br>
        <h1>Najbliższe wydarzenia</h1>
        <br>
        <div class='flex-row justify-content-around'>
            <div class="karta col-md-3 col-sm-12">
                <div class="karta__side karta__side--front">
                    <div class="karta__picture karta__picture--1">
                        &nbsp;
                    </div>
                    <h4 class="karta__heading text-nowrap">
                        <span class="karta__heading-span karta__heading-span--1">
                            Noc <br/>Horrorów
                        </span>
                    </h4>
                </div>
                <div class="karta__side karta__side--back karta__side--back-1">
                    <div class="karta__cta">
                        <div class="karta__description-box">
                            <p class="karta__description-heading">Noc horrorów</p>
                            <p class="karta__description-text">Maraton klasycznych reprezentantów filmowego horroru. "Koszmar z Ulicy Wiązów", "Coś", "Halloween" i inne</p>
                        </div>
                        <a class="btn" style="background-color: #fff;" href="./details.php?EventID=9">Zobacz teraz</a>
                    </div>
                </div>
            </div>

            <div class="karta col-md-3 col-sm-12">
                <div class="karta__side karta__side--front">
                    <div class="karta__picture karta__picture--2">
                        &nbsp;
                    </div>
                    <h4 class="karta__heading text-nowrap">
                        <span class="karta__heading-span karta__heading-span--2">
                            Noc <br/>Muzeów
                        </span>
                    </h4>
                </div>
                <div class="karta__side karta__side--back karta__side--back-2">
                    <div class="karta__cta">
                        <div class="karta__description-box">
                            <p class="karta__description-heading">Noc muzeów</p>
                            <p class="karta__description-text">Muzeum Sztuki w Warszawie po raz kolejny zaprasza na udział w dorocznej Nocy Muzeów</p>
                        </div>
                        <a class="btn" style="background-color: #fff;" href="./details.php?EventID=7">Zobacz teraz</a>
                    </div>
                </div>
            </div>

            <div class="karta col-md-3 col-sm-12">
                <div class="karta__side karta__side--front">
                    <div class="karta__picture karta__picture--3">
                        &nbsp;
                    </div>
                    <h4 class="karta__heading text-nowrap">
                        <span class="karta__heading-span karta__heading-span--3">
                            Koncert<br/> w Arenie
                        </span>
                    </h4>
                </div>
                <div class="karta__side karta__side--back karta__side--back-3">
                    <div class="karta__cta">
                        <div class="karta__description-box">
                            <p class="karta__description-heading">Koncert w arenie</p>
                            <p class="karta__description-text">Koncert niespodzianka. Dalsze szczegóły wkrótce.</p>
                        </div>
                        <a class="btn" style="background-color: #fff;" href="./details.php?EventID=10">Zobacz teraz</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="search.php" class="btn btn-lg" style="background-color: #4F575E; color:#fff; margin: 2rem 0;">Zobacz wszystkie</a>
        <hr class="featurette-divider">
    </div>
    
    <!-- stopka -->
    <?php include('components/footer.html'); ?>
</body>
</html>