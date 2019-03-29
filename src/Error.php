<?php

namespace Mix\Tcp;

use Mix\Core\Component\AbstractComponent;
use Mix\Core\Component\ComponentInterface;
use Mix\Helper\JsonHelper;

/**
 * Class Error
 * @package Mix\Tcp
 * @author liu,jian <coder.keda@gmail.com>
 */
class Error extends AbstractComponent
{

    /**
     * 协程模式
     * @var int
     */
    public static $coroutineMode = ComponentInterface::COROUTINE_MODE_REFERENCE;

    /**
     * 错误级别
     * @var int
     */
    public $level = E_ALL;

    /**
     * 异常处理
     * @param $e
     */
    public function handleException($e)
    {
        // 错误参数定义
        $statusCode = $e instanceof \Mix\Exception\NotFoundException ? 404 : 500;
        $errors     = [
            'status'  => $statusCode,
            'code'    => $e->getCode(),
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'type'    => get_class($e),
            'trace'   => $e->getTraceAsString(),
        ];
        // 日志处理
        if (!($e instanceof \Mix\Exception\NotFoundException)) {
            self::log($errors);
        }
        // 发送客户端
        self::send($errors);
        // 关闭连接
        self::close($errors);
    }

    /**
     * 写入日志
     * @param $errors
     */
    protected static function log($errors)
    {
        // 构造消息
        $message = <<<EOL
{message}
[type] {type} [code] {code}
[file] {file} [line] {line}
[trace] {trace}
EOL;
        // 写入
        $level = \Mix\Core\Error::getLevel($errors['code']);
        switch ($level) {
            case 'error':
                \Mix::$app->log->error($message);
                break;
            case 'warning':
                \Mix::$app->log->warning($message);
                break;
            case 'notice':
                \Mix::$app->log->notice($message);
                break;
        }
    }

    /**
     * 发送客户端
     * @param $errors
     */
    protected static function send($errors)
    {
        if (!\Mix::$app->isRunning('tcp')) {
            return;
        }
        $errors['trace'] = explode("\n", $errors['trace']);
        $statusCode      = $errors['status'];
        if (!\Mix::$app->appDebug) {
            if ($statusCode == 404) {
                $errors = [
                    'status'  => 404,
                    'message' => $errors['message'],
                ];
            }
            if ($statusCode == 500) {
                $errors = [
                    'status'  => 500,
                    'message' => '服务器内部错误',
                ];
            }
        }
        $data = JsonHelper::encode($errors);
        \Mix::$app->tcp->send($data);
    }

    /**
     * 关闭连接
     * @param $errors
     */
    protected static function close($errors)
    {
        if (\Mix::$app->isRunning('tcp')) {
            \Mix::$app->tcp->disconnect();
        }
    }

}
