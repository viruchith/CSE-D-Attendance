<?php
function getDateTime(){
    date_default_timezone_set('Asia/Kolkata');
    $date = date('d/m/Y h:i:s a', time());
    return $date;
}

