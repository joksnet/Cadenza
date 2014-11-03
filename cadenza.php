<?php

include 'vendor/composer/autoload_classmap.php';
define('FOLDER_CADENZA', $baseDir . '/composer');

$loader = require 'vendor/autoload.php';
$packages = packages($loader);

foreach ($packages as $preffix => $paths) {

    $package = package($preffix);
    $folder = FOLDER_CADENZA . "/$package";

    if (count($paths) > 1) {
        readfile(__DIR__ . '/message.txt');
        exit;
    }

    $path = $paths[0];

    if (inVendor($path)) {
        createLink($path, $folder);
    }
}


function packages($loader) {
    $methods = array(
        'getPrefixes',
        'getPrefixesPsr4',
        'getFallbackDirs',
        'getFallbackDirsPsr4',
        'getClassMap',
    );
    $result = array();
    foreach ($methods as $method) {
        if ($paths = $loader->{$method}()) {
            $result = array_merge($result, $paths);
        }
    }
    return $result;
}

function package($preffix) {
    $preffix = trim($preffix, '\\');
    $preffix = strtr($preffix, '\\', '.');
    return $preffix;
}

/**
 * @param string $path
 * @return boolean
 */
function inVendor($path) {
    return false !== strpos($path, '/vendor/');
}

function createFolder($path) {

    if (is_dir($path)) {
        return;
    }

    if (file_exists($path)) {
        throw new Exception("$path exists but is not directory");
    }

    $parent = dirname($path);

    if (!is_dir($parent)) {
        createFolder($parent);
    }

    mkdir($path);
}

function createLink($target, $link) {

    if (!file_exists($target)) {
        throw new Exception("$target does not exists");
    }

    $link = rtrim($link, '/');

    if (is_link($link) and $currentTarget = readlink($link)) {
        if ($currentTarget !== $target) {
            throw new Exception("$link exists, pointing to $currentTarget");
        } else {
            unlink($link);
        }
    } else if (file_exists($link)) {
        throw new Exception("$link exists but is not link");
    }

    $target = rtrim($target, '/');
    $folder = dirname($link);
    createFolder($folder);
    symlink($target, $link);
}
