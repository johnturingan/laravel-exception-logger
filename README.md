# Laravel Exception Logger

Its an Exception Logging Library made for Laravel Application


## Installation

Run the following command

```
$ composer require johnturingan/laravel-exception-logger
```

or modify your composer.json like below

```
"require": {
	...
	"johnturingan/laravel-exception-logger": "*",
	...
}
```

Then run **$ composer install** or **$ composer update**, whichever you prefer.


>### Laravel Installation

You need to register the package by going to 
**config/app.php** file then add it to the list of providers.

```
'providers' => [
	...
	Snp\Logger\Providers\LaravelProvider::class
	...
]
```

or in Lumen Application

```
$app->register(Snp\Logger\Providers\LumenProvider::class);
```

Then publish it by using this command

```
$ php artisan vendor:publish --provider="Snp\Logger\Providers\LaravelProvider::class"
```

Keep in mind that config may vary from application to application, it is a must that you check your config file `config/logging.php` and replace the values that is suitable to the application who will use it.

## Recommended Usage

### Exceptions

There are several ways on how to use this package but it is highly recommended that you follow implementations enumerated below:

1. It is highly recommend that you extend your **custom exception** from  
> **Snp\Logger\Exceptions\Exception**

	Then set corresponding values info it like domain, reference_id, etc..

	If you extend your exception from **Snp\Logger\Exceptions\Exception** class, it will automatically log it in Graylog or in storage logs if configured in config/logging.php

2. Another option is to use it in **App\Exceptions\Handler** file. Here's how to do it:
	* Extend the **App\Exceptions\Handler** class from **Snp\Logger\Exceptions\Exception**
	* In **report()** method, add "app_fault" property in Exception $e to determine which application throws an Error.
	* Then create an **Snp\Logger\Info** object and assign it to "log_info" property in Exception $e then pass the Exception to report() method.

		**Below is an example:**

		```
		public function report(Exception $e)
		{
		
		    $e->{'app_fault'} = 'API-CMS';
		    
		    $e->{'log_info'} = (new Info())
		        ->setsetReferenceId('domain.com')
		        ->setDomain('domain.com')
		        ->setSessionId('hashed_session')
		        ->setLanguageCode('en')
		        ->setMemberId(1)
		        ->setUrl('/')
		        ->setIp('127.0.0.1')
		        ;
		
		    parent::report($e);
		}
		```
	
		Using this option, you can manage all exception easily because its in single place only. 

## LOG SAMPLE OUTPUT

If all the properties has been filled up accordingly, below is the expected log output inside `storate/logs/laravel.log`

```
[2018-03-21 07:14:56] production.ERROR: SOAP-ERROR: Parsing WSDL: Couldn't load from 'http://ws.aqzbouat.com/announcementWSs.asmx?WSDL'
{
   "app_fault":"API-SOAP",
   "message":"An error occured",
   "code":0,
   "file":"/src/Exceptions/Handler.php",
   "line":63,
   "reference_id":"3f7577e4380470f232f188565957f233d7cd69c3",
   "platform":"desktop",
   "session_id":"AA2B6A84-0DAC-420F-8D23-36DD3A99266B",
   "member_id":"12345",
   "country_code":PH,
   "language_code":"zh-hans",
   "url":"api/v2/getuser",
   "domain":"domain.com",
   "ip":"127.0.0.1",
   "request_data":{
      "operatorId":"1"
   },
   "headers":{
      "cookie":[
       "e_log_session=3f7577e4380470f232f188565957f233d7cd69c3"
      ],
      "accept-encoding":[
         "gzip, deflate"
      ],
      "referer":[
         "http://domain.com/"
      ],
      ......
   }
}
```