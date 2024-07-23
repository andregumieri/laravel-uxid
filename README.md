# Laravel UXID

## Migrations
### UXID
Instead of using `$table->id()` use `$table->uxid()` (short for `$table->string('id')->primary`)

### Foreign
```
    ...
    $table->foreignUxidFor(ModelWithUxid::class)
    ...
```

## Models
```php
use AndreGumieri\LaravelUxid\Database\Eloquent\Concerns\HasUxid;

class User extends Model
{
    use HasUxid;
}
```