# coord2coord
Convert spreadsheet columns coordinates to numeric coordinates and reverse too

## Why?
Sometimes, when you develop some code about some CSV or something like that, you have reference given by some people using spreadsheet value (column A, AA, Z…) or index value (1, 2, 3) or even index value starting to zero (0, 1, 2…).

So, this little library deals with that. So, you can easily switch from one system to another.

## How?
You can play with it using two ways:
 - By using library to use it into your code
 - By using CLI script available.

## Using the library
Very simple, install it using *composer*. You can find it on <https://packagist.org/packages/malenki/coord2coord>.

Quick example converting spreadsheet column name to index starting from one:

```php
use \Malenki\Coord2Coord;

$c2c = new Coord2Coord();
echo $c2c->l2d('A'); // 1
echo $c2c->l2d('Z'); // 26
echo $c2c->l2d('AA'); // 27
```

Now the same with index starting from zero (note the constructor's call):

```php
use \Malenki\Coord2Coord;

$c2c = new Coord2Coord(true);
echo $c2c->l2d('A'); // 0
echo $c2c->l2d('Z'); // 25
echo $c2c->l2d('AA'); // 26
```

Example to show how to convert index to spreadsheet column name:

```php
use \Malenki\Coord2Coord;

$c2c = new Coord2Coord();
echo $c2c->d2l(1); // 'A'
echo $c2c->d2l(26); // 'Z'
echo $c2c->d2l(27); // 'AA'
```

Again, we can also use starting point as zero:

```php
use \Malenki\Coord2Coord;

$c2c = new Coord2Coord(true);
echo $c2c->d2l(0); // 'A'
echo $c2c->d2l(25); // 'Z'
echo $c2c->d2l(26); // 'AA'
```

That's all to know!

But you must also know that if you use incorrect value for index (negative integer, non integer, or zero when starting point is one) then this raises an exception (`InvalidArgumentException` is it is not an integer or `OutOfRangeException` for other cases).

Also, if you use any other value than ASCII characters `a-zA-Z` for convert spreadsheet column name to index then an `InvalidArgumentException` occurs.

## Using CLI script
Again, install it using composer, then, `composer install` into root directory of sources.

A script is available into `bin\coord2coord`.

Other way is to use PHAR file, so, just [download it](http://malenkiki.github.io/coord2coord/coord2coord.phar) or create it using [box](https://github.com/box-project/box2) by doing `box build` into the root of sources.

Play with it is very simple:

```
bin\coord2coord --help #display help message
bin\coord2coord A Z AA 56 2
"A" => 1
"Z" => 26
"AA" => 27
"56" => BD
"2" => B
 bin/coord2coord --zero A Z AA 56 2
"A" => 0
"Z" => 25
"AA" => 26
"56" => BE
"2" => C
```

Simple, isn't it?
