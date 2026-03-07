<?php

//------------------------------------------------------------------------------
//!
//! Function:      replaceMonthWithString
//!
//! Description:   replaceMonthWithString
//!
//! Parameter:     $arg_month_num: expected num 1 to 12
//!
//! Return:        returns german month string by given weeknum
//------------------------------------------------------------------------------
function replaceMonthWithString($arg_month_num){
    $WEEKDAYS = array("Jan","Feb","Mär","Apr","Mai","Jun","Jul","Aug","Sep","Okt","Nov","Dez");
    if (filter_var($arg_month_num, FILTER_VALIDATE_INT) === false) {
        return "";
    }
    if($arg_month_num < 1 ||$arg_month_num > 12){
        return "";
    }
    return $WEEKDAYS[$arg_month_num-1];
}

//------------------------------------------------------------------------------
//!
//! Function:      replaceWeekdayWithString
//!
//! Description:   replaceWeekdayWithString
//!
//! Parameter:     $arg_weekday_num: expected num 0 to 6
//!
//! Return:        returns german weekday string by given weeknum
//------------------------------------------------------------------------------
function replaceWeekdayWithString($arg_weekday_num){
    $WEEKDAYS = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
    if (filter_var($arg_weekday_num, FILTER_VALIDATE_INT) === false) {
        return "";
    }
    if($arg_weekday_num < 0 ||$arg_weekday_num > 6){
        return "";
    }
    return $WEEKDAYS[$arg_weekday_num];
}

//------------------------------------------------------------------------------
//!
//! Function:      repeatStringToGerman
//!
//! Description:   repeatStringToGerman
//!
//! Parameter:     $arg_weekday_num: expected num 0 to 6
//!
//! Return:        returns germand weekday string by givne weeknum
//------------------------------------------------------------------------------
function repeatStringToGerman($repeat_str) {
    if ($repeat_str == "DAILY") {
      return "täglich";
    }
    if ($repeat_str == "WEEKLY") {
      return "wöchentlich";
    }
    if ($repeat_str == "MONTHLY") {
      return "monatlich";
    }
    if ($repeat_str == "YEARLY") {
      return "jährlich";
    }

    return "";
}

//------------------------------------------------------------------------------
//!
//! Function:      isDateValid
//!
//! Description:   check if date has format yyyy-mm-dd
//!
//! Parameter:     $date)
//!
//! Return:
//------------------------------------------------------------------------------
function isDateValid($date) {
    // Regular expression to match the format YYYY-MM-DD
    $pattern = '/^\d{4}-\d{2}-\d{2}$/';

    // Check if the date matches the pattern
    if (preg_match($pattern, $date)) {
        // Further validation to check if it's a real date
        $parts = explode('-', $date);
        $year = (int)$parts[0];
        $month = (int)$parts[1];
        $day = (int)$parts[2];
        return checkdate($month, $day, $year);
    }
    return false;
}

//------------------------------------------------------------------------------
//!
//! Function:      strtotime_checkEmpty
//!
//! Description:   check if string is empty
//!
//! Parameter:     $date
//!
//! Return:
//------------------------------------------------------------------------------
function strtotime_checkEmpty($date){
    if (empty($date)) {
        return false;
    }
    return strtotime($date);
}
