#!/usr/bin/php
<?php

$dir = dirname(dirname(__DIR__)) . '/Works/';
$hosts = '/etc/hosts';
$sites = '/etc/apache2/sites-available/000-default.conf';
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
        $targ = $dir.$entry;
        if (is_dir($dir.$entry.'/web/')) {
            $targ = sprintf('%s/web', $targ);
        }
        $content[] = sprintf("\n");
        $content[] = sprintf("<VirtualHost *:80>\n");
        $content[] = sprintf("\tServerName %s.dev\n", strtolower($entry));
        $content[] = sprintf("\tServerAlias %s.dev\n", $entry);
        $content[] = sprintf("\tDocumentRoot %s\n", $targ);
        $content[] = sprintf("\t<Directory %s>\n", $targ);
        $content[] = sprintf("\tAllowOverride All\n");
        $content[] = sprintf("\tRequire all granted\n");
        $content[] = sprintf("\t</Directory>\n");
        $content[] = sprintf("</VirtualHost>\n");
    }
}

file_put_contents($sites, $content);
