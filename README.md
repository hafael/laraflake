# LaraFlake
------

LaraFlake is a Laravel 5.x Package based on Twitter Snowflake ID Generator (64 bit ID).

  - Generate unique identifiers like **4685142323047173636** (64bit)
  - 41bit for time
  - 10bits for shard database identifier from 1 to 512
  - 12bits for randomic number from 1 to 2048

Only supports MySQL database. :(  
Waiting for your pull request to solve this issue...

### How to use
Run the composer require command from your terminal:
```sh
$ composer require hafael/laraflake
```
Open rootproject/config/app.php and register the required service provider **above** your application providers.

```php
'providers' => [
    /*
     * Application Service Providers...
     */
    ...
    Hafael\LaraFlake\LaraFlakeServiceProvider::class,
],
```

Run Artisan command to publish vendor config file in rootproject/config/laraflake.php
```sh
$ php artisan vendor:publish --provider="Hafael\LaraFlake\LaraFlakeServiceProvider"
```

Import the ***LaraFlakeTrait*** in your model and set **$incrementing** to false:
```php
class User extends Authenticatable
{
    use LaraFlakeTrait;
    protected $table = "users";
    
    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;
    ...
```
And update the migration files to use ***BIGINT(20) UNSIGNED***:

```php
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            
            $table->bigInteger('id')->unsigned()->primary();
            
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    ...
```


### Development

Want to contribute? Great!
Just create a pull request.

### Todos

 - Write Tests
 - Write Benchmark Tests
 - Implement support for other databases

License
----
Apache 2.0
