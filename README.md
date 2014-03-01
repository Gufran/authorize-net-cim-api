### Authorize Net CIM API Library
Not all methods are implemented but it is pretty easy to add new method.
I wrote only `CreateCustomerProfile`, `CreatetransactionRequest`, `GetHostedProfilePage`, `GetProfile` and `GetProfileIds` because that was all I needed at the moment. I will implement other methods after finishing with my current project.

### Usage
If you are using Laravel its pretty easy to use the library:

require in your composer file

    "gufran/laravel-authorize-net-cim": "0.1.1"

Add:
    
    'Gufran\AuthNet\LaravelBridge\ServiceProviders\AuthNetServiceProvider'

In service providers array and

    'Authorize' => 'Gufran\AuthNet\LaravelBridge\Facades\AuthNet'

to facades array and publish the configuration:

    php artisan config:publish gufran/authorize-net-cim-api

and add valid options in configuration file. The configuration file should be located at `app/config/packages/gufran/authorize-net-cim-api`

Now you can use the Facade `Authorize` to call methods:
You call a valid method on facade and it will return an object of api delegate which allows you to fluently set all options, here is an example:

    $api = Authorize::createCustomerProfile()
            ->setFirstName('gufran')
            ->setCity('someCity')
            ->setCardNumber('1234567890123456');

This api method now allows you to make the request and retrieve an instance of Response element, which is basically a wrapper around `SimpleXMLElement` with some helper methods like `isValid()` and `isInvalid()` to check for validity of result, of make request and fetch result directly. Here are the examples:

    $result = $api->send(); // returns an instance of Response
    $token = $api->getToken(); // make request, fetches result and pass the method call to Response object which in turn returns the token.

### About API Delegate
Delegate class allows you to make arbitrary get/set function calls and pass them on to request and data model objects.
All `get` method calls will get routed to the Response element and all `set` method calls will be sent to the API Payload object.
Any invalid method calls, which includes get and set methods that do not exists on Response and Payload object, will throw an exception.

