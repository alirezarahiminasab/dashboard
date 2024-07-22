<?php
// Function to convert Persian date to Gregorian date
function jalali_to_gregorian($jy, $jm, $jd) {
    $jy += 1595;
    $days = -355668 + (365 * $jy) + (int)($jy / 33) * 8 + (int)((($jy % 33) + 3) / 4) + $jd;

    if ($jm < 7) {
        $days += ($jm - 1) * 31;
    } else {
        $days += ($jm - 7) * 30 + 186;
    }

    $gy = 400 * (int)($days / 146097);
    $days %= 146097;

    if ($days > 36524) {
        $gy += 100 * (int)(--$days / 36524);
        $days %= 36524;

        if ($days >= 365) {
            $days++;
        }
    }

    $gy += 4 * (int)($days / 1461);
    $days %= 1461;

    if ($days > 365) {
        $gy += (int)(($days - 1) / 365);
        $days = ($days - 1) % 365;
    }

    $gd = $days + 1;

    foreach (array(0, 31, (int)(($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
        if ($gd <= $v) {
            break;
        }
        $gd -= $v;
    }

    return array($gy, $gm, $gd);
}


function(date)
// Your given Persian date and time
$event_create_start_date = "1403/04/04";
$event_create_start_time = "10:38";

// Split the Persian date
list($jy, $jm, $jd) = explode('/', $event_create_start_date);

// Convert to Gregorian date
list($gy, $gm, $gd) = jalali_to_gregorian($jy, $jm, $jd);

// Combine the Gregorian date and time
$gregorian_datetime = sprintf('%04d-%02d-%02d %s', $gy, $gm, $gd, $event_create_start_time);

// Create a DateTime object and get the Unix timestamp
$datetime = new DateTime($gregorian_datetime);
$timestamp = $datetime->getTimestamp();

// Print the resulting Unix timestamp
echo $timestamp;
?>
