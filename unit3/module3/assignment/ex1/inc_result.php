<?php

if(isset($_GET['submit'])){

    define("MAX_HOURS",40);
    define("OT_RATE",1.5);
    $hourly_rate = number_format($_GET['hourly_rate'],2);
    $hours_worked = number_format($_GET['hours_worked'],2);
    $overtime_pay = 0;
    $regular_pay = number_format(MAX_HOURS * $hourly_rate,2);

    if($hours_worked > MAX_HOURS){
        $overtime_pay = number_format(($hours_worked - MAX_HOURS) * OT_RATE * $hourly_rate,2);
    }else{
        $regular_pay = number_format($hours_worked * $hourly_rate,2);
    }

    $total_pay = number_format($regular_pay + $overtime_pay,2);

    ?>

    <p>Hourly Rate: $<?= $hourly_rate ?></p>
    <p>Hours Worked: <?= $hours_worked ?></p>
    <p>Overtime Pay: $<?= $overtime_pay ?></p>
    <p>Total Pay: $<?= $total_pay ?></p>

<?php

}