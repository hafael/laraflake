<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Initial Epoch
    |--------------------------------------------------------------------------
    |
    | Initial Epoch is a number in timestamp format (unix timestamp * 1000)
    | used by LaraFlake package to determine the start time of their
    | application for the creation of IDs in 64bit format.
    |
    */
    'initial_epoch' => env('INITIAL_EPOCH', 1451625443000),

];