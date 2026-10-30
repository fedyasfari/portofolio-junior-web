@echo off
setlocal
cd /d "%~dp0.."
echo === CEK SINTAKS LAB 5 ===
if exist "C:\xampp\php\php.exe" (
 set "PHPBIN=C:\xampp\php\php.exe"
) else (
 set "PHPBIN=php"
)
"%PHPBIN%" -l "public\cetak.php"
"%PHPBIN%" -l "templates\bukti.php"
"%PHPBIN%" -l "src\pendaftar.php"
"%PHPBIN%" "tools\cek_lab5.php"
echo.
echo Tekan sembarang tombol untuk menutup.
pause >nul
