<?php

namespace Mix\Tcp;

use Mix\Core\Application\ComponentInitializeTrait;

/**
 * Class Application
 * @package Mix\Tcp
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class Application extends \Mix\Core\Application
{

    use ComponentInitializeTrait;

    /**
     * 执行连接
     * @param $tcp
     */
    public function runConnect($tcp)
    {
        $handler = \Mix::$app->registry->getHandler();
        $handler->connect($tcp);
    }

    /**
     * 执行接收
     * @param $tcp
     * @param $data
     */
    public function runReceive($tcp, $data)
    {
        $handler = \Mix::$app->registry->getHandler();
        $handler->receive($tcp, $data);
    }

    /**
     * 执行连接关闭
     * @param $tcp
     */
    public function runClose($tcp)
    {
        $handler = \Mix::$app->registry->getHandler();
        $handler->close($tcp);
    }

}
