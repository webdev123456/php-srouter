<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/7/16
 * Time: 下午10:43
 */

namespace Inhere\Route;

/**
 * Interface RouterInterface
 * @package Inhere\Route
 */
interface RouterInterface
{
    // match result status
    const FOUND = 1;
    const NOT_FOUND = 2;
    const METHOD_NOT_ALLOWED = 3;

    const FAV_ICON = '/favicon.ico';
    const DEFAULT_REGEX = '[^/]+';

    // supported method list
    const ANY = 'ANY';

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const OPTIONS = 'OPTIONS';
    const HEAD = 'HEAD';
    const SEARCH = 'SEARCH';
    const CONNECT = 'CONNECT';
    const TRACE = 'TRACE';

    /**
     * supported methods
     * @var array
     */
    const SUPPORTED_METHODS = [
        'ANY',
        'GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD', 'SEARCH', 'CONNECT', 'TRACE',
    ];

    /**
     * the matched result index key
     */
    const INDEX_STATUS = 0;
    const INDEX_PATH = 1;
    const INDEX_INFO = 2;

    /**
     * @return array
     */
    public static function getSupportedMethods();
}
