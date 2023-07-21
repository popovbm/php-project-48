### Hexlet tests and linter status:
[![Actions Status](https://github.com/popovbm/php-project-48/workflows/hexlet-check/badge.svg)](https://github.com/popovbm/php-project-48/actions)
[![Popov check](https://github.com/popovbm/php-project-48/actions/workflows/popov-check.yml/badge.svg)](https://github.com/popovbm/php-project-48/actions/workflows/popov-check.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/295b35efa56d194c5cae/maintainability)](https://codeclimate.com/github/popovbm/php-project-48/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/295b35efa56d194c5cae/test_coverage)](https://codeclimate.com/github/popovbm/php-project-48/test_coverage)


## Difference Calculator
Difference Calculator is a command line tool for finding differences in configuration files (JSON, YAML). It generates reports in the form of plain text, tree and json.

### Usage
  gendiff (-h|--help)
  
  gendiff (-v|--version)
  
  gendiff [--format <fmt>] <firstFile> <secondFile>
  
### Report formats:
<ul>
<li>plain
<li>stylish
<li>json
</ul>

### Requirements

PHP: >= 7.4

Composer: ^2.3

GNU make: ^4.2

### Setup

```sh
$ git clone git@github.com:popovbm/php-project-48.git

$ cd php-project-48

$ make install
```

### Example:
[![asciicast](https://asciinema.org/a/535214.svg)](https://asciinema.org/a/535214)
