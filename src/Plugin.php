<?php

declare(strict_types=1);

namespace yixinba\Bt;

use Exception;

class Plugin extends Base
{
    protected $config = [
        // 获取一键部署列表
        'Deployment' => '/deployment?action=GetList',
        // 一键部署执行
        'SetupPackage' => '/plugin?action=a&name=deployment&s=SetupPackage',
        // 获取部署进度
        'GetSpeed' => '/deployment?action=GetSpeed',
    ];

    /**
     * 获取一键部署列表
     * 
     * 本函数旨在通过HTTP POST请求方式,向指定URL发送包含部署类型信息的数据,以获取一键部署的相关列表信息
     * 如果请求过程中发生异常,将返回错误信息
     *
     * @return mixed|array|bool 返回部署列表的相关信息,可能为数组、布尔值或异常信息
     */
    public function deployment()
    {
        // 初始化部署类型数据
        $data = [
            'type' => 1,
        ];
        try {
            // 尝试发送HTTP POST请求,并返回请求结果
            return $this->httpPostCookie($this->getUrl('Deployment'), $data);
        } catch (Exception $e) {
            // 捕获请求过程中可能出现的异常,并返回异常信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 一键部署执行函数
     * 该函数用于初始化一个部署包的设置并发送请求以执行部署操作
     * 主要用于在给定源名称、站点名称和PHP版本的情况下,通过HTTP POST请求触发部署流程
     *
     * @param string $sourceName 源名称,指定要部署的源代码仓库或包的名称
     * @param string $siteName 站点名称,指定部署后站点的名称
     * @param string $phpVersion PHP版本,指定部署环境使用的PHP版本
     *
     * @return mixed|array|bool 返回部署操作的结果.成功时返回HTTP POST请求的响应数据,失败时返回错误信息
     */
    public function setupPackage($sourceName, $siteName, $phpVersion)
    {
        // 构建请求数据,包含部署所需的源名称、站点名称和PHP版本信息
        $data = [
            'dname' => $sourceName,
            'site_name' => $siteName,
            'php_version' => $phpVersion,
        ];
        try {
            // 发送带有Cookie的HTTP POST请求到指定URL,执行部署操作
            // 请求的URL通过getUrl方法获取,参数为'SetupPackage'
            // 返回部署操作的结果,通常是服务器响应的数据
            return $this->httpPostCookie($this->getUrl('SetupPackage'), $data);
        } catch (Exception $e) {
            // 捕获在发送HTTP请求过程中抛出的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取部署进度
     * 
     * 本函数通过发送HTTP POST请求,并携带cookie信息,来获取部署过程的进度详情
     * 主要用于在部署过程中,实时获取当前部署的状态和进度,以便用户可以了解部署的进展情况
     * 
     * @return mixed|array|bool 返回部署进度的详细信息
     *                          成功时返回一个包含进度信息的数组,失败时返回false,并通过error函数输出错误信息
     */
    public function getSpeed()
    {
        try {
            // 尝试发送带有cookie的HTTP POST请求,获取部署进度信息
            return $this->httpPostCookie($this->getUrl('GetSpeed'));
        } catch (Exception $e) {
            // 捕获在请求过程中可能抛出的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }
}
