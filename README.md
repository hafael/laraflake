# LaraFlake

LaraFlake is a Laravel Package based on Twitter Snowflake ID Generator (64 bit ID).

  - Generate unique identifiers like 4685142323047173636 (64bit)
  - 41bit for time
  - 10bits for shard database identifier from 1 to 512
  - 12bits for randomic number from 1 to 2048

### How to use
Just type:
```sh
$ composer require hafael/laraflake
```

Import the **LaraFlakeTrait** in your model and set **$incrementing** to false:
```
class User extends Authenticatable
{
    use LaraFlakeTrait;

    protected $table = "users";

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    ...
```
And update the migration file to use bigInteger:

```
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigInteger('id')->unsigned()->unique()->primary();
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
