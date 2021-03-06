## PHP library to draw charts

Phpopenchart was based on Libchart and allows you to create charts using PHP. It's specially useful when you need to create charts on the server-side 
and so you can't use a front-end library such as Highcharts.

<img src="https://geekalicious.pt/phpopenchart/assets/images/phpopenchart-sample-2.png"/>

````php
use Phpopenchart\Chart\Column;

$chart = new Column([
    'chart' => [
        'width' => 1000,
        'height' => 300,
    ],
    'title' => [
        'text' => 'Values'
    ],
    'dataset' => [
        'series' => ['Product A', 'Product B', 'Product C'],
        'labels' => ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        'data' => [
            [3296, 4852, 2010, 6004, 5014, 7695],
            [2036, 1816, 687, 1025, 3074, 3651],
            [123, 984, 102, 707, 853, 696],
        ]
    ]
]);

$chart->render();

````

# Documentation & examples

There's an extensive documentation [here](https://geekalicious.pt/phpopenchart/) with all the available options, methods and datasets.

If you're looking for examples check the [examples](https://geekalicious.pt/phpopenchart/examples.php) page for all the available options
or the [/tests/actual](https://github.com/luismarto/phpopenchart/tree/geekalicious-docs/comparison-libchart/actual). 

# Installation

Require the package in your `composer.json` file and update composer, using the following data:

```php
"luismarto/phpopenchart": "3.*"
```


# Roadmap

In a forseable future
- Improve demo/examples section (display comparison between libchart and phpopenchart)
- Make this easily integrated with Laravel

## License

This library is is based on the original work of [Jean-Marc Trémeaux](http://naku.dohcrew.com/) (check the [original website](https://naku.dohcrew.com/libchart/pages/introduction/)).
Also used the fork from [Alexander Stehlik](https://github.com/astehlik).

Phpopenchart is distributed under the terms of the GNU GPL v3.
This includes everything in the source code distribution
except where otherwise stated.

##### Third Party Content

The following third party software is distributed with Phpopenchart and
is provided under other licenses and/or has source available from
other locations. 

Files in the fonts directory are distributed under their own licence, which is located under the fonts directory.