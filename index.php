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
  <title>loto App</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

  <h1>Loto winner algo</h1>
  <hr>
  <pre>
    <code>
      <?php
      $loto = new Loto();

      $findMostPopularNumbers = Loto::findMostPopularNumbers($combinations);
      $calculateEvenOddPercentages = Loto::calculateEvenOddPercentages($combinations);
      $categorizedCombinations = Loto::categorizeNumbers($combinations);
      $mostCommonCategories = Loto::findMostCommonCategories($categorizedCombinations);
      $findMostPopularPattern = Loto::findMostPopularPattern($categorizedCombinations);

      echo "findMostPopularNumbers Combinations:\n";
      print_r($findMostPopularNumbers);
      echo " <hr>";

      echo "calculateEvenOddPercentages Combinations:\n";
      print_r($calculateEvenOddPercentages);
      echo " <hr>";

      echo "\nMost Common Categories by Position:\n";
      print_r($mostCommonCategories);
      echo " <hr>";

      echo "\nMost Common Categories by Position:\n";
      print_r($findMostPopularPattern);
      echo " <hr>";
      ?>
    </code>
  </pre>
</body>
</html>