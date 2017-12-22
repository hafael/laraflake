<?php

namespace Hafael\LaraFlake;

use Illuminate\Support\Facades\DB;

class LaraFlake
{

    const INITIAL_EPOCH = 1451625443000;

    const DEFAULT_SHARD_ID = 1;

    /**
     * Generate the 64bit unique ID.
     * @return number BIGINT
     */
    public static function generateID()
    {

        /**
		* Current Timestamp - 41 bits
		*/
        $curr_timestamp = floor(microtime(true) * 1000);

        if ( ! is_int(config('laraflake.initial_epoch', self::INITIAL_EPOCH)) ) {
            throw new \InvalidArgumentException('Initial epoch is invalid. Must be an integer');
        }

        /**
        * Subtract custom epoch from current time
        */
        $curr_timestamp -= config('laraflake.initial_epoch', self::INITIAL_EPOCH);

        /**
        * Create a initial base for ID
        */
        $base = decbin(pow(2,40) - 1 + $curr_timestamp);

        /**
        * Get ID of database server (10 bits)
        * Up to 512 machines
        */

        $node = self::getServerShardId();

        if ( ! is_int($node) || $node < 0 || $node > 1023 ) {
            throw new \InvalidArgumentException('The Shard ID identifier must be a 10 bit integer between 0 and 1023.');
        }

        $shard_id = decbin(pow(2,9) - 1 + self::getServerShardId());

        /**
        * Generate a random number (12 bits)
        * Up to 2048 random numbers per db server
        */
        $random_part = mt_rand(1, pow(2,11)-1);
        $random_part = decbin(pow(2,11)-1 + $random_part);

        /**
        * Concatenate the final ID
        */
        $final_id = bindec($base) . bindec($shard_id) . bindec($random_part);

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

        if(config('laraflake.provider', 'local') !== 'database'){
            return config('laraflake.shard_id', self::DEFAULT_SHARD_ID);
        }

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
        return bindec(substr(decbin($id),0,41)) - pow(2,40) + 1 + config('laraflake.initial_epoch', self::INITIAL_EPOCH);
    }
}