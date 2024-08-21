<?php

declare(strict_types=1);

namespace yixinba\Bt;

use Exception;

class Ftp extends Base
{
    /**
     * 系统状态相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 获取FTP信息列表
        'List' => '/data?action=getData&table=ftps',
        // 修改FTP账号密码
        'SetUserPassword' => '/ftp?action=SetUserPassword',
        // 启用/禁用FTP
        'SetStatus' => '/ftp?action=SetStatus',
        // 删除FTP
        'DeleteUser' => '/ftp?action=DeleteUser',
    ];

    /**
     * 获取FTP文件列表
     * 
     * 本函数通过HTTP POST方式向指定URL发送请求,以获取FTP服务器上的文件列表
     * 请求中包含搜索关键词、每页的文件数量以及请求的页码等信息
     * 如果请求成功,将返回文件列表的数据;如果请求失败,则返回错误信息
     * 
     * @param string $search 搜索关键词,用于过滤文件列表,默认为空,表示不进行搜索过滤
     * @param int $limit 每页显示的文件数量,默认为20条
     * @param int $page 请求的页码,默认为第1页
     * 
     * @return mixed|array|bool 返回文件列表的数据,如果请求失败则返回错误信息
     */
    public function getList($search = '', $page = 1, $limit = 20)
    {
        // 构建请求参数
        $data = [
            'search' => $search,
            'limit' => $limit,
            'p' => $page,
        ];
        try {
            // 发送HTTP POST请求,并返回响应结果
            return $this->httpPostCookie($this->getUrl('List'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改FTP账号密码
     * 
     * 通过HTTP POST请求向指定URL发送数据,以修改FTP用户的密码
     * 此函数主要用于处理FTP用户密码的修改逻辑,它封装了密码修改的细节,调用者只需要提供用户ID、用户名和新密码即可
     * 
     * @param int $id 用户ID,用于识别要修改密码的FTP用户
     * @param string $username 用户名,与新密码一起发送以验证用户身份
     * @param string $password 新密码,待设置的FTP用户密码
     * 
     * @return mixed|array|bool 返回值取决于HTTP POST请求的结果.成功时,返回HTTP请求的结果;失败时,返回错误信息
     */
    public function setUserPwd($id, $username, $password)
    {
        // 构建待发送的数据,包含用户ID、用户名和新密码
        $data = [
            'id' => $id,
            'ftp_username' => $username,
            'new_password' => $password,
        ];
        try {
            // 尝试使用HTTP POST方法,并携带Cookie发送数据到指定URL,以修改FTP用户的密码
            return $this->httpPostCookie($this->getUrl('SetUserPassword'), $data);
        } catch (Exception $e) {
            // 如果在发送HTTP请求过程中发生异常,捕获异常并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置FTP用户的启用或禁用状态
     *
     * 本函数通过发送HTTP POST请求来更新FTP用户的激活状态
     * 请求包含用户的ID、用户名和新的状态(启用或禁用)
     * 如果请求成功,它将返回处理结果;如果发生异常,它将返回错误信息
     *
     * @param int $id FTP用户的唯一标识ID
     * @param string $username FTP用户的用户名
     * @param int $status 用户的状态,0表示禁用,1表示启用
     * @return mixed|array|bool 返回处理结果,可能是HTTP请求的响应、错误信息或布尔值
     */
    public function setStatus($id, $username, $status)
    {
        // 构建待发送的数据,包含用户ID、用户名和新状态
        $data = [
            'id' => $id,
            'username' => $username,
            'status' => $status,
        ];
        try {
            // 尝试发送HTTP POST请求,并返回结果
            return $this->httpPostCookie($this->getUrl('SetStatus'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除FTP
     *
     * 本函数用于执行用户删除操作
     * 它通过发送一个带有用户ID和用户名的HTTP POST请求到指定的URL来实现
     * 如果请求成功,它将返回处理结果;如果请求失败,它将返回错误信息
     *
     * @param int $id 用户ID,用于唯一标识用户
     * @param string $username 用户名,作为用户的身份标识
     *
     * @return mixed|array|bool 返回值可以是多种类型;成功时可能是一个数组或布尔值,失败时返回错误信息的数组
     */
    public function delete($id, $username)
    {
        // 构建待发送的数据,包含用户ID和用户名
        $data = [
            'id' => $id,
            'username' => $username,
        ];
        try {
            // 尝试发送HTTP POST请求,并携带cookie,请求删除用户
            return $this->httpPostCookie($this->getUrl('DeleteUser'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }
}
