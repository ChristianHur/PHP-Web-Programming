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
     * Using SWITCH() statements -- much more challenging
     */
    switch($match1Pos){
        case 1: //matched 1, 1st position
            $matched++;
            switch($match2Pos) {
                case 2: //matched 2, 1st and 2nd numbers
                    $matched++;
                    switch ($match3Pos) {
                        case 3: //matched all 3 numbers in ORDER
                            $matched++;
                            $payout = MATCH3O_PRIZE;
                            break;
                        case 1: //matched 1st or 2nd position
                        case 2:
                            //matched all 3, unordered
                            $payout = MATCH3U_PRIZE;
                            break;
                        default: //matched only 2, 1st and 2nd positions
                            $payout = MATCH2_PRIZE;
                    }
                    break;
                case 1: //matched 2, 1st or 3rd position
                case 3:
                    $matched++;
                    switch ($match3Pos) {
                        case 1: //matched all 3 numbers, unordered
                        case 2:
                        case 3:
                            $matched++;
                            $payout = MATCH3U_PRIZE;
                            break;
                        default: //matched only 2, 1st and 2nd numbers
                            $payout = MATCH2_PRIZE;
                    }
                    break;
                default:
                    switch ($match3Pos) {
                        case 1: //matched 2, any position
                        case 2:
                        case 3:
                            $matched++;
                            $payout = MATCH2_PRIZE;
                            break;
                        default: //matched 1, 1st only
                            $payout = MATCH1_PRIZE;
                    }
            }
            break;
        case 2: //matched 1, 2nd position
            $matched++;
            switch ($match2Pos){
                case 1:
                case 2:
                case 3:
                    $matched++;
                    switch($match3Pos){
                        case 1:
                        case 2:
                        case 3:
                            $matched++;
                            $payout = MATCH3U_PRIZE;
                            break;
                        default:  //matched 2, 1st and 2nd
                            $payout = MATCH2_PRIZE;
                    }
                    break;
                default: //matched 1, try 3rd number
                    switch($match3Pos){
                        case 1:
                        case 2:
                        case 3:
                            //Matched 2, 1st & 3rd numbers
                            $matched++;
                            $payout = MATCH2_PRIZE;
                            break;
                        default: //matched 1, 1st number only
                            $payout = MATCH1_PRIZE;
                    }
            }
            break;
        case 3: //matched 1, 3rd position
            $matched++;
            switch($match2Pos){
                case 1:
                case 2:
                case 3:
                    //matched 2, how about 3rd number?
                    $matched++;
                    switch($match3Pos){
                        case 1:
                        case 2:
                        case 3:
                            //matched all three, unordered
                            $matched++;
                            $payout = MATCH3U_PRIZE;
                            break;
                        default:  //matched only 2, 1st and 2nd numbers
                            $payout = MATCH2_PRIZE;
                    }
                    break;
                default: //matched 1 only, 1st number
                    $payout = MATCH1_PRIZE;
            }
            break;
        default: //1st number no match, try 2nd number
            switch ($match2Pos){
                case 1:
                case 2:
                case 3:
                    //matched 1, 2nd number any position
                    $matched++;
                    switch($match3Pos){
                        case 1:
                        case 2:
                        case 3:
                            //matched 2, 2nd and 3rd number - any position
                            $matched++;
                            $payout = MATCH2_PRIZE;
                            break;
                        default:  //matched 1, 2nd number only
                            $payout = MATCH1_PRIZE;
                    }
                    break;
                default: //2nd number no match, try 3rd number
                    switch($match3Pos){
                        case 1:
                        case 2:
                        case 3:
                            //Matched 1, 3rd number any position
                            $matched++;
                            $payout = MATCH1_PRIZE;
                            break;
                        default: //matched none
                            $payout = MATCH0_PRIZE;
                    }
            }
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
