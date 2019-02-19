<?php

function string_to_currency($money)
{
    $formatted = '₱' . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $money)), 2);
    return $money < 0 ? "({$formatted})" : "{$formatted}";
}

function checkIfActive($type)
{
    switch ($type) {
        case 'api':
            break;
    }

    if (auth()->user()->deactivated_at) {
        switch ($type) {
            case 'api':
                return response(['message' => 'You account has beend deactivated!'], 406);
                break;
            case 'redirect':
                return back()->withErrors(['You account has beend deactivated!']);
                break;
        }
    }
}