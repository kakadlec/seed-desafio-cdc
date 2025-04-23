#!/usr/bin/env php
<?php

if ($argc < 2) {
    echo "Usage: php cdd_icp_counter.php <file.php>\n";
    exit(1);
}

$filePath = $argv[1];
$fileContent = file_get_contents($filePath);

preg_match_all('#//\s*@ICP\(\s*(\d+)\s*\)#', $fileContent, $matches);
$totalICP = array_sum(array_map('intval', $matches[1]));

$fileContent = preg_replace('#//\s*@ICP_TOTAL\(\s*\d+\s*\)\R#', '', $fileContent);

$fileContent = preg_replace_callback(
    '#^(\s*class\s[^\r\n]+)#m',
    fn($match) => "\n// @ICP_TOTAL({$totalICP}){$match[1]}",
    $fileContent,
    1
);

file_put_contents($filePath, $fileContent);
