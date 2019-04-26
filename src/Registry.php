<?php

namespace Mix\Tcp;

use Mix\Core\Component\ComponentInterface;
use Mix\Core\Component\AbstractComponent;
use Mix\Tcp\Handler\TcpHandlerInterface;

/**
 * Class Registry
 * @package Mix\Tcp
 * @author liu,jian <coder.keda@gmail.com>
 */
class Registry extends AbstractComponent
{

    /**
     * 协程模式
     * @var int
     */
    const COROUTINE_MODE = ComponentInterface::COROUTINE_MODE_REFERENCE;

    /**
     * 处理者
     * @var \Mix\Tcp\Handler\TcpHandlerInterface
     */
    public $handler;

    /**
     * 获取处理器
     * @return TcpHandlerInterface
     */
    public function getHandler()
    {
        if (!($this->handler instanceof TcpHandlerInterface)) {
            throw new \RuntimeException("{$handlerClass} type is not 'Mix\Tcp\Handler\TcpHandlerInterface'");
        }
        return $this->handler;
    }

}
