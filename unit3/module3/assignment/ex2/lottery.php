<?php include("inc_header.php"); ?>
<main>
<form action="lottery.php" method="get">
    <h3>Pick three numbers:</h3>
    <input type="number" id="guess1" name="guess1">
    <input type="number" id="guess2" name="guess2">
    <input type="number" id="guess3" name="guess3">
    <input type="submit" name="submit" value="Submit">
</form>

    <?php
   include("inc_result.php");
   ?>

</main>

<?php
   include("inc_footer.php");
?>
