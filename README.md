Cadenza
=======
Cadenza is just Composer, but without _other people junk_.
> In music, a cadenza is an improvised or written-out ornamental passage played or sung by a soloist or soloists, usually in a "free" rhythmic style.

## Why?
Because I'm tired of having tests, invalid xmls, and other people junk in my source class path.

## How it work?
Whenever you require a dependecy, composer grab all the project, with all the junk
their mantainers throw at it.

**Cadenza** creates a top-level directory, named `vendor.src`, which includes all
your dependecies sources folders, as symbolic-links pointing to the real `vendor` dir.

## Install
Simply add **Cadenza** as a dependency to your composer.json file:

```json
{
  "require": {
    "eridal/cadenza": "*"
  },
  "scripts": {
    "post-update-cmd": [ "php vendor/bin/cadenza.php" ]
  },
}
```
