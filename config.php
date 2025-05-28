<?php

require_once './i18n/i18n.php';

define('LANG', Language::from(getenv('APP_LANG') ?: 'en'));

function nav_link(string $path, string $content, ?string $currentPath = null): string {
    $selected = $path === $currentPath
        ? 'class="selected"'
        : '';

    $path = i18n($path);
    $content = i18n($content);

    return "<a {$selected} href=\"{$path}\">{$content}</a>";
}
