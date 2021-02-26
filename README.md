# BP Prettify

![PHP 7.2](https://github.com/bpextensions/plg_system_bpprettify/workflows/PHP%207.2-8.0/badge.svg)

A Joomla! 3 system plugin that use Google Prettify to highlight code syntax.

## Features

- No performance loss
- Multiple themes available
- No system crashes (code highlight takes place in the browser)
- Automatic updates server

## Requirements

- PHP 7.2+
- Joomla 3.9.x

## Building extension from repo

### Build requirements

- PHP 7.2
- Composer
- Node/Npm

We assume you have `npm` and `composer` available globally.

### Building preparing

How to prepare your installation for development.

- Install composer requirements: `composer install`
- Install node requirements: `npm install`
- Run `npm run build` to build your js/css assets.
- Run `npm run watch` to build your js/css assets after each change.

### Installation package build procedure

- Build installation package: `composer build`
- Your installation zip package should now be ready in `.build/`

## Changelog

### v.1.0.5

- Re-licensing to mach JED requirements.

### v.1.0.4

- Added update server.

### v.1.0.2
- Created build system. Updated code to Joomla! 3.9