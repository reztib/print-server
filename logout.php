<?php
/**
 * @file logout.php
 * @brief Beendet die Benutzersitzung und leitet zur Login-Seite weiter.
 *
 * Dieses Skript beendet die aktuelle Benutzersitzung und leitet den Benutzer 
 * zurück zur Login-Seite.
 *
 * @details 
 * - Zerstört die aktuelle Benutzersitzung.
 * - Leitet den Benutzer zur Login-Seite weiter.
 */

session_start();
session_unset();
session_destroy();
header('Location: index.php'); // Zurück zur Login-Seite
exit;
