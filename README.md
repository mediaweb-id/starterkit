# Starter kit for Laravel Inertia Vue js 3


## Requirement 
```bash
    "laravel/framework": "^12.0"
    "php": "^8.2",
    "predis/predis": "^3.0",
```

## Installation

You can install the package via composer:


```bash
laravel new demoproject
```
or 
```bash
git clone https://github.com/laravel/vue-starter-kit.git demoproject
cd demoproject

```
and Run 

```bash
composer require acitjazz/starterkit
```

```bash
   npm install @fortawesome/fontawesome-free
   npm install @he-tree/vue
   npm install @vueup/vue-quill
   npm install quill-image-uploader
   npm install vue3-dropzone
   npm install toastify-js
   npm install swiper
   npm install -D sass-embedded
   npm install @inertiajs/server
```

Publish Assets,Seeders,Models,Controllers,Repositories,Requests,Resources

```bash
php artisan vendor:publish --tag=starterkit-assets --force
php artisan vendor:publish --tag=starterkit-seeders
php artisan vendor:publish --tag=starterkit-models
php artisan vendor:publish --tag=starterkit-controllers
php artisan vendor:publish --tag=starterkit-repositories
php artisan vendor:publish --tag=starterkit-requests
php artisan vendor:publish --tag=starterkit-helpers
php artisan vendor:publish --tag=starterkit-resources
php artisan vendor:publish --tag=starterkit-queryfilters
php artisan vendor:publish --tag=starterkit-traits
php artisan vendor:publish --tag=starterkit-rules
php artisan vendor:publish --tag=routes
php artisan starterkit:adjusted-namespace
```

Rename .env.example and config your database

Now, you can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="starterkit-migrations"
php artisan migrate
```

And now  un seeder data

```bash
php artisan db:seed 
```
## Usage
- /backend/login
- email: super@mypage.id
- password : Super1q2w3e++2025
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Acit Jazz](https://github.com/Acit-Jazz)
- [Acit Jazz](https://github.com/AcitJazz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
