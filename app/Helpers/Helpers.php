<?php

function string_to_currency($money)
{
    $formatted = '₱' . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $money)), 2);
    return $money < 0 ? "({$formatted})" : "{$formatted}";
}

function deactivated($request_type)
{
        switch ($request_type) {
            case 'api':
                return response(['message' => 'You account has beend deactivated!'], 406);
                break;
            case 'html':
                return back()->withErrors(['You account has beend deactivated!']);
                break;
        }
}