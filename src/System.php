<?php

declare(strict_types=1);

namespace yixinba\Bt;

use Exception;

class System extends Base
{
    /**
     * 系统状态相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 获取系统基础统计
        'GetSystemTotal' => '/system?action=GetSystemTotal',
        // 获取磁盘分区信息
        'GetDiskInfo' => '/system?action=GetDiskInfo',
        // 获取实时状态信息(CPU、内存、网络、负载)
        'GetNetWork' => '/ajax?action=GetTaskCount',
        // 检查是否有安装任务
        'GetTaskCount' => '/ajax?action=GetTaskCount',
        // 检查面板更新
        'UpdatePanel' => '/ajax?action=UpdatePanel',
        // 获取全局配置
        'GetConfig' => '/config?action=get_config',
    ];

    /**
     * 获取系统基础统计信息
     * 
     * 本函数通过发送HTTP POST请求,使用Cookie认证方式,来获取系统的基础统计数据
     * 主要用于统计和监控系统整体状态,为运维和开发提供数据支持
     * 
     * @return mixed|array|bool
     * 返回值说明：
     * - 成功时返回一个包含系统统计信息的数组
     * - 失败时返回false
     * - 在发生异常时,返回一个包含错误信息的数组
     */
    public function getSystemTotal()
    {
        try {
            // 尝试发送带有Cookie的HTTP POST请求,获取系统统计信息的URL通过getUrl方法获取
            return $this->httpPostCookie($this->getUrl('GetSystemTotal'));
        } catch (Exception $e) {
            // 捕获在请求过程中可能出现的异常,返回错误信息数组
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取磁盘分区信息
     * 
     * 通过发送HTTP POST请求,并携带cookie,来获取服务器端的磁盘分区信息
     * 此方法封装了请求的过程,对外提供了一个简洁的接口
     * 
     * @return mixed|array|bool 返回值可以是多种类型
     * - 如果请求成功,返回一个包含磁盘信息的数组
     * - 如果发生异常,返回false,并通过error方法输出错误信息
     */
    public function getDiskInfo()
    {
        try {
            // 尝试发送带有cookie的HTTP POST请求,获取磁盘信息
            return $this->httpPostCookie($this->getUrl('GetDiskInfo'));
        } catch (Exception $e) {
            // 捕获在请求过程中可能抛出的异常,并处理错误
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网络状态信息
     * 
     * 本函数通过发送HTTP POST请求,并携带Cookie,来获取设备的网络状态信息
     * 主要包括CPU使用率、内存使用情况、网络流量及负载等实时数据
     * 
     * @return mixed|array|bool
     * 返回值可能为数组（包含网络状态信息）,或布尔值（false表示获取失败）
     */
    public function getNetWork()
    {
        try {
            // 尝试发送带有Cookie的HTTP POST请求,以获取网络状态信息
            return $this->httpPostCookie($this->getUrl('GetNetWork'));
        } catch (Exception $e) {
            // 捕获在请求过程中可能抛出的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 通过HTTP POST请求方式获取全局配置信息
     * 
     * 本函数通过发送HTTP POST请求到指定URL来获取全局配置信息
     * 具体请求的URL由getUrl('GetConfig')方法生成.如果请求成功,则返回获取到的配置信息;如果请求失败,则返回错误信息
     * 
     * @return mixed|array|bool 返回配置信息,可能是一个数组或者布尔值
     *                          如果请求成功,返回配置信息数组
     *                          如果请求失败,返回false
     *                          如果发生异常,返回错误信息
     */
    public function GetConfig()
    {
        try {
            // 尝试通过HTTP POST请求方式获取配置信息
            return $this->httpPostCookie($this->getUrl('GetConfig'));
        } catch (Exception $e) {
            // 捕获在请求过程中可能发生的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取待处理任务的数量
     * 
     * 本函数通过发送HTTP POST请求,使用cookie认证,来获取当前用户待处理任务的数量
     * 主要用于任务管理模块,以便用户了解还有多少任务需要处理
     * 
     * @return mixed|array|bool 返回值可以是包含任务数量的数组,或者是由于错误而返回的bool值
     * - 如果请求成功,返回一个数组,数组中包含任务数量等信息
     * - 如果请求失败,返回false,并通过error函数输出错误信息
     */
    public function getTaskCount()
    {
        try {
            // 尝试发送带有cookie的HTTP POST请求,获取任务数量
            return $this->httpPostCookie($this->getUrl('GetTaskCount'));
        } catch (Exception $e) {
            // 捕获在发送请求过程中可能出现的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 检查面板更新
     * 
     * 本函数用于向服务器发送HTTP POST请求,以检查当前面板是否有可用的更新
     * 它通过构造URL并附带必要的Cookie信息来发起请求
     * 如果请求成功,将返回服务器响应的数据,这可能是一个数组或其它类型的混合数据
     * 如果在请求过程中发生异常,函数将捕获异常,并返回一个包含错误信息的数组
     *
     * @return mixed|array|bool 返回类型可以是混合数据、数组或布尔值
     *                          成功时返回服务器响应的数据,失败时返回错误信息数组
     */
    public function checkUpdate()
    {
        try {
            // 尝试通过HTTP POST方法并携带Cookie信息请求更新面板的URL,返回请求的结果
            return $this->httpPostCookie($this->getUrl('UpdatePanel'));
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,捕获异常并返回错误信息数组
            return $this->error($e->getMessage());
        }
    }
}
