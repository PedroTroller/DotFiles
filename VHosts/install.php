#!/usr/bin/php
<?php

$dir = dirname(dirname(__DIR__)) . '/Works/';
$hosts = '/etc/hosts';
$sites = '/etc/apache2/sites-available/default';
$limiter = "# CUSTOM HOSTS\n";

// HOST FILE

$content = [];
$reached = false;
foreach (file($hosts) as $item) {
    if (false === $reached) {
        if ($item === $limiter) {
            $reached = true;
        }else {
            $content[] = $item;
        }
    }
}

$content[] = $limiter;

$handle = opendir($dir);

while (false !== ($entry = readdir($handle))) {
    if (!in_array($entry, ['.', '..']) && is_dir($dir.$entry)) {
        $str = sprintf("127.0.0.1\t%s.dev\n", strtolower($entry));
        $content[] = $str;
    }
}

file_put_contents($hosts, $content);

// SITES FILE

$content = [];
$reached = false;
foreach (file($sites) as $item) {
    if (false === $reached) {
        if ($item === $limiter) {
            $reached = true;
        }else {
            $content[] = $item;
        }
    }
}

$content[] = $limiter;

$handle = opendir($dir);

while (false !== ($entry = readdir($handle))) {
    if (!in_array($entry, ['.', '..']) && is_dir($dir.$entry)) {
        $content[] = sprintf("\n");
        $content[] = sprintf("<VirtualHost *:80>\n");
        $content[] = sprintf("\tServerAlias %s.dev\n", strtolower($entry));
        if (is_dir($dir.$entry.'/web/')) {
            $content[] = sprintf("\tDocumentRoot %s/web\n", $dir.$entry);
        } else {
            $content[] = sprintf("\tDocumentRoot %s\n", $dir.$entry);
        }
        $content[] = sprintf("</VirtualHost>\n");
    }
}

file_put_contents($sites, $content);
