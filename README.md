# Web24 - recruitment task

## Main tools

- PHP 8.4
- Laravel 12
- Composer
- [Docker / Laravel Sail](https://laravel.com/docs/12.x/sail)
- Laravel Pint
- PHPUnit / Laravel Pest

## Requirements

1. PHP
2. Composer
3. Docker

## Endpoints

### Companies

``` sh
GET /api/companies
```

``` sh
GET /api/companies/{company}
```

``` sh
POST /api/companies

curl --location 'http://localhost/api/companies' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data '{
    "name": "Microsoft",
    "nip": "1234567890",
    "address": "Redmond",
    "city": "Washington",
    "postcode": "12-123"
}'
```


``` sh
PATCH /api/companies/{company}

curl --location --request PATCH 'http://localhost/api/companies/{company}' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data '{
    "name": "Microsoft",
    "nip": "1234567890",
    "address": "Redmond",
    "city": "Washington",
    "postcode": "12-123"
}'
```

``` sh
DELETE /api/companies/{company}
```

### Employees

``` sh
GET /api/companies/{company}/employees
```

``` sh
GET /api/companies/{company}/employees/{employee}
```

``` sh
POST /api/companies/{company}/employees

curl --location 'http://localhost/api/companies/{company}/employees' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data '{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@gmail.com",
    "phone": "123456789"
}'
```

``` sh
PATCH /api/companies/{company}/employees/{employee}

curl --location --request PATCH 'http://localhost/api/companies/{company}/employees/{employee}' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data '{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@gmail.com",
    "phone": "123456789"
}'
```

``` sh
DELETE /api/companies/{company}/employees/{employee}
```
