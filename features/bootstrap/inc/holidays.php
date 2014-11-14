<?php

/*
*    Function to calculate which days are British bank holidays (England & Wales) for a given year.
*/

function calculateBankHolidays($yr)
{

    $bankHols = Array();

    // New year's:
    switch (date("w", strtotime("$yr-01-01 12:00:00"))) {
        case 6:
            $bankHols[] = "$yr-01-03";
            break;
        case 0:
            $bankHols[] = "$yr-01-02";
            break;
        default:
            $bankHols[] = "$yr-01-01";
    }

    // Good friday:
    $bankHols[] = date("Y-m-d", strtotime("+" . (easter_days($yr) - 2) . " working days", strtotime("$yr-03-21 12:00:00")));

    // Easter Monday:
    $bankHols[] = date("Y-m-d", strtotime("+" . (easter_days($yr) + 1) . " working days", strtotime("$yr-03-21 12:00:00")));

    // May Day:
    if ($yr == 1995) {
        $bankHols[] = "1995-05-08"; // VE day 50th anniversary year exception
    } else {
        switch (date("w", strtotime("$yr-05-01 12:00:00"))) {
            case 0:
                $bankHols[] = "$yr-05-02";
                break;
            case 1:
                $bankHols[] = "$yr-05-01";
                break;
            case 2:
                $bankHols[] = "$yr-05-07";
                break;
            case 3:
                $bankHols[] = "$yr-05-06";
                break;
            case 4:
                $bankHols[] = "$yr-05-05";
                break;
            case 5:
                $bankHols[] = "$yr-05-04";
                break;
            case 6:
                $bankHols[] = "$yr-05-03";
                break;
        }
    }

    // Summer Bank Holiday:
    switch (date("w", strtotime("$yr-08-31 12:00:00"))) {
        case 0:
            $bankHols[] = "$yr-08-25";
            break;
        case 1:
            $bankHols[] = "$yr-08-31";
            break;
        case 2:
            $bankHols[] = "$yr-08-30";
            break;
        case 3:
            $bankHols[] = "$yr-08-29";
            break;
        case 4:
            $bankHols[] = "$yr-08-28";
            break;
        case 5:
            $bankHols[] = "$yr-08-27";
            break;
        case 6:
            $bankHols[] = "$yr-08-26";
            break;
    }

    // Christmas:
    switch (date("w", strtotime("$yr-12-25 12:00:00"))) {
        case 5:
            $bankHols[] = "$yr-12-25";
            $bankHols[] = "$yr-12-28";
            break;
        case 6:
            $bankHols[] = "$yr-12-27";
            $bankHols[] = "$yr-12-28";
            break;
        case 0:
            $bankHols[] = "$yr-12-26";
            $bankHols[] = "$yr-12-27";
            break;
        default:
            $bankHols[] = "$yr-12-25";
            $bankHols[] = "$yr-12-26";
    }
    return $bankHols;
}