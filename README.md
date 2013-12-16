# Laravel 4 Multipe User Type Auth token
It's a fork of https://github.com/tappleby/laravel-auth-token
## Getting Started
### Setup
Add the package to your `composer.json`

    "require": {
		...
        "liamqma/auth-token": "dev-master"
    }
    
Add the service provider to `app/config/app.php`

	'Liamqma\AuthToken\AuthTokenServiceProvider',
	
Setup the optional aliases in `app/config/app.php`

	'AuthToken' => 'Liamqma\Support\Facades\AuthToken',
	
Currently the auth tokens are stored in the database, you will need to run the migrations:

    php artisan migrate --package=liamqma/auth-token

### Usage
Generate Token

    $user_id = 1;
    $user_type = 'Accessor';
    AuthToken::createToken($user_id,$user_type)
    
Validate Token

    $result = AuthToken::validateToken($token);
    if($result===TURE)
        ...

Get User Id after validation

    $user_id = AuthToken::getUserId()

