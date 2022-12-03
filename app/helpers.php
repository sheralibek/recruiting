<?php
function status($statusCode): ?string
{
    $array = [
        0 => 'Wait',
        1 => 'Accept',
        3 => 'Cancelled'
    ];

    return $array[$statusCode] ?? null;
}
