# __Urling__

URL parser and constructor in PHP.

## Installation

To install run the command in your terminal:

```shell
composer require ismaxim/urling
```

## Usage

### Start

```php
# Url parser

use Ismaxim\Urling\Urling;

$urling = new Urling("https://github.com/ismaxim/urling#start");
```

```php
# Url constructor

use Ismaxim\Urling\Urling;

$urling = new Urling();
```

### Concept

#### *__Two major ideas__*

***

1. Aliases (see ACCESSING TABLE, column "Aliases").
2. Base editor for processing complete URL and each part separately (see section "Basic usage").

#### *__Accessing__*

***

You can access to concrete URL part to parse it by using its basename (see ACCESSING TABLE, column "Url Part") or ask for its alias (see ACCESSING TABLE, column "Aliases") like: 

```php
$urling->url->scheme->... | $urling->url->protocol->... (other parts of url in a similar way).
```
__ACCESSING TABLE__

| Url Part      | Aliases            | Parser        |
| ------------- | ------------------ | ------------- |
| scheme        | protocol           | SchemeParser  |
| host          | hostname, domain   | HostParser    |
| port          |                    | PortParser    |
| user          | username           | UserParser    |
| pass          | password           | PassParser    |
| path          | routes             | PathParser    |
| query         | params, attributes | QueryParser   |
| fragment      | anchor             | FragmetParser |

#### *__Basic usage__*

***

Basically, the <u>__BaseEditor__ module covers almost every task to [add, get, update or delete] the value of any part of URL.</u>  
<u>__BaseEditor__ is "CRUDable" wrapper over the __parse_url()__ function from vanilla PHP</u> and according to this fact  
it returns and modifies values in a similar way. <u>The only difference is the syntax to accessing on parsing workflow.</u>    

```php
// Working with URL

$urling->url->add();
$urling->url->get();
$urling->url->update();
$urling->url->delete();

// Working with one of the URL parts

$urling->url->scheme->add();
$urling->url->scheme->get();
$urling->url->scheme->update();
$urling->url->scheme->delete();

// For example, let's imagine that the URL is: https://github.com/ismaxim/urling#basic-usage
// Then example workflow to parse this URL in part of "scheme" or "protocol" (see ACCESSING TABLE, column "Aliases") will seem to this:

$urling->url->scheme->get();          # returns "https" (state of URL: https://github.com/ismaxim/urling#basic-usage)
$urling->url->scheme->delete();       # returns null    (state of URL: github.com/ismaxim/urling#basic-usage)
$urling->url->scheme->add("ftp");     # returns "ftp"   (state of URL: ftp://github.com/ismaxim/urling#basic-usage)
$urling->url->scheme->update("smtp"); # returns "smtp"  (state of URL: smtp://github.com/ismaxim/urling#basic-usage)

// Work with other parts of URL can be done in a similar way.
```

#### *__Advanced usage__*

***

If you need to do something like [add, get, update, or delete] the value of any part of the URL,  
but it's outside the scope of the base functionality, you can use one of the __BaseEditor__ functions name  
[add, get, update, or delete] as a prefix with the name of a specific method as postfix appropriate for your task like:
> (add, get, update, delete) + "SomeFunctionName()" for the concrete task.

Note: *Almost all functions will use that code convention permanently.*

Examples:  
- getValueByName();
- getNameValuePairs();

```php
$urling->url->params->getValueByName();
$urling->url->params->getNameValuePairs();
```
