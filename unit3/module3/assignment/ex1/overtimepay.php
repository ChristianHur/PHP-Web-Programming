<?php

/**
 * Create a simple application to calculate the weekly pay for anemployee.
 * An employee whose total hours exceed the normal 40 hours gets an over-timepay.
 * The over-time rate is 1.5 times the hourly rate.
 */

include("inc_header.php");
?>

<main>
<form action="overtimepay.php" method="get">
    <label>Hourly Rate: <input id="hourly_rate" name="hourly_rate"></label>
    <label>Hours Worked: <input id="hours_worked" name="hours_worked"></label>
    <input type="submit" name="submit" value="Calculate">
</form>

    <?php
   include("inc_result.php");
   ?>

</main>

<?php
   include("inc_footer.php");
?>
