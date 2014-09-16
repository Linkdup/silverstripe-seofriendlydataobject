# SEO Friendly Data Object Module for SilverStripe

A SilverStripe [DataObject](http://docs.silverstripe.org/framework/en/reference/dataobject) extension to enable SEO friendly data objects.	

## Requirements

Silverstripe 3.0+

## Installation

Please install using composer, then extend any data object that you want
to give a unique URL in your config.yml file.

```yaml
MyDataObject:
  extensions:
    ['SeoFriendlyDataObject']
```

## Attribution

The code is based on URLDataObject by Simon Elvery ([see](https://github.com/drzax/silverstripe-bits/tree/master/URLDataObject))

## License

Copyright 2014 Mattias Lindgren
See the file called LICENSE.