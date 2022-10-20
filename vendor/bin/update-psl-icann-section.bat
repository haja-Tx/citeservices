@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../league/uri-hostname-parser/bin/update-psl-icann-section
php "%BIN_TARGET%" %*
