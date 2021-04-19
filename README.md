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
$Timetracker->add("Loop through posts");
```

### Show the Results
Print to terminal

```php
$Timetracker->logTable();
```
Example output
```
Timing table:
|----------------------------------------------------------------------|
|  Num | Perc %|         Time | Description                            |
|----------------------------------------------------------------------|
|    1 |     0%| 00:00:00.002 | Init -> Sync table in db               |
|    2 |    80%| 00:00:02.496 | Sync table in db -> Loop through posts |
|    3 |    10%| 00:00:00.617 | Loop through posts -> Finnish          |
|      |   100%| 00:00:03.088 | Total time                             |
|______________________________________________________________________|
```

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
$Memtracker->add("Loop through posts");
```

### Show the Results
Print to terminal

```php
$Memtracker->logTable();
```

Example output:
```
Memory table:
Peaking at: 5 MB
|----------------------------------------------------------------------|
|  Num | Perc %|     Memory | Description                              |
|----------------------------------------------------------------------|
|    1 |    12%|       1 MB | Init -> Sync table in db                 |
|    2 |    62%|       5 MB | Sync table in db -> Loop through posts   |
|    3 |    25%|       2 MB | Loop through posts -> Finnish            |
|______________________________________________________________________|
```
