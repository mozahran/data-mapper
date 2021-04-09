# CHANGELOG
All notable changes to this project will be documented in this file.

## v1.2.0 (2021-04-09)
***
### Added
- Added PHPUnit 9 to requirements (Marc Prior).

## v1.2.0 (2021-04-02)
***
### Added
- Added a new condition type: `\Zahran\Mapper\Condition\Missing`
- Added tests cases for Condition types: `Contains` & `Missing`

### Changed
- Modified `\Zahran\Mapper\Condition\Contains` to allow users to search for:
  - An occurrence in the source array.
  - An array of occurrences in the source array.
  - An occurrence in a source text.
  - An array of occurrences in the source text.

## v1.1.0 (2021-04-01)
***
### Added
- Added `CHANGELOG.md`
- Added a new cast type: `float`
- Added new condition types: 
  - `not_in`
  - `is_string`
  - `is_boolean`
  - `is_float`
  - `is_double`
  - `is_numeric`
