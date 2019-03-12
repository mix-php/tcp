<?php

namespace Mix\Tcp\Handler;

use Mix\Tcp\TcpConnection;

/**
 * Interface HandlerInterface
 * @package Mix\Tcp\Handler
 * @author LIUJIAN <coder.keda@gmail.com>
 */
interface HandlerInterface
{

    /**
     * 开启连接
     * @param TcpConnection $tcp
     */
    public function connect(TcpConnection $tcp);

    /**
     * 处理消息
     * @param TcpConnection $tcp
     * @param string $data
     */
    public function receive(TcpConnection $tcp, string $data);

    /**
     * 连接关闭
     * @param TcpConnection $tcp
     */
    public function close(TcpConnection $tcp);

}
