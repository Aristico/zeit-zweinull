<?php

        /* In der Variable $pdo werden die einstellungen für die Datenbankverbindung hinterlegt.
        Über den befehl NEW PDO wird die verbindung hergestellt.
         *  der Charset ist wichtig, weil ein Spezieller Fall der Code-Injection verhindert wird.*/
    $pdo = new PDO('mysql:host=localhost:3307;dbname=time;charset=utf8',
     'tm_user',
      'unkCWsQ56omQi56H');

    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);