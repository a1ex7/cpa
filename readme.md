# Laravel CPA Network Integration
inspired by wearesho-team/bobra-cpa

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]

![laravel cpa](logo_transparent.png)

Laravel Package for [CPA](https://en.wikipedia.org/wiki/Cost_per_action) networks integration and target customer actions registration in your application.
Currently supported: [Admitad](https://www.admitad.com/ru/), [Credy](https://www.credy.com/), [DoAffiliate](https://www.doaffiliate.net/), [Finline](https://finline.ua/),
 [LeadGid](https://leadgid.eu/), [Leads.su](https://leads.su/), [PapaKarlo](https://papakarlo.com/), [Sales Doubler](https://www.salesdoubler.com.ua/), Storm Digital

## Installation

Install the package via composer:

``` bash
$ composer require a1ex7/cpa
```

For Laravel 5.4 and below it necessary to register the service provider

### Configuration

In order to edit the default configuration you may execute:
```
php artisan vendor:publish --provider="A1ex\Cpa\CpaServiceProvider"
```

After that, `config/cpa.php` will be created.

### Environment
This package can be configured by environment variables out-of-box:

- **SALES_DOUBLER_ID** - personal id for request to SalesDoubler
- **SALES_DOUBLER_TOKEN** - token for request URI for SalesDoubler
- **STORM_DIGITAL_GOAL** - (default: 1), goal in URL for StormDigital
- **STORM_DIGITAL_SECURE** - secure in URL for StormDigital
- **PAPA_KARLO_TYPE** - ('offer' or 'goal') postback type for PapaKarlo
- **PAPA_KARLO_OFFER** - (default: 35) personal offer id for PapaKarlo
- **PAPA_KARLO_GOAL** - (default: 75) personal goal id for PapaKarlo
- **DO_AFFILIATE_PATH** - path for DoAffiliate API (example: pozichka-ua in http://tracker2.doaffiliate.net/api/pozichka-ua)
- **LEADS_SU_TOKEN** - token for LeadsSu
- **ADMITAD_POSTBACK_KEY** - postback request authentication key, constant string 32 char
- **ADMITAD_CAMPAIGN_CODE** - AdmitAd defined campaign code, constant string 10 char
- **ADMITAD_ACTION_CODE** - target action code, get it from AdmitAd
- **CREDY_OFFER** - offer code, get it from Credy

If one of key for some CPA network not set 
postback requests for this network will not be done. 

### Register Middleware

You may register the package middleware in the `app/Http/Kernel.php` file:

```php
<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {
    /**
    * The application's route middleware.
    *
    * @var array
    */
    protected $routeMiddleware = [
        /**** OTHER MIDDLEWARE ****/
        'lead.check' => \A1ex7\Cpa\Middleware\LeadCheckMiddleware::class
    ];
}
```

You may add middleware to your group like this:

```php
Route::group(
    [
        'middleware' => [ 'lead.check' ]
    ], 
    function(){ //...
});
```

## Usage

Create Lead when user registered
```php
CpaLead::createFromCookie(auth()->user());
// or
CpaLead::createFromCookie($userId);
```

When goal is achieved register conversion 
```php
CpaConversion::register($user, $transactionId, 'sale');
```
Events (e.g. 'sale') **must** be specified in config. You can add additional params for specific events. See `config/cpa.php` samples

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [ A1ex7 @ ArtJoker ][link-author]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/a1ex7/cpa.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/a1ex7/cpa.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/a1ex7/cpa/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/a1ex7/cpa
[link-downloads]: https://packagist.org/packages/a1ex7/cpa
[link-travis]: https://travis-ci.org/a1ex7/cpa
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/a1ex7
[link-contributors]: ../../contributors
