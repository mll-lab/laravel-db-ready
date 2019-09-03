# laravel-db-ready

An artisan command to check if a database connection is ready

[![Build Status](https://travis-ci.org/mll-lab/laravel-db-ready.svg?branch=master)](https://travis-ci.org/mll-lab/laravel-db-ready)
[![codecov](https://codecov.io/gh/mll-lab/laravel-db-ready/branch/master/graph/badge.svg)](https://codecov.io/gh/mll-lab/laravel-db-ready)
[![StyleCI](https://github.styleci.io/repos/150426104/shield?branch=master)](https://github.styleci.io/repos/150426104)
[![GitHub license](https://img.shields.io/github/license/mll-lab/laravel-db-ready.svg)](https://github.com/mll-lab/laravel-db-ready/blob/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/mll-lab/laravel-db-ready.svg)](https://packagist.org/packages/mll-lab/laravel-db-ready)
[![Packagist](https://img.shields.io/packagist/dt/mll-lab/laravel-db-ready.svg)](https://packagist.org/packages/mll-lab/laravel-db-ready)

## Installation

    composer require --dev mll-lab/laravel-db-ready

## Usage

```
Description:
  Wait until a database connection is ready.

Usage:
  db:ready [options]

Options:
      --database[=DATABASE]  The database connection to use
      --timeout[=TIMEOUT]    Time in seconds that connecting should be attempted [default: "5"]
  -h, --help                 Display this help message
  -q, --quiet                Do not output any message
  -V, --version              Display this application version
      --ansi                 Force ANSI output
      --no-ansi              Disable ANSI output
  -n, --no-interaction       Do not ask any interactive question
      --env[=ENV]            The environment the command should run under
  -v|vv|vvv, --verbose       Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```
