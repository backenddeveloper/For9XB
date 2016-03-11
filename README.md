# For9XB
A 20-minute solution to the 9XB technical test

Unfortunately building an MVC application in Zend or Symphony would have taken longer than the time available.

To install run:
```bash
  mysql -u root -p < install.sql
```

Optionally followed by:
```bash
  mysql -u root -p < seed.sql
```

Then deploy index.php to the correct web folder.

The bit of code to prevent CSRF:
```php
  if($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] !== $_SERVER['HTTP_REFERER'])
```

Was removed from line 12 to aid readability and to support Microsoft products.
