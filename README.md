# psession

PHP library for handling sessions

## Installation

Install via composer

```bash 
composer require atakde/psession
```

## Usage

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

## Features

* Allowed dot notation both get & set

```php
Session::get('user.name');
Session::set('user.name', 'Testing');
```

