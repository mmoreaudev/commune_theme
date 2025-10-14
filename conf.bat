@echo off
SETLOCAL ENABLEDELAYEDEXPANSION

REM -----------------------------
REM Variables à personnaliser
REM -----------------------------
SET WG_PATH="C:\Program Files\WireGuard\wg.exe"
SET SERVER_PRIV="iL78VBbUjDLGI1MCGWutj78QhOzaFzYYxtrFngVslU="
SET SERVER_CONF="%ProgramData%\WireGuard\wg0.conf"
SET SERVER_IP=10.10.0.1/24
SET SERVER_PORT=51820
SET PEER_PUB="<CLE_PUBLIQUE_DU_CLIENT>"
SET PEER_IP=10.10.0.2/32

REM -----------------------------
REM Vérifier si wg.exe existe
REM -----------------------------
IF NOT EXIST %WG_PATH% (
    echo WireGuard non trouvé. Installe WireGuard depuis https://www.wireguard.com/install/
    pause
    exit /b
)

REM -----------------------------
REM Créer fichier temporaire avec clé privée
REM -----------------------------
SET TEMPFILE=%TEMP%\privkey.txt
echo %SERVER_PRIV% > %TEMPFILE%

REM -----------------------------
REM Générer clé publique du serveur
REM -----------------------------
FOR /F "delims=" %%G IN ('%WG_PATH% pubkey < %TEMPFILE%') DO SET SERVER_PUB=%%G
echo Clé publique du serveur : !SERVER_PUB!

REM -----------------------------
REM Créer fichier de configuration serveur
REM -----------------------------
(
echo [Interface]
echo PrivateKey = %SERVER_PRIV%
echo Address = %SERVER_IP%
echo ListenPort = %SERVER_PORT%
echo.
echo [Peer]
echo PublicKey = %PEER_PUB%
echo AllowedIPs = %PEER_IP%
echo PersistentKeepalive = 25
) > %SERVER_CONF%

echo Fichier serveur créé : %SERVER_CONF%

REM -----------------------------
REM Supprimer fichier temporaire
REM -----------------------------
del %TEMPFILE%

echo ✅ Configuration WireGuard prête.
pause
