Mongator CodeIgniter Spark [![Build Status](https://travis-ci.org/mongator/codeigniter.png?branch=master)](https://travis-ci.org/mongator/codeigniter)
==============================

Spark for using Mongator with CodeIgniter

Requirements
------------

* PHP >=5.3.0
* CodeIgniter >=2.0.0
* mongator/mongator

Installation
------------

You should generally use the spark system to install mongator. From the terminal, and inside the root of a CodeIgniter project, type:

```
php tools/spark install -v0.0.1 mongator
```

Configuration
------------

You can find a example of the configuration file and a help inside of the spark content. Configure it to function correctly. 


Usage
------------

```PHP
$CI = get_instance();

$articleRepository = $CI->mongator->getRepository('Model\Article');
$article = $articleRepository->findOneById($id);
```

** Remember, before use the models you must generate it. (You can use the command provided with this package.) **

Commands
------------
With this package you can find three useful commands:

* ```mongator:generate```: Process config classes and generate the files of the classes.
* ```mongator:indexes```: Ensure the indexes of all repositories
* ```mongator:fix```: Fixes all the missing references.

Typing ```./tools/mongator.php``` inside the root of a CodeIgniter project, you will get a list of command available. 

Tests
-----

Tests are in the `tests` folder.
To run them, you need PHPUnit.
Example:

    $ phpunit --configuration phpunit.xml.dist


License
-------

MIT, see [LICENSE](LICENSE)