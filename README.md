Stream Sampler
==============

[![Build Status](https://travis-ci.org/lastzero/stream-sampler.png?branch=master)](https://travis-ci.org/lastzero/stream-sampler)
[![License](https://poser.pugx.org/lastzero/stream-sampler/license.svg)](https://packagist.org/packages/lastzero/stream-sampler)

This is an example PHP command-line application based on https://github.com/lastzero/symlex-core

## What does a stream sampler do?

It randomly returns a representative sample of *k* items from a stream of values with unknown and
possibly very large length. The implementation relies on Algorithm R, which has a complexity of O(N).
See https://en.wikipedia.org/wiki/Reservoir_sampling

## Setup

Clone this repository to a local directory and run composer:

    # git clone https://github.com/lastzero/stream-sampler.git
    # cd stream-sampler
    # composer update

## Usage

    # app/console sample [options]

    Options:
      -i, --input[=INPUT]   Input source (stdin, random.org, internal) [default: "stdin"]
      -s, --size[=SIZE]     Sample size [default: 5]
      -V, --version         Display the application version
          --ansi            Force ANSI output
          --no-ansi         Disable ANSI output

## Example

    # app/console sample -i internal -s 10
    vgB4xtQTF3

    # app/console sample < LICENSE
    TegcI

## Tests

Stream Sampler comes with a pre-configured PHPUnit environment that automatically executes tests found in `src/`:

    # app/phpunit
    PHPUnit 4.8.13 by Sebastian Bergmann and contributors.

    ............

    Time: 240 ms, Memory: 8.50Mb

    OK (12 tests, 16778 assertions)

See also: https://github.com/lastzero/test-tools (self-initializing database fixtures and dependency injection for unit tests)

## Similar work

- https://github.com/htimur/stream-sampler (PHP)
- https://github.com/Shaked/rg-stream-sampler (PHP)
- https://github.com/dotMR/stream-sampler (JavaScript)
- https://github.com/dousto/weighted-reservoir-sampler (JavaScript)