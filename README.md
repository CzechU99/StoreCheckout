# Store Checkout

## Opis projektu

Store Checkout to aplikacja webowa umożliwiająca użytkownikom składanie zamówień online. Składa się z części backendowej (PHP + MySQL) oraz frontendowej (Vue.js). Backend obsługuje operacje związane z bazą danych i logiką zamówień, natomiast frontend zapewnia interfejs użytkownika.

---

## Instalacja i konfiguracja

### 1. Backend

1. **Import bazy danych**  
   - Wgraj plik `smartbees.sql` znajdujący się w folderze `backend/database` do swojej bazy danych MySQL.

2. **Konfiguracja połączenia z bazą danych**  
   - Edytuj plik `backend/php/newDbConfig.php` i uzupełnij go odpowiednimi danymi dostępowymi do bazy danych (host, użytkownik, hasło, nazwa bazy).

3. **Wrzucenie backendu na serwer**  
   - Skopiuj cały folder `backend` na swój serwer.

4. **Instalacja zależności PHP**  
   - Wejdź do folderu `backend` i uruchom:  
     ```sh
     composer install
     ```

5. **Uruchomienie testów backendu**  
   - W folderze `backend` uruchom:  
     ```sh
     composer phpunit
     ```

---

### 2. Frontend

1. **Instalacja zależności**  
   - Przejdź do folderu `frontend` i uruchom:  
     ```sh
     npm install
     ```

2. **Konfiguracja połączenia z backendem**  
   - W pliku `.env` znajdującym się w folderze `frontend` ustaw zmienną `VITE_API_BASE_URL` na adres serwera, gdzie znajduje się folder `backend`, np.:  
     ```env
     VITE_API_BASE_URL=http://localhost/storecheckout/backend
     ```

3. **Uruchomienie frontendu**  
   - W folderze `frontend` uruchom:  
     ```sh
     npm run dev
     ```

---

## Dodatkowe uwagi

- Backend wymaga **PHP** oraz **MySQL** do działania.
- Frontend wymaga **Node.js** i **npm** do instalacji oraz uruchamiania.
- Testy jednostkowe wymagają zainstalowania **PHPUnit** oraz włączonego rozszerzenia **MySQLLi**.
