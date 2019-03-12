<?php

namespace Mix\Tcp;

use Mix\Core\Component\ComponentInterface;
use Mix\Core\Component\AbstractComponent;

/**
 * Class Registry
 * @package Mix\Tcp
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class Registry extends AbstractComponent
{

    /**
     * 协程模式
     * @var int
     */
    public static $coroutineMode = ComponentInterface::COROUTINE_MODE_REFERENCE;

    /**
     * 处理者
     * @var \Mix\Tcp\Handler\HandlerInterface
     */
    public $handler;

    /**
     * 获取处理器
     * @return \Mix\Tcp\Handler\HandlerInterface
     */
    public function getHandler()
    {
        return $this->handler;
    }

}
