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

    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    |
    | The provider informs which driver will be used to obtain the database
    | node identification.
    | Available: "local" and "database".
    |
    */
    'provider' => env('LARAFLAKE_PROVIDER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Shard ID
    |--------------------------------------------------------------------------
    |
    | The shard id is the identifier of the node used when the provider is
    | local.
    |
    */
    'shard_id' => env('LARAFLAKE_SHARD_ID', 1),

];