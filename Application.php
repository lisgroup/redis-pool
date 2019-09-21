<?php
/**
 * 注册类的自动加载
 * User: lisgroup
 * Date: 2017/11/18
 * Time: 下午2:10
 */

spl_autoload_register(function($class) {
    $filename = ROOT_PATH.str_replace('\\', '/', $class).'.php';
    file_exists($filename) && require_once $filename;
});
