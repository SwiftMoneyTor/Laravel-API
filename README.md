How to deploy SwiftMoneyTorAPI in your local machine

<ol>
    <li>clone this repository</li>
    <li>composer install</li>
    <li>cp .env.example .env</li>
    <li>php artisan migrate</li>
    <li>php artisan serve</li>
    <li>php artisan vendor:publish
        --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"</li>
    <li>php artisan jwt:secret</li>
</ol>