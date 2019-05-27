#!/usr/bin/env php
<?php
define('SRC_DIR', dirname(__DIR__));
define('LIB_DIR', SRC_DIR . '/library');
define('LIB_H', SRC_DIR . '/php_swoole_library.h');
define('PHP_TAG', '<?php');

require __DIR__ . '/functions.php';

$library_files = glob(LIB_DIR . '/*.php');
$eval_str = '';
$space4 = space();

foreach ($library_files as $file) {
    $code = file_get_contents($file);
    if ($code === false) {
        swoole_error("can not read file {$file}");
    }
    if (strpos($code, PHP_TAG) !== 0) {
        swoole_error('swoole library php file must start with "<?php"');
    }
    // keep line breaks to align line numbers
    $code = trim(substr($code, strlen(PHP_TAG)));
    $code = str_replace(['\\', '"', "\n"], ['\\\\', '\\"', "\\n\"\n\""], $code);
    $code = implode("\n{$space4}", explode("\n", $code));
    $filename = '/path/to/swoole-src/library' . str_replace(LIB_DIR, '', $file);
    $eval_str .= "zend::eval(\n{$space4}\"{$code}\",\n{$space4}\"{$filename}\"\n);\n\n";
}
// rtrim [\n]
$eval_str = substr($eval_str, 0, -1);
$eval_str = '/**
 * Generated by ' . basename(__FILE__) . ', Please DO NOT modify!
 */' . "\n\n{$eval_str}";
if (file_put_contents(LIB_H, $eval_str) != strlen($eval_str)) {
    swoole_error('Can not write source codes to ' . LIB_H);
}
swoole_success("Generated swoole php library successfully!");