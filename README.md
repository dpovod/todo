# TODO-list
 
## How to deploy a project

1. Create file **database.php** (with same structure as **database-example.php**). Specify the database connection settings in this file (
the database must be previously created).
2. Update project's dependencies using command 
```
composer update
```
3. Run migration using command
```
php migration.php
```
## How to run UNIT tests

**Linux**

```
vendor/bin/phpunit
```

**Windows**
```
vendor\bin\phpunit
```