<?php

declare(strict_types=1);

namespace yixinba\Bt;

use yixinba\Bt\Exceptions\BtException;

class Base
{
    protected $config;
    protected $btPanel;
    protected $btKey;
    protected $cookiePath;
    protected $error;
    /**
     * 构造函数用于初始化类的实例
     * 
     * 本构造函数用于初始化与某外部面板的连接,该面板可能是用于管理或控制某种服务或系统的界面
     * 参数包括访问该面板的URL、用于鉴权的接口密钥,以及保存cookie的路径
     * 这些参数是建立连接所必需的,它们将被用于后续的通信和数据交换
     * 
     * @param string $panel 访问外部面板的URL,用于建立连接
     * @param string $key 接口密钥,用于身份验证和数据加密
     * @param string $cookiePath 保存cookie的路径,用于会话管理
     * @return $this 返回类的实例,支持链式调用
     */
    public function __construct($panel, $key, $cookiePath)
    {
        $this->btPanel = $panel;
        $this->btKey = $key;
        $this->cookiePath = $cookiePath;
    }

    /**
     * 设置访问面板的URL
     * 
     * 该方法用于配置访问后台管理面板的URL地址.通过调用此方法,可以将指定的URL地址
     * 关联到后台管理面板,以便在后续操作中使用
     * 
     * @param string $host 面板的URL地址
     * @return $this 返回当前对象,支持链式调用
     */
    public function panel($host)
    {
        // 设置后台管理面板的URL
        $this->btPanel = $host;
        // 返回当前对象,支持链式调用
        return $this;
    }

    /**
     * 设置接口密钥
     * 
     * 本函数用于设置与外部接口交互时所需的密钥
     * 该密钥通常用于认证调用者身份,确保数据的安全性和完整性.调用者可以通过传递密钥来表明其具有访问特定资源或执行特定操作的权限
     * 
     * @param string $key 接口密钥,用于认证和授权
     * @return $this 返回当前对象实例,支持链式调用
     */
    public function key($key)
    {
        $this->btKey = $key;
        return $this;
    }

    /**
     * 设置错误信息并返回失败标志
     * 
     * 本函数用于内部错误处理,当遇到不符合预期的情况时,设置一个错误信息
     * 错误信息作为参数传递给函数,函数将其存储起来以备后续可能的错误检查或日志记录
     * 函数始终返回false,以向调用者指示操作未成功完成
     * 
     * @param string $errorMsg 错误描述,具体说明了遇到的错误性质
     * @return bool 始终返回false,表示操作失败
     */
    protected function error($errorMsg): bool
    {
        $this->error = $errorMsg;
        return false;
    }

    /**
     * 获取错误信息
     * 
     * 本方法用于返回最后一次操作中产生的错误信息.如果不存在错误,返回值可能为空
     * 通过调用此方法,可以获取错误详情,以便于错误处理或用户提示
     * 
     * @return mixed 返回错误信息.如果没有错误,可能返回null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 获取带请求令牌和请求时间的数据数组
     * 
     * 本函数用于在给定的数据数组中添加两个额外的字段;请求令牌(request_token)和请求时间(request_time)
     * 请求令牌是基于当前时间戳和一个预定义的密钥(btKey)通过MD5算法生成的,用于确保请求的安全性和唯一性
     * 请求时间记录了数据请求的发生时间,以时间戳形式存储
     * 
     * @param array $data 原始数据数组
     * @return array 包含原始数据、请求令牌和请求时间的新数据数组
     */
    private function getData($data)
    {
        // 获取当前时间戳
        $time = time();
        // 合并原始数据数组和新增的请求令牌、请求时间字段
        return array_merge($data, [
            'request_token' => md5($time . '' . md5($this->btKey)),
            'request_time'  => $time,
        ]);
    }

    /**
     * 根据键获取配置URL
     * 
     * 此方法用于从存储的配置数组中检索指定键对应的URL
     * 配置数组在类的初始化过程中被加载,允许快速访问预先定义的URL
     * 
     * @param string $key 配置数组中的键,对应特定的URL
     * @return string 返回与键相关联的URL
     */
    protected function getUrl($key)
    {
        return $this->config[$key];
    }

    /**
     * 通过cURL发送带有cookie的POST请求
     * 
     * 本函数用于向指定URL发送带有POST数据和cookie的HTTP请求
     * 主要用于在与BT面板的通信中,确保会话的连续性和数据的完整性
     * 
     * @param string $url 请求的URL地址
     * @param array $data POST请求的数据数组
     * @param int $timeout 请求的超时时间(秒)
     * @return mixed 返回解码后的JSON响应数据,如果请求失败则抛出异常
     * 
     * @throws BtException 如果BT面板或BT键不配置正确,则抛出特定异常
     * @throws \Exception 如果curl执行失败或返回内容无法解析为JSON,则抛出通用异常
     */
    public function httpPostCookie($url, $data = [], $timeout = 60)
    {
        // 检查BT面板和BT键的配置是否正确
        if (!$this->btPanel) {
            throw new BtException(101);
        }
        if (!$this->btKey) {
            throw new BtException(102);
        }
        // 定义[cookie]文件的路径和名称,用于存储和发送cookie
        $cookieFile = join(DIRECTORY_SEPARATOR, [
            $this->cookiePath,
            'bt',
            sha1($this->btPanel) . '.cookie'
        ]);

        // 初始化cURL会话
        $ch = curl_init();
        // 配置cURL选项,包括URL、超时时间、请求类型、POST数据、cookie处理等
        curl_setopt($ch, CURLOPT_URL, $this->btPanel . $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getData($data));
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 执行cURL请求
        $output = curl_exec($ch);
        // 关闭cURL会话
        curl_close($ch);
        // 检查请求是否成功,处理响应数据
        if ($output !== false) {
            // 尝试将输出解析为JSON,如果成功则返回解析后的数组,否则直接返回原始输出
            if (is_array($output)) {
                $result = $output;
            } else {
                $result = json_decode($output, true);
            }
            return $result;
        } else {
            // 如果请求失败,抛出异常
            throw new \Exception('返回内容解析失败');
        }
    }
}
