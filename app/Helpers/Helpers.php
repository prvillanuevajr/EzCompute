<?php

function string_to_currency($money)
{
    $formatted = '₱' . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $money)), 2);
    return $money < 0 ? "({$formatted})" : "{$formatted}";
}