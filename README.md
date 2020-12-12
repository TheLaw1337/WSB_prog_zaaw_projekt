# WSB_prog_zaaw_projekt
Repozytorium do projektu na przedmiot "Programowanie zaawansowane"


## Uruchomienie
Do uruchomienia aplikacji wymagany jest zainstalowany pakiet XAMPP.

1. Otwórz terminal/wiersz polecenia w folderze `htdocs` XAMPPa (domyślnie `C:/xampp/htdocs`)
3. Sklonuj repozytorium komendą `git clone https://github.com/TheLaw1337/WSB_prog_zaaw_projekt.git`
4. Uruchom panel XAMPPa i włącz serwery Apache i MySQL
5. Przejdź do phpMyAdmin (`localhost/phpmyadmin`) i zaimportuj bazę danych z pliku `projekt.sql`

Główna strona aplikacji jest dostępna pod adresem `localhost/projekt`

## Panel administracyjny

Panel adminstracyjny jest dostępny wyłącznie dla użytkowników, którym zostały uprzednio założone konta (brak możliwości samodzielnej rejestracji).

Panel logowania jest dostępny pod adresem `localhost/projekt/login.php`. Do celów testowych przygotowano konto o nazwie użytkownika `daniel.sobczak` z hasłem `qwerty`. 
