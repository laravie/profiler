# Changelog

This changelog references the relevant changes (bug and security fixes) done to `laravie/profiler`.

## 3.1.0

Released: 2020-03-01

### Changes

* Add support to Laravel Framework v6.
* Use `hrtime()` instead of `microtime()`.

## 3.0.0

Released: 2019-08-28

### Changes

* Add support to Laravel Framework v6.
* Refactor `Laravie\Profiler\Timer`.
* Improve performance by prefixing all global functions calls with `\` to skip the look up and resolve process and go straight to the global function.
* return `self` should only be used when method is marked as `final`.

## 2.0.1

Released: 2019-02-17

### Changes

* Improve performance by prefixing all global functions calls with `\` to skip the look up and resolve process and go straight to the global function.

## 2.0.0

Released: 2018-05-01

### Changes

* Bump minimum supported PHP version to 7.1+.
* Update supported Laravel Framework to 5.6+.

## 1.1.0

Released: 2017-12-27

### Added

* Added `Laravie\Profiler\Contracts\Timer`.
* Added support to add context to monolog.

### Changes

* Bump minimum supported PHP version to 7.0+.

## 1.0.0

Released: 2017-07-25

### Added

* Initial stable release.
