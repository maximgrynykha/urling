[![Urling - url parser & constructor](https://raw.githubusercontent.com/ismaxim/urling/master/assets/hero-image.png "Urling")](https://github.com/ismaxim/urling#installation)

![Build Status](https://img.shields.io/github/workflow/status/ismaxim/urling/Build?label=build&logo=github&logoColor=white&style=for-the-badge)

<!-- <p align="center">
    <img src="https://img.shields.io/github/workflow/status/ismaxim/urling/Build?label=build&logo=github& logoColor=white&style=for-the-badge" alt="Build Status">
    <img src="https://img.shields.io/codecov/c/github/samsonasik/mezzio-authentication-with-authorization?color=codecov&logo=codecov&style=for-the-badge" alt="Tests Coverage">
    <img src="https://img.shields.io/packagist/l/ismaxim/urling?color=1384C4&style=for-the-badge" alt="Packagist License">
    <img src="https://img.shields.io/packagist/v/laravel/laravel?label=version&style=for-the-badge" alt="Packagist Version">
</p> -->

# __Urling__

> 🌐 <a href="https://github.com/ismaxim/urling/blob/master/assets/README-RU.md">Документация на русском →</a> | <a href="https://github.com/ismaxim/urling/blob/master/assets/README-UA.md">Документація на українській →</a>

## ⚙️ Installation

To install this library - run the command below in your terminal:

```shell
composer require ismaxim/urling
```

## 🧙 Usage

### 📖 Concept

#### Three major ideas

📗 1. Two modes to work with URL: parser mode & constructor mode.  
📘 2. Accessing to concrete part of URL with using aliases (see [ACCESSING TABLE](#accessing-table), column [Aliases](#aliases)).  
📙 3. Base editors for processing complete URL and each part separately (see section [Basic usage](https://github.com/ismaxim/urling#basic-usage)).  

***

### 🚀 Start

```php
# Url parser mode

use Urling\Urling;

$urling = new Urling("https://github.com/ismaxim/urling#start");

$url_part_values = [
    "protocol_value" => $urling->url->protocol->get(),
    "domain_value"   => $urling->url->domain->get(),
    "routes_value"   => $urling->url->routes->get(),
    "anchor_value"   => $urling->url->anchor->get(),
];

print_r($url_part_values);

/* 
    RESULT: 

    [
        "protocol_value" => "https",
        "domain_value"   => "github.com",
        "routes_value"   => "ismaxim/urling",
        "anchor_value"   => "start",
    ] 
*/
```

```php
# Url constructor mode

use Urling\Urling;
        
$urling = new Urling();

$urling->url->construct([
    "protocol" => "https",
    "domain"   => "github.com",
    "routes"   => "ismaxim/urling",
    "anchor"   => "start",
]);

// Either you can set the value for each distinct part 
// in the url by accessing it directly, for example:

$urling->url->protocol->add("https");
$urling->url->domain->add("github.com");
$urling->url->routes->add("ismaxim/urling");
$urling->url->anchor->add("start");

print_r($urling->url->get());

/* 
    RESULT:
    
    "https://github.com/ismaxim/urling#start"
*/
```

#### 🔑 *__Accessing__*

***

You can access to concrete URL part to parse it by using its basename (see [ACCESSING TABLE](#accessing-table), column [Url Part](#url-part)) or ask for its alias (see [ACCESSING TABLE](#accessing-table), column [Aliases](#aliases)) like: 

```php
$urling->url->scheme->... | $urling->url->protocol->... (other parts of url in a similar way).
```
<a id="accessing-table"></a>__ACCESSING TABLE__

| <a id="url-part"></a>Url Part | <a id="aliases"></a>Aliases | <a id="parser"></a>Parser               |
| ----------------------------- | --------------------------- | --------------------------------------- |
| scheme                        | protocol                    | [SchemeParser](https://bit.ly/3vOpzbs)  |
| user                          | username                    | [UserParser](https://bit.ly/2NLCWYQ)    |
| pass                          | password                    | [PassParser](https://bit.ly/3lPdkXG)    |
| host                          | hostname, domain            | [HostParser](https://bit.ly/394KA8c)    |
| port                          |                             | [PortParser](https://bit.ly/39aiMz0)    |
| path                          | routes                      | [PathParser](https://bit.ly/3lEZS8H)    |
| query                         | params, attributes          | [QueryParser](https://bit.ly/3d0VaOu)   |
| fragment                      | anchor                      | [FragmetParser](https://bit.ly/3tKfI4C) |

#### 👶 *__Basic usage__*

***

Basically, the <ins>__BaseEditor__ module covers almost every task to *__add, get, update or delete__* the value of any part of URL.</ins>  
<ins>__BaseEditor__ is "CRUDable" wrapper over the __parse_url()__ function from vanilla PHP</ins> and according to this fact  
it returns and modifies values in a similar way. <ins>The only difference is the syntax to accessing on parsing workflow.</ins>    

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

#### 🧔 *__Advanced usage__*

***

If you need to do something like [add, get, update, or delete] the value of any part of the URL,  
but it's outside the scope of the base functionality, you can use one of the __BaseEditor__ functions name  
[add, get, update, or delete] as a prefix with the name of a specific method as postfix appropriate for your task like:

> (add, get, update, delete) + "SomeFunctionName" for the concrete task.

Note: *Almost all functions will use that code convention permanently.*

Examples:  
- getValueByName();
- getNameValuePairs();
- etc. ...

```php
$urling->url->params->getValueByName();
$urling->url->params->getNameValuePairs();
```

## 🧪 Testing

_Actually, all tests already automatically passed within CI build._

To test this library - run the command below in your terminal.

```shell
composer test
```

## 🤝 Contributing

If you got a task that doesn't can be solved with this library, please write your own solution,  
and if you wish to help others who use this library also (or wants to save your solution  
workable after the new release will arrive at your dependencies) — make a pull-request.   
We will happy to add your brilliant code to the library!  

🐞 Report any bugs or issues you find on the [GitHub issues](https://github.com/ismaxim/urling/issues).

### ✨ Creating custom functional

You can extend the functionality of the library with your own code, making edits to solve your problems in the parser classes.  
There are two types of parser classes the first and the main is [URL parser](https://github.com/ismaxim/urling/blob/master/src/Urling/Core/Url.php), but there are others as well, - [URL parts parsers](https://github.com/ismaxim/urling/tree/master/src/Urling/PartParsers).  
For each part is separate own parser.

Using the library or examining docs you can notice the same or similar to this record:

```php
$urling->url->params->get()
```

This entry might interpret the next way: "Hey, Urling, ask to the part 'params' on the current URL and return it value(this part)".

Basically extending functionality, you will work with a part of the URL almost all times  
and will processing or get the value for a specific part. To understand how to access to parser for needed part you can look at [ACCESSING_TABLE](#accessing-table).  
You only need to match the [*__url part__*](#url-part) and [*__aliases__*](#aliases) sections with the [*__parser__*](#parser) section, and then go to the desired parser file and write the best code in the world! 

## 📎 Credits
- [Maintainer →](https://github.com/ismaxim)
- [Contributors →](https://github.com/ismaxim/urling/contributors)

## 📃 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
