<?php

declare(strict_types=1);

namespace yixinba\Bt;

use Exception;

class Database extends Base
{
    /**
     * 数据库相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 获取数据库列表
        'List' => '/data?action=getData&table=databases',
        // 添加数据库
        'Add' => '/database?action=AddDatabase',
        // 修改数据库账号密码
        'setPassword' => '/database?action=ResDatabasePassword',
        // 删除数据库
        'Delete' => '/database?action=DeleteDatabase',
        // 数据库备份列表
        'Backup' => '/data?action=getData&table=backup',
        // 创建数据库备份
        'ToBackup' => '/database?action=ToBackup',
        // 删除数据库备份
        'DelBackup' => '/database?action=DelBackup',
        // 从备份还原数据库
        'InputSql' => '/database?action=InputSql',
    ];

    /**
     * 获取列表数据
     * 该方法通过HTTP POST请求,使用cookie认证,从指定的URL获取列表数据
     * 主要用于处理数据的分页查询,支持简单的搜索功能
     *
     * @param string $search 搜索关键字,用于过滤列表数据
     * @param int $limit 每页显示的数据条数,用于分页
     * @param int $page 当前页码,用于分页
     *
     * @return mixed|bool 返回请求的结果,可能是数据列表或者其他相关信息;在请求失败时返回false
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
            // 发起HTTP POST请求,并返回请求的结果
            return $this->httpPostCookie($this->getUrl('List'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 添加新的数据库配置信息
     * 
     * 通过此方法可以向系统中添加一个新的数据库配置项.配置项包括数据库的名称、用户名、密码、编码方式、访问权限、地址等信息
     * 默认情况下,访问权限和地址被设置为本地地址(127.0.0.1),编码方式为utf8,数据库类型为MySQL
     * 
     * @param string $name 数据库的名称,用于标识这个数据库配置
     * @param string $username 登录数据库所使用的用户名
     * @param string $password 登录数据库所使用的密码
     * @param string $ps 数据库的备注信息,可选参数,用于记录一些额外的信息
     * @param string $access 数据库的访问权限,默认为本地访问
     * @param string $address 数据库的服务器地址,默认为本地地址
     * @param string $coding 数据库的编码方式,默认为utf8
     * @param string $type 数据库的类型,默认为MySQL
     * @return mixed|bool 如果添加成功,返回http请求的结果;如果添加失败,返回错误信息
     */
    public function add($name, $username, $password, $ps, $access = '127.0.0.1', $address = '127.0.0.1', $coding = 'utf8', $type = 'MySQL')
    {
        // 准备要提交的数据,包括数据库的各个配置项.
        $data = [
            'name' => $name,
            'codeing' => $coding,
            'db_user' => $username,
            'password' => $password,
            'dtype' => $type,
            'dataAccess' => $access,
            'address' => $address,
            'ps' => $ps,
        ];
        try {
            // 尝试通过HTTP POST请求的方式,提交数据并添加到系统中
            return $this->httpPostCookie($this->getUrl('Add'), $data);
        } catch (Exception $e) {
            // 如果在添加过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改账号密码
     * 
     * 本函数通过HTTP POST请求方式,向指定URL发送数据,用于修改账号的密码
     * 请求中包含账号的ID、名称和新密码
     * 如果操作成功,返回相应的结果,否则,捕获异常并返回错误信息
     * 
     * @param int|string $id 账号的ID,可以是整数或字符串,具体取决于系统的标识方式
     * @param string $name 账号的名称,用于标识账号
     * @param string $password 新的密码,用于替换旧密码
     * 
     * @return mixed|bool 如果操作成功,返回HTTP POST请求的结果;如果失败,返回错误信息
     */
    public function setPwd($id, $name, $password)
    {
        // 构建待发送的数据,包含账号ID、名称和新密码
        $data = [
            'id' => $id,
            'name' => $name,
            'password' => $password,
        ];
        try {
            // 尝试通过HTTP POST方法,并携带cookie,发送数据到指定URL来修改密码
            return $this->httpPostCookie($this->getUrl('setPassword'), $data);
        } catch (Exception $e) {
            // 如果在发送请求过程中发生异常,捕获异常并返回异常信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除操作
     * 
     * 本函数执行针对特定ID和名称的删除操作
     * 它首先组装请求数据,然后通过HTTP POST请求带Cookie的方式发送删除请求
     * 如果请求成功,它将返回处理结果;如果请求失败,它将返回错误信息
     * 
     * @param int|string $id 要删除的项的ID.可以是整数或字符串,具体取决于应用的设定
     * @param string $name 要删除的项的名称.名称是字符串类型,用于进一步识别要删除的项
     * @return mixed|bool 如果删除操作成功,返回HTTP POST请求的结果;如果失败,返回错误信息.返回值的类型可以是任何类型,但通常是布尔值或字符串
     */
    public function delete($id, $name)
    {
        // 组装请求的数据,包括ID和名称
        $data = [
            'id' => $id,
            'name' => $name,
        ];
        try {
            // 尝试通过带Cookie的HTTP POST请求发送删除请求到指定URL
            return $this->httpPostCookie($this->getUrl('Delete'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取数据库备份列表
     * 
     * 本函数通过HTTP POST请求方式,向指定URL发送请求,以获取数据库备份列表
     * 请求中包含备份类型、分页信息及搜索条件等参数.成功时返回备份列表数据,失败时返回错误信息
     * 
     * @param string $search 搜索关键字,用于筛选数据库ID包含该关键字的备份
     * @param int $page 当前页码,用于分页查询备份列表
     * @param int $limit 每页显示的备份数量,用于控制分页大小
     * @return mixed|bool 返回备份列表数据,或在请求失败时返回false
     */
    public function getBackups($search = '', $page = 1, $limit = 5)
    {
        // 构建请求参数数组,包括备份类型、分页信息及搜索条件
        $data = [
            'type' => 1,
            'limit' => $limit,
            'p' => $page,
            'search' => $search,
        ];
        try {
            // 发送HTTP POST请求,并返回请求结果
            return $this->httpPostCookie($this->getUrl('Backup'), $data);
        } catch (Exception $e) {
            // 请求发生异常时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建数据库备份
     * 
     * 本函数负责发起一个HTTP POST请求,用于添加数据库备份任务
     * 它通过指定的数据库ID,向服务器发送请求,以期将相应的数据库进行备份
     * 
     * @param int $id 数据库ID
     *          该参数指定需要进行备份的数据库的唯一标识符
     * @return mixed|bool
     *         函数返回值取决于HTTP请求的结果.
     *         成功时,返回HTTP请求的结果;
     *         失败时,返回一个表示错误信息的字符串.
     */
    public function backupAdd($id)
    {
        // 构建待发送的数据,包含数据库ID
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试使用HTTP POST方法,并携带Cookie进行请求,请求的URL用于数据库备份
            return $this->httpPostCookie($this->getUrl('ToBackup'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除数据库备份
     * 
     * 本函数通过发送HTTP POST请求到指定URL,来执行删除数据库备份的操作
     * 请求中包含一个ID参数,该参数用于指定要删除的备份文件
     * 如果操作成功,函数将返回相应的结果;如果操作失败,将返回错误信息
     * 
     * @param int $id 备份文件的唯一标识ID,用于指定要删除的备份文件
     * @return mixed|bool 如果删除操作成功,返回相应的结果;如果失败,返回false,并通过error函数输出错误信息
     */
    public function backupDel($id)
    {
        // 构建待发送的数据,包含要删除的备份文件的ID
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试发送HTTP POST请求,并携带cookie,请求删除备份文件
            return $this->httpPostCookie($this->getUrl('DelBackup'), $data);
        } catch (Exception $e) {
            // 如果在发送请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 从备份文件恢复数据库
     * 
     * 本函数负责通过HTTP POST请求将指定的SQL备份文件导入到指定的数据库中
     * 它首先构造了一个包含备份文件路径和数据库名称的数据数组,然后尝试发送这个数组作为POST请求的参数到服务端的InputSql接口
     * 如果请求成功,函数将返回服务端的响应数据
     * 如果请求失败,函数将捕获抛出的异常,并返回错误信息
     * 
     * @param string $filePath 备份文件的路径.这是本地文件系统中备份文件的路径
     * @param string $databaseName 需要恢复备份的数据库的名称
     * 
     * @return mixed|array|bool 如果请求成功,返回服务端响应的数据;如果请求失败,返回错误信息
     */
    public function inputSql($filePath, $databaseName)
    {
        // 构造请求数据,包括备份文件路径和数据库名称
        $data = [
            'file' => $filePath,
            'name' => $databaseName,
        ];
        try {
            // 尝试发送HTTP POST请求到服务端的ImportSql接口
            return $this->httpPostCookie($this->getUrl('InputSql'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }
}
