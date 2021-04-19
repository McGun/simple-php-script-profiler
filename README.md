# Simple PHP Script Profiler
Two very basic classes for measuring PHP script memory usage and execution time.

## Features
- Easy to use
- No Dependencies
- Measure memory peak
- Measure execution time

## Credit
This two classes is heavily inspired by: https://github.com/leo-lobster/php-timetrack
Many thanks for the idea.

## Documentation
### Instantiate the Timetracker

```php
require("Timetracker.php");

$Timetracker = new Timetracker;
```

### Add more checkpoints where you need then

```php
$Timetracker->add("Sync table in db");

// Some Code
$Timetracker->add("Loop throug posts");
```

### Show the Results
Print to terminal

> ```php
> $Timetracker->logTable();
> ```

---

### Instantiate the Memorytracker

```php
require("Memtracker.php");

$Memtracker = new Memtracker;
```

### Add more checkpoints where you need then

```php
$Memtracker->add("Sync table in db");

// Some Code
$Memtracker->add("Loop throug posts");
```

### Show the Results
Print to terminal

> ```php
> $Memtracker->logTable();
> ```
