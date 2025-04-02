@echo off
setlocal enabledelayedexpansion

:: CONFIG
set BASE_URL=http://localhost/bellatrix-backend/public
set EMAIL=jp@free.fr
set PASSWORD=root

echo 🔐 Test de connexion à l'API...

:: LOGIN
curl -s -X POST %BASE_URL%/login -H "Content-Type: application/json" -d "{\"email\":\"%EMAIL%\", \"password\":\"%PASSWORD%\"}" > login_response.txt

:: Lire et extraire le token
set TOKEN=
for /f "tokens=1,2 delims=:" %%A in ('findstr "token" login_response.txt') do (
    set "RAW_TOKEN=%%B"
    set "TOKEN=!RAW_TOKEN:"=!"
)

if not defined TOKEN (
    echo ❌ Login échoué
    type login_response.txt
    del login_response.txt
    exit /b 1
)

echo ✅ Login OK - Token: %TOKEN%
del login_response.txt

:: TEST GET /activites
echo.
echo GET /activites
curl -s -X GET %BASE_URL%/activites -H "Authorization: Bearer %TOKEN%" >nul
if errorlevel 1 (
    echo ❌ GET /activites échoué
) else (
    echo ✅ OK
)

:: TEST GET /reservations
echo.
echo GET /reservations
curl -s -X GET %BASE_URL%/reservations -H "Authorization: Bearer %TOKEN%" >nul
if errorlevel 1 (
    echo ❌ GET /reservations échoué
) else (
    echo ✅ OK
)

:: TEST POST /reservations
echo.
echo POST /reservations
curl -s -X POST %BASE_URL%/reservations -H "Authorization: Bearer %TOKEN%" -H "Content-Type: application/json" -d "{\"utilisateur_id\": 1, \"activite_id\": 2}" >nul
if errorlevel 1 (
    echo ❌ POST /reservations échoué
) else (
    echo ✅ OK
)

:: TEST GET /reservations/user/1
echo.
echo GET /reservations/user/1
curl -s -X GET %BASE_URL%/reservations/user/1 -H "Authorization: Bearer %TOKEN%" >nul
if errorlevel 1 (
    echo ❌ GET /reservations/user/1 échoué
) else (
    echo ✅ OK
)

echo.
echo ✅ Tous les tests sont terminés.
pause
