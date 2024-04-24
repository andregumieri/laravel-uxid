# Laravel UXID

## Migrations
Instead of using `$table->id()` use `$table->string('id')->primary()`

## Models
```php
use AndreGumieri\LaravelUxid\Database\Eloquent\Concerns\HasUxid;

class User extends Model
{
    use HasUxid;
}
```