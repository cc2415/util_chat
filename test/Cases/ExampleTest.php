<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Cases;

use App\MessageModel\MessageFactory;
use HyperfTest\HttpTestCase;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends HttpTestCase
{
    public function testExample()
    {
        $params = ['asdfasdf', ['asdfl' => 213]];
        $res = MessageFactory::createMessage('text', ...$params);
//        $res = MessageFactory::createMessage('text', 'shuo', ['extend l内容 ', 'adsasdf']);
        var_dump($res);
    }
}
