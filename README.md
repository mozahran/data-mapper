[![Build Status](https://github.com/mozahran/data-mapper/actions/workflows/php.yml/badge.svg)](https://github.com/mozahran/data-mapper/actions/workflows/php.yml)

# JSON Data Mapper

> Author: [Mohamed Zahran](https://www.linkedin.com/in/mo-zahran/)

## Requirements

- PHP 7.2 or higher.
- cakephp/utility 4.0 or higher.

## Table of Contents

* [Installation](#installation)
* [Usage](#usage)
* [Examples](#mappings-examples)
    1. [Mapping JSON Objects](#1-mapping-json-objects)
    1. [Mapping JSON Arrays](#2-mapping-json-arrays)
    1. [Applying Conditions](#3-applying-conditions)
    1. [Cast Values To Another Type](#4-cast-values-to-another-type)
    1. [Applying Mutators](#5-applying-mutators)
    1. [Additional Features](#6-additional-features)
* [Extending The Package](#extending-the-package)
    1. [Custom Cast Type](#custom-cast-type)
    1. [Add Custom Condition](#add-custom-condition)
    1. [Add Custom Mutator](#add-custom-mutator)
* [Contributing](#contributing)
* [Credits](#credits)
* [License](#license)

## Installation

Install using composer:

```bash
composer require zahran/data-mapper
```

## Usage

After installing the package, make sure you get an instance of the `Container` and register the instances that the tool
needs. Each instance have an alias/id so it can be easily overridden by custom implementations. The overriding part will
be explained in detail later on.

```php
<?php

require_once 'vendor/autoload.php';
$container = \Zahran\Mapper\Container::getInstance();
$container->add([
    'cast_type.boolean' => new \Zahran\Mapper\CastType\Boolean(),
    'cast_type.date' => new \Zahran\Mapper\CastType\Date(),
    'cast_type.integer' => new \Zahran\Mapper\CastType\Integer(),
    'cast_type.string' => new \Zahran\Mapper\CastType\Stringify(),
    'cast_type.float' => new \Zahran\Mapper\CastType\FloatingPointNumber(),
    'condition.contains' => new \Zahran\Mapper\Condition\Contains(),
    'condition.eq' => new \Zahran\Mapper\Condition\Equals(),
    'condition.gt' => new \Zahran\Mapper\Condition\GreaterThan(),
    'condition.gte' => new \Zahran\Mapper\Condition\GreaterThanOrEquals(),
    'condition.in' => new \Zahran\Mapper\Condition\Inset(),
    'condition.not_in' => new \Zahran\Mapper\Condition\NotInset(),
    'condition.lt' => new \Zahran\Mapper\Condition\LessThan(),
    'condition.lte' => new \Zahran\Mapper\Condition\LessThanOrEquals(),
    'condition.neq' => new \Zahran\Mapper\Condition\NotEquals(),
    'condition.notnull' => new \Zahran\Mapper\Condition\NotNullable(),
    'condition.null' => new \Zahran\Mapper\Condition\Nullable(),
    'condition.is_numeric' => new \Zahran\Mapper\Condition\IsNumeric(),
    'condition.is_string' => new \Zahran\Mapper\Condition\IsString(),
    'condition.is_boolean' => new \Zahran\Mapper\Condition\IsBoolean(),
    'condition.is_float' => new \Zahran\Mapper\Condition\IsFloat(),
    'condition.is_double' => new \Zahran\Mapper\Condition\IsDouble(),
    'mutator.multiply' => new \Zahran\Mapper\Mutator\Multiply(),
    'helper.util' => new \Zahran\Mapper\Helper\Util(),
    'factory.cast_type' => new \Zahran\Mapper\Factory\CastTypeFactory(),
    'factory.condition' => new \Zahran\Mapper\Factory\ConditionFactory(),
    'factory.mutator' => new \Zahran\Mapper\Factory\MutatorFactory(),
]);
$mapper = new \Zahran\Mapper\DataMapper(
    new \Zahran\Mapper\Factory\AttributeFactory(),
    new \Zahran\Mapper\DataModifier()
);
$output = $mapper->map(
    file_get_contents('./path/to/data.json'),
    file_get_contents('./path/to/mappings.json')
);
```

## Mappings Examples

### 1. Mapping JSON Objects

In this example, we'll learn how to map simple objects:

#### Original JSON:

```json
{
    "item": "Skirt",
    "price": "40"
}
```

#### Output:

```json
{
    "ItemName": "Skirt",
    "ItemPrice": "40"
}
```

#### Mappings:

**NOTE: REMOVE THE COMMENTS BELOW AFTER YOU COPY/PASTE THE MAPPINGS!**

Comments below are used for demonstration purposes only. Please remove them before you use the sample!

```json
{
    // not necessary at this level
    "name": "root",
    "attributes": [
        {
            // The name of the new attribute
            "name": "ItemName",
            "path": [
                // The path to the attribute in the source JSON
                "item"
            ]
        },
        {
            "name": "ItemPrice",
            "path": [
                "price"
            ]
        }
    ]
}
```

Interesting, isn't it? P.S. You don't have to include all attributes of the JSON object. Map the attributes that you
only need.

### 2. Mapping JSON Arrays

In this example, we'll learn how to map a JSON Array `"items"` to `"ItemsArray"` and rename the `"name"` attribute.

#### Original JSON:

```json
{
    "items_count": "2",
    "items": [
        {
            "name": "Skirt",
            "price": 40
        },
        {
            "name": "T-Shirt",
            "price": 50
        }
    ]
}
```

#### Output:

```json
{
    "ItemsArray": [
        {
            "ItemName": "Skirt"
        },
        {
            "ItemName": "T-Shirt"
        }
    ]
}
```

#### Mappings:

**NOTE: REMOVE THE COMMENTS BELOW AFTER YOU COPY/PASTE THE MAPPINGS!**

Comments below are used for demonstration purposes only. Please remove them before you use the sample!

```json
{
    "name": "root",
    "attributes": [
        {
            "name": "ItemsArray",
            "type": "array",
            // This is required to rewrite JSON Arrays
            "path": [
                "items"
            ],
            "attributes": [
                // Defines the elements of the new JSON Array 
                {
                    "name": "ItemName",
                    "path": [
                        "name"
                    ]
                }
            ]
        }
    ]
}
```

### 3. Applying Conditions

We'll learn how to apply conditions to an attribute. In this example, we'll replace the value of `"completed"` to
either `Completed` or `Pending` based on the original value of the attribute.

A list of supported condition types:

* Contains: `contains`
* Equals: `eq`
* Greater Than: `gt`
* Greater Than or Equals: `gte`
* Inset: `in`
* Not Inset: `not_in`
* Less Than: `lt`
* Less Than or Equals: `lte`
* Not Equals: `neq`
* Not Null: `notnull`
* Null: `null`
* Is Boolean: `is_boolean`
* Is Double: `is_double`
* Is Float: `is_float`
* Is Numeric: `is_numeric`
* Is String: `is_string`

#### Original JSON:

```json
{
    "todos": [
        {
            "userId": 1,
            "id": 1,
            "title": "delectus aut autem",
            "completed": false
        },
        {
            "userId": 1,
            "id": 2,
            "title": "quis ut nam facilis et officia qui",
            "completed": true
        }
    ]
}
```

#### Output:

```json
{
    "ToDo": [
        {
            "ID": 1,
            "Status": "Pending"
        },
        {
            "ID": 2,
            "Status": "Completed"
        }
    ]
}
```

#### Mappings:

**NOTE: REMOVE THE COMMENTS BELOW AFTER YOU COPY/PASTE THE MAPPINGS!**

Comments below are used for demonstration purposes only. Please remove them before you use the sample!

```json
{
    "name": "root",
    "attributes": [
        {
            "name": "ToDo",
            "type": "array",
            "path": [
                "todos"
            ],
            "attributes": [
                {
                    "name": "ID",
                    "path": [
                        "id"
                    ]
                },
                {
                    "name": "Status",
                    "path": [
                        "completed"
                    ],
                    "conditions": [
                        // Defines a list of conditions
                        {
                            "condition_type": "eq",
                            // the value you're comapring against
                            "value": "true",
                            // the replacement text if condition is true
                            "then": "Completed",
                            // optional
                            "otherwise": "Pending"
                        }
                    ]
                }
            ]
        }
    ]
}
```

### 4. Cast Values To Another Type

You can cast values to another type. For example, you may need to change `"1"` to become `"true"`, or convert a date to
another date format.

A list of supported types:

* Boolean: `boolean`
* Date: `date`
* Integer: `integer`
* String: `string`
* Float: `float`

#### Original JSON:

```json
{
    "notifications": [
        {
            "email_sent": 1,
            "sent_at": "2021-03-26 10:24:51 AM"
        },
        {
            "email_sent": 0,
            "sent_at": "2021-03-26 10:24:51 AM"
        }
    ]
}
```

#### Output:

```json
{
    "notifications": [
        {
            "email_sent": true,
            "sent_at": "March 26, 2021, 10:24 AM"
        },
        {
            "email_sent": false,
            "sent_at": "March 26, 2021, 10:24 AM"
        }
    ]
}
```

#### Mappings:

**NOTE: REMOVE THE COMMENTS BELOW AFTER YOU COPY/PASTE THE MAPPINGS!**

Comments below are used for demonstration purposes only. Please remove them before you use the sample!

```json
{
    "name": "root",
    "attributes": [
        {
            "name": "notifications",
            "type": "array",
            "path": [
                "notifications"
            ],
            "attributes": [
                {
                    "name": "email_sent",
                    "path": [
                        "email_sent"
                    ],
                    "cast": {
                        "type": "boolean"
                    }
                },
                {
                    "name": "sent_at",
                    "path": [
                        "sent_at"
                    ],
                    "cast": {
                        "type": "date",
                        // required for cast type "date"
                        "format": "Y-m-d h:i A"
                    }
                }
            ]
        }
    ]
}
```

### 5. Applying Mutators

Sometimes, you may need to change a value based on some business logic. Mutators allow you to apply custom PHP logic
around the attribute value. It also gives the ability to use native PHP built-in functions.

A list of supported mutators:

* Arithmetic Multiplication: `multiply`
* PHP Built-in Functions

#### Original JSON:

In this example, we are going to convert the title to uppercase and multiply the views by 5.

```json
{
    "articles": [
        {
            "title": "Lorem ipsum dolor sit amet",
            "views": 10
        },
        {
            "text": "CONSECTETUR adipiscing elit",
            "views": 15
        }
    ]
}
```

#### Output:

```json
{
    "articles": [
        {
            "title": "LOREM IPSUM DOLOR SIT AMET",
            "views": 50
        },
        {
            "title": "CONSECTETUR ADIPISCING ELIT",
            "views": 75
        }
    ]
}
```

#### Mappings:

**NOTE: REMOVE THE COMMENTS BELOW AFTER YOU COPY/PASTE THE MAPPINGS!**

Comments below are used for demonstration purposes only. Please remove them before you use the sample!

```json
{
    "name": "root",
    "attributes": [
        {
            "name": "articles",
            "type": "array",
            "path": [
                "articles"
            ],
            "attributes": [
                {
                    "name": "title",
                    "path": [
                        "title"
                    ],
                    "mutators": [
                        {
                            "name": "strtoupper",
                            "arguments": [
                                // use this magic keyword to pass the original value to the built-in functions
                                // in our case, the original value must be the first argument of "strtoupper"
                                "__value__"
                            ]
                        }
                    ]
                },
                {
                    "name": "views",
                    "path": [
                        "views"
                    ],
                    "mutators": [
                        {
                            "name": "multiply",
                            "arguments": [
                                // the original value times 5
                                5
                            ]
                        }
                    ]
                }
            ]
        }
    ]
}
```

### 6. Additional Features

#### Default Values

It's possible to set a default value for an attribute. This can be useful if the path you set doesn't exist, or you want
to set a default value anyway.

```json
{
    "name": "root",
    "attributes": [
        {
            "name": "PersonName",
            "path": [
                "fullname"
            ],
            "default": "John Doe"
            // <--- if "fullname" doesn't exist in the source data, "PersonName" will be set to "John Doe"
        }
    ]
}
```

#### Limiting Array Items

Sometimes, you may want to get certain items from an array depending on your use-case. It's possible to define a list of
indices. Please note that the first index starts with 0. To do so, append an array of indices as a second argument to
the `"path"` array on the target attribute. Possible ways to limit items:

```json
    ...
    "path": [
    "categories",
        [0, 1]
    ]
    ...

    ...
    "path": [
    "categories",
        0 // you can select only on index and get the value as a string or whatever the data type of the source data.
    ]
    ...
```

##### Original JSON:

In this example, we are going to map all items but limit the categories to the first two items of the array and inject
some hard-coded values as the default value for an attribute that's going to be created during runtime.

```json
{
    "articles": [
        {
            "title": "Lorem ipsum dolor sit amet",
            "categories": [
                10,
                55,
                3,
                20
            ]
        }
    ]
}
```

##### Output:

```json
{
    "articles": [
        {
            "title": "Lorem ipsum dolor sit amet",
            "categories": [
                10,
                55
            ]
        }
    ]
}
```

##### Mappings:

**NOTE: REMOVE THE COMMENTS BELOW AFTER YOU COPY/PASTE THE MAPPINGS!**

Comments below are used for demonstration purposes only. Please remove them before you use the sample!

```json
{
    "name": "root",
    "attributes": [
        {
            "name": "articles",
            "type": "array",
            "path": [
                "articles"
            ],
            "attributes": [
                {
                    "name": "title",
                    "path": [
                        "title"
                    ]
                },
                {
                    "name": "categories",
                    "path": [
                        "categories",
                        [
                            0,
                            1
                        ]
                    ]
                }
            ]
        }
    ]
}

```

### Appending Values On Limiting Array Items
In the example, above we learnt how to get certain items from an array using indices, but you may have a case where you 
want to append a value at the end of the list.
This is can be done this way:
```json
    ...
    {
        "name": "categories",
        "path": [
            "categories",
            [
                0,
                1,
                "$foo", // the output will be: "foo"
                "$bar", // the output will be: "bar"
                "$100.5", // the output will be: 100.5
                "$100", // the output will be: 100
                "$true", // the output will be: true
                "$false", // the output will be: false
                "$null" // the output will be: "null"
            ]
        ]
    }
    ...
```

## Notes On The Mappings

You should now be aware of how Mappings are built. Nevertheless, I feel that you may need to bear these things in mind
while building yours.

* You shouldn't add any modifiers (Cast type, conditions or mutators) to an attribute of type `array` because they won't
  be effective. Instead, add modifiers to the attributes that sit under that JSON array - AKA Nested Attributes.

```json
{
    "name": "articles",
    "type": "array",
    // <--- JSON Array
    "path": [
        "articles"
    ],
    // don't add "conditions", "cast_type" or "mutators" here. they won't be effective.
    "attributes": [
        {
            "name": "title",
            "path": [
                "title"
            ]
            // add them here instead, so they get applied to the "title" attribute.
        }
    ]
}
```

## Extending The Package

The package is built to be extensible to allow you to add custom cast types, conditions and/or mutators. Moreover, you
can retire any of the core classes, just make sure you're implementing the right interface.

### Custom Cast Type

1. You'll need to implement `\Zahran\Mapper\Contract\CastType`. It has two public methods: `setModel` and `cast`. Create
   the new Cast Type you want and follow the example below:

```php
<?php

namespace Your\Vendor\Name;

use Zahran\Mapper\Contract\CastType as CastTypeInterface;
use Zahran\Mapper\Model\CastType;

class MyCustomCastType implements CastTypeInterface
{
    /**
     * @var CastType
     */
    protected $model;

    public function setModel(CastType $model): CastTypeInterface
    {
        $this->model = $model;
        return $this;
    }

    public function cast($originalValue): bool
    {
        // implement your logic here.
    }
}
```

2. Add your custom cast type to the Container. Replace `{type}` with the name you want to use in the mappings (i.e.
   custom). You can replace a core class by overriding the id. For example, if you want to replace
   class `\Zahran\Mapper\CastType\Boolean` with your own version, you'll need to register your custom implementation
   under `cast_type.boolean`.

```php
<?php

\Zahran\Mapper\Container::getInstance()->add(
    'cast_type.{type}', 
    new \Your\Vendor\Name\MyCustomCastType()
);
```

### Add Custom Condition

1. You'll need to implement `\Zahran\Mapper\Contract\Condition`. It has two public methods: `setModel` and `apply`.
   Create the new Condition you want and follow the example below:

```php
<?php

namespace Your\Vendor\Name;

use Zahran\Mapper\Contract\Condition as ConditionInterface;
use Zahran\Mapper\Model\Condition;

class MyCustomCondition implements ConditionInterface
{
    /**
     * @var Condition
     */
    protected $model;

    public function setModel(Condition $model): ConditionInterface
    {
        $this->model = $model;
        return $this;
    }

    public function apply($originalValue)
    {
        // use $originalValue to compare against it anything you want.
        // use $this->model->getThen() to get the return value if the condition is true.
        // use $this->model->getOtherwise() to get the return value if the condition is false.
    }
}

```

2. Add your custom condition to the Container. Replace `{condition_type}` with the name you want to use in the
   mappings (i.e. custom). You can replace a core class by overriding the id. For example, if you want to replace
   class `\Zahran\Mapper\Condition\Equals` with your own version, you'll need to register your custom implementation
   under `condition.eq`.

```php
<?php

\Zahran\Mapper\Container::getInstance()->add(
    'condition.{condition_type}', 
    new \Your\Vendor\Name\MyCustomCondition()
);
```

### Add Custom Mutator

1. You'll need to implement `\Zahran\Mapper\Contract\Condition`. It has two public methods: `setModel` and `apply`.
   Create the new Condition you want and follow the example below:

```php
<?php

namespace Your\Vendor\Name;

use Zahran\Mapper\Contract\Mutator as MutatorInterface;
use Zahran\Mapper\Model\Mutator;

class Multiply implements MutatorInterface
{
    /**
     * @var Mutator
     */
    protected $model;

    public function setModel(Mutator $model): MutatorInterface
    {
        $this->model = $model;
        return $this;
    }

    public function apply($originalValue, array $arguments = [])
    {
        // add your logic here
    }
}


```

2. Add your custom mutator to the Container. Replace `{name}` with the name you want to use in the mappings (i.e.
   custom). You can replace a core class by overriding the id. For example, if you want to replace
   class `\Zahran\Mapper\Mutator\Multiply` with your own version, you'll need to register your custom implementation
   under `mutator.multiple`.

```php
<?php

\Zahran\Mapper\Container::getInstance()->add(
    'mutator.{name}', 
    new \Your\Vendor\Name\MyCustomMutator()
);
```

## Contributing

All changes that makes the Mapper more accurate is always highly appreciated and welcome.

## Credits

- [Mohamed Zahran](https://github.com/mozahran)
- [Mohamed Hafez](https://github.com/mohamedhafezqo)
- [Ahmed Sallam](https://github.com/ahmedsallam1)

## License

The JSON Mapper is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
