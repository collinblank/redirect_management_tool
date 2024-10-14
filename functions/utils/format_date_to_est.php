<?php

function format_date_to_est($date)
{
    $dt = new DateTime($date);
    $dt->setTimezone(new DateTimeZone("America/New_York"));

    return date_format($dt, 'M j, Y g:i a');
}
