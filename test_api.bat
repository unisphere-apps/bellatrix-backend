@echo off
setlocal enabledelayedexpansion

:: CONFIG
set BASE_URL=http://localhost/bellatrix-backend/public
set EMAIL=h@gmail.com
set PASSWORD=123

echo 🔐 Test de connexion à l'API...

:: LOGIN
curl -s -X POST %BASE_URL%/login -H "Content-Type: application/json" -d "{\"email\":\"%EMAIL%\", \"password\":\"%PASSWORD%\"}" > login_response.txt

:: Extraction du token via PowerShell pour éviter perte de caractère
for /f "delims=" %%A in ('powershell -Command ^
    "$response = Get-Content login_response.txt | ConvertFrom-Json; $response.token"') do (
    set "TOKEN=%%A"
)

if not defined TOKEN (
    echo ❌ Login échoué
    type login_response.txt
    del login_response.txt
    exit /b 1
)

echo ✅ Login OK - Token: [%TOKEN%]
del login_response.txt

:: TEST GET /activites
echo.
echo 🔎 GET /activites
curl -s -X GET %BASE_URL%/activites -H "Authorization: Bearer %TOKEN%"
if errorlevel 1 (
    echo ❌ GET /activites échoué
) else (
    echo ✅ OK
)

:: TEST GET /activites/1
echo.
echo 🔎 GET /activites/1
curl -s -X GET %BASE_URL%/activites/1 -H "Authorization: Bearer %TOKEN%"
if errorlevel 1 (
    echo ❌ GET /activites/1 échoué
) else (
    echo ✅ OK
)

:: TEST GET /reservations
echo.
echo 🔎 GET /reservations
curl -s -X GET %BASE_URL%/reservations -H "Authorization: Bearer %TOKEN%"
if errorlevel 1 (
    echo ❌ GET /reservations échoué
) else (
    echo ✅ OK
)

:: TEST POST /reservations
echo.
echo 📝 POST /reservations
curl -s -X POST %BASE_URL%/reservations -H "Authorization: Bearer %TOKEN%" -H "Content-Type: application/json" -d "{\"utilisateur_id\": 1, \"activite_id\": 2}"
if errorlevel 1 (
    echo ❌ POST /reservations échoué
) else (
    echo ✅ OK
)

:: TEST GET /reservations/user/1
echo.
echo 🔎 GET /reservations/user/1
curl -s -X GET %BASE_URL%/reservations/user/1 -H "Authorization: Bearer %TOKEN%"
if errorlevel 1 (
    echo ❌ GET /reservations/user/1 échoué
) else (
    echo ✅ OK
)

echo.
echo ✅ Tous les tests sont terminés.
pause
