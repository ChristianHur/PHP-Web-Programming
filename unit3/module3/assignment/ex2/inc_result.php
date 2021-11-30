<?php
//Prizes - constants
define("MATCH0_PRIZE",0);
define("MATCH1_PRIZE",10);
define("MATCH2_PRIZE",100);
define("MATCH3U_PRIZE",1000);
define("MATCH3O_PRIZE",1000000);

//Three random numbers
$rand1 = 5;
$rand2 = 2;
$rand3 = 6;
//$rand1 = rand(0,9);
//$rand2 = rand(0,9);
//$rand3 = rand(0,9);

//Flags
$rand1Matched = false;
$rand2Matched = false;
$rand3Matched = false;

/**
 * Return the matching position, not already matched by another number
 * @param $guess
 * @return int
 */
function matchPosition($guess)
{
    //Access global variables
    global $rand1, $rand2, $rand3, $rand1Matched, $rand2Matched, $rand3Matched;
    //If the first position has not already matched
    //and matches first position
    if(!$rand1Matched && $guess == $rand1){
        $rand1Matched = true;
        return 1;
    }
    //If the second position has not already matched
    //and matches second position
    if(!$rand2Matched && $guess == $rand2){
        $rand2Matched = true;
        return 2;
    }
    //If the third position has not already matched
    //and matches third position
    if(!$rand3Matched && $guess == $rand3){
        $rand3Matched = true;
        return 3;
    }

    return 0;  //no matches
}

//Process form data
if(isset($_GET['submit'])){

    //The user guesses
    $guess1 = $_GET['guess1'];
    $guess2 = $_GET['guess2'];
    $guess3 = $_GET['guess3'];

    //Obtain matching position for each guess
    $match1Pos = matchPosition($guess1);
    $match2Pos = matchPosition($guess2);
    $match3Pos = matchPosition($guess3);

    $payout = 0;
    $matched = 0;

    /**
     * Using IF-ELSE statements
     */

    if($match1Pos == 1 && $match2Pos == 2 && $match3Pos==3){
        //Match all 3 in order
        $payout = MATCH3O_PRIZE;
        $matched = 3;
    }else if($match1Pos > 0 && $match2Pos > 0 && $match3Pos > 0) {
        //Match all 3 numbers, not in order
        $payout = MATCH3U_PRIZE;
        $matched = 3;
    }else if(
            ($match1Pos > 0 && $match2Pos > 0) ||
            ($match1Pos > 0 && $match3Pos > 0) ||
            ($match2Pos > 0 && $match3Pos > 0) ){
        //Match 2 numbers
        $payout = MATCH2_PRIZE;
        $matched = 2;
    }else if($match1Pos > 0 || $match2Pos > 0 || $match3Pos > 0 ) {
        //Match 1 number
        $payout = MATCH1_PRIZE;
        $matched = 1;
    }else{
        //No matches
        $payout = MATCH0_PRIZE;
        $matched = 0;
    }

    //Message to display
    $message = $matched > 0 ? "Congrats!" : "Sorry.";
    $message .= " You matched " . $matched . " ";
    $message .= $matched == 1 ? "number" : "numbers";


    ?>
    <h3>Result</h3>

    <p>Lottery Numbers: <?= $rand1 . " " . $rand2 . " " . $rand3 ?></p>
    <p>Your Numbers: <?= $guess1 . " " . $guess2 . " " . $guess3 ?></p>
    <p><?= $message ?> </p>
    <h4>Your Prize: $<?= number_format($payout,0) ?></h4>


<?php } ?>

<div id="prizes">
    <h3>Prizes:</h3>
    <p>Any one matching: $<?= number_format(MATCH1_PRIZE,0)?><br>
        Two matching: $<?= number_format(MATCH2_PRIZE,0) ?><br>
        Three matching, any order: $<?= number_format(MATCH3U_PRIZE,0) ?><br>
        Three matching, exact order: $<?= number_format(MATCH3O_PRIZE,0)?><br>
        No Matches: $<?= number_format(MATCH0_PRIZE,0)?></p>
</div>
