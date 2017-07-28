<?php

namespace Hafael\LaraFlake;

use Illuminate\Support\Facades\DB;

class LaraFlake
{

    /**
     * Generate the 64bit unique ID.
     * @return number BIGINT
     */
    public static function generateID()
    {

        /**
        * Current Timestamp - 41 bits
        */
        $curr_timestamp = floor(microtime(true) * 1000) - config('laraflake.initial_epoch');

        /**
        * Get ID of database server (10 bits)
        * Up to 512 machines
        */
        $shard_id = self::getServerShardId();

        /**
        * Generate a random number (12 bits)
        * Up to 2048 random numbers per db server
        */
        $random_part = mt_rand(1, pow(2,11)-1);

        /**
        * Concatenate the final ID
        */
        $final_id = ($curr_timestamp << 41) | ($shard_id << 10) | ($random_part << 12);
        /**
        * Return unique 64bit ID
        */
        return $final_id;
    }

    /**
     * Identify the database and get the ID.
     * Only MySQL.
     * @return int
     */
    private static function getServerShardId()
    {
        try {
            $database_name = DB::getName();
        }catch (\PDOException $e){
            return $e;
        }

        switch ($database_name) {
            case 'mysql':
                return (int) self::getMySqlServerId();
            default:
                return (int) 1;
        }
    }

    /**
     * Get server-id from mysql cluster or replication server.
     * @return mixed
     */
    private static function getMySqlServerId()
    {
        $result = DB::select('SELECT @@server_id as server_id LIMIT 1');
        return $result[0]->server_id;
    }

    /**
     * Return time from 64bit ID.
     * @param $id
     * @return number
     */
    public static function getTimeFromID($id)
    {
        return bindec(substr(decbin($id),0,41)) - pow(2,40) + 1 + config('laraflake.initial_epoch');
    }
}