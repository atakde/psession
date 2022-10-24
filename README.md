# psession

PHP library for handling sessions

## Installation

Install via composer

```bash 
composer require atakde/psession
```

## Usage (Text Message)

```php

<?php

require_once __DIR__ . '/vendor/autoload.php';

use Atakde\PSession\PSession;

// http only true
$session = new PSession([
    'cookie_httponly' => true,
]);

$session->start();
$session->set('name', 'John');
echo $session->get('name');

$session->destroy();

```
