#!/usr/bin/php
<?php

function buildUrl($entry)
{
    if (false === strpos($entry, '.')) {

        return sprintf('%s.dev', $entry);
    }

    return $entry;
}

$dir = dirname(dirname(__DIR__)) . '/Works/';
$hosts = '/etc/hosts';
$sites = '/etc/apache2/sites-available/000-default.conf';
$enabled = '/etc/apache2/sites-enabled';
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
        $str = sprintf("127.0.0.1\t%s\n", strtolower(buildUrl($entry)));
        $content[] = $str;
        $str = sprintf("127.0.0.1\twww.%s\n", strtolower(buildUrl($entry)));
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
        if (is_dir($targ.'/symfony/web')) {
            $targ = sprintf('%s/symfony/web', $targ);
        }
        if (is_dir($targ.'/web')) {
            $targ = sprintf('%s/web', $targ);
        }

        $template = file_get_contents(sprintf('%s/template.conf', __DIR__));
        $template = str_replace('%server_name%', strtolower(buildUrl($entry)), $template);
        $template = str_replace('%server_alias%', buildUrl($entry), $template);
        $template = str_replace('%document_root%', $targ, $template);

        file_put_contents(sprintf('%s/%s.conf', $enabled, $entry), $template);
    }
}
