<?php 
ini_set('max_execution_time', 3000000);
ini_set('memory_limit','2000000M');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("loto.php");
require_once('combinaisons.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>loto application pout gagner le million</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <h1>Loto winner script</h1>
  <hr>
  <pre>
    <code>
      <?php

      $loto = new Loto();
      $calculateEvenOddPercentages = Loto::calculateEvenOddPercentages($combinations);
      $mostCommonCategories = Loto::findMostCommonCategories(Loto::categorizeNumbers($combinations));

      echo "\ncalculateEvenOddPercentages Combinations:\n";
      print_r($calculateEvenOddPercentages);
      echo "<hr>";

      echo "\nMost Common Categories by Position:\n";
      print_r($mostCommonCategories);
      echo "<hr>";
      ?>
    </code>
  </pre>
</body>
</html>