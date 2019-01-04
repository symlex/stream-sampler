# Stream Sampler

[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Build Status](https://travis-ci.org/symlex/stream-sampler.png?branch=master)](https://travis-ci.org/symlex/stream-sampler)
[![Documentation](https://readthedocs.org/projects/symlex-docs/badge/?version=latest&style=flat)](https://docs.symlex.org/en/latest/)

This is an example PHP command-line application based on [Symlex Core](https://github.com/symlex/symlex-core).

## What does a stream sampler do?

It randomly returns a representative sample of *k* items from a stream of values with unknown and
possibly very large length. The implementation relies on Algorithm R, which has a complexity of O(N).
See https://en.wikipedia.org/wiki/Reservoir_sampling

## Setup

This application is compatible with PHP 7.1+ with the *curl* extension enabled.

Clone this repository to a local directory and run composer:

    git clone https://github.com/symlex/stream-sampler.git
    cd stream-sampler
    composer update

Alternatively you can run composer to create a new project from the latest stable release and fetch external dependencies:

    composer create-project symlex/stream-sampler my-stream-sampler

## Usage

    app/console sample [options]

    Options:
      -i, --input[=INPUT]   Input source (stdin, random.org, internal) [default: "stdin"]
      -s, --size[=SIZE]     Sample size (1 - 2000) [default: 5]
      -V, --version         Display the application version
          --ansi            Force ANSI output
          --no-ansi         Disable ANSI output

*Note: If you're using random.org or the internal random character source, input data size will be 10 times the sample size. The maximum sample size is 2000.*

## Examples

    # app/console sample -i internal -s 10
    vgB4xtQTF3

    # app/console sample -i random.org -s 8
    FcojkJX1

    # app/console sample < LICENSE
    TegcI

    # echo 'Pe7emsXm0EHfwAVx' | app/console sample
    Xe7es

## Tests

Stream Sampler comes with a pre-configured PHPUnit environment that automatically executes tests found in `src/`:

    PHPUnit 7.5.1 by Sebastian Bergmann and contributors.
    
    .......                                         7 / 7 (100%)
    
    Time: 431 ms, Memory: 8.00MB
    
    OK (7 tests, 16892 assertions)

See also: https://github.com/lastzero/test-tools (self-initializing database fixtures and dependency injection for unit tests)

## Similar work

- https://github.com/htimur/stream-sampler (PHP)
- https://github.com/Shaked/rg-stream-sampler (PHP)
- https://github.com/dotMR/stream-sampler (JavaScript)
- https://github.com/dousto/weighted-reservoir-sampler (JavaScript)
