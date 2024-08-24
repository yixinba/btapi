<?php

declare(strict_types=1);

namespace yixinba\Bt;

use Exception;

class Site extends Base
{
    /**
     * 网站管理相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 获取网站列表
        'Websites' => '/data?action=getData&table=sites',
        // 获取网站分类
        'WebTypes' => '/site?action=get_site_types',
        // 获取已安装的 PHP 版本列表
        'GetPHPVersion' => '/site?action=GetPHPVersion',
        // 获取指定网站运行的PHP版本
        'GetSitePHPVersion' => '/site?action=GetSitePHPVersion',
        // 修改指定网站的PHP版本
        'SetPHPVersion' => '/site?action=SetPHPVersion',
        // 创建网站
        'AddSite' => '/site?action=AddSite',
        // 删除网站
        'DeleteSite' => '/site?action=DeleteSite',
        // 停用网站
        'StopSite' => '/site?action=SiteStop',
        // 启用网站
        'StartSite' => '/site?action=SiteStart',
        // 设置网站有效期
        'SetExpired' => '/site?action=SetEdate',
        // 修改网站备注
        'SetPs' => '/data?action=setPs&table=sites',
        // 获取网站备份列表
        'WebBackups' => '/data?action=getData&table=backup',
        // 创建网站备份
        'ToBackup' => '/site?action=ToBackup',
        // 删除网站备份
        'DelBackup' => '/site?action=DelBackup',
        // 获取网站域名列表
        'DomainList' => '/data?action=getData&table=domain',
        // 添加网站域名
        'AddDomain' => '/site?action=AddDomain',
        // 删除网站域名
        'DelDomain' => '/site?action=DelDomain',
        // 获取可选的预定义伪静态列表
        'GetRewriteList' => '/site?action=GetRewriteList',
		// 获取当前使用的伪静态内容
        'GetSiteRewrite' => '/site?action=GetSiteRewrite',
		// 设置当前使用的伪静态内容
        'SetSiteRewrite' => '/site?action=SetSiteRewrite',
        // 获取网站根目录
        'WebPath' => '/data?action=getKey&table=sites&key=path',
        // 开启并设置网站密码访问
        'SetHasPwd' => '/site?action=SetHasPwd',
        // 关闭网站密码访问
        'CloseHasPwd' => '/site?action=CloseHasPwd',
        // 获取网站几项开关(防跨站、日志、密码访问)
        'GetDirUserINI' => '/site?action=GetDirUserINI',
        // 获取网站域名绑定二级目录信息
        'GetDirBinding' => '/site?action=GetDirBinding',
        // 添加网站子目录域名
        'AddDirBinding' => '/site?action=AddDirBinding',
        // 删除网站绑定子目录
        'DelDirBinding' => '/site?action=DelDirBinding',
        // 获取网站子目录伪静态规则
        'GetDirRewrite' => '/site?action=GetDirRewrite',
        // 设置网站运行目录
        'SetSiteRunPath' => '/site?action=SetSiteRunPath',
        // 获取网站日志
        'GetSiteLogs' => '/site?action=GetSiteLogs',
        // 获取网站盗链状态及规则信息
        'GetSecurity' => '/site?action=GetSecurity',
        // 设置网站盗链状态及规则信息
        'SetSecurity' => '/site?action=SetSecurity',
        // 获取SSL状态及证书详情
        'GetSSL' => '/site?action=GetSSL',
        // 强制HTTPS
        'HttpToHttps' => '/site?action=HttpToHttps',
        // 关闭强制HTTPS
        'CloseToHttps' => '/site?action=CloseToHttps',
        // 设置SSL证书
        'SetSSL' => '/site?action=SetSSL',
        // 续签SSL证书
        'RenewCert' => '/acme?action=renew_cert',
        // 设置 Let's Encrypt 证书
        'ApplyCertApi' => '/acme?action=apply_cert_api',
        // 关闭SSL
        'CloseSSLConf' => '/site?action=CloseSSLConf',
        // 获取网站默认文件
        'GetIndex' => '/site?action=GetIndex',
        // 设置网站默认文件
        'SetIndex' => '/site?action=SetIndex',
        // 获取网站流量限制信息
        'GetLimitNet' => '/site?action=GetLimitNet',
        // 设置网站流量限制信息
        'SetLimitNet' => '/site?action=SetLimitNet',
        // 关闭网站流量限制
        'CloseLimitNet' => '/site?action=CloseLimitNet',
        // 获取网站301重定向信息
        'Get301Status' => '/site?action=Get301Status',
        // 设置网站301重定向信息
        'Set301Status' => '/site?action=Set301Status',
        // 获取网站反代信息及状态
        'GetProxyList' => '/site?action=GetProxyList',
        // 添加网站反代信息
        'CreateProxy' => '/site?action=CreateProxy',
        // 修改网站反代信息
        'ModifyProxy' => '/site?action=ModifyProxy',
        // 获取指定预定义伪静态规则内容(获取文件内容)
        'GetFileBody' => '/files?action=GetFileBody',
        // 保存伪静态规则内容(保存文件内容)
        'SaveFileBody' => '/files?action=SaveFileBody',		
		// 获取网站重定向列表
        'GetRedirectList' => '/site?action=GetRedirectList',
		// 更新网站重定向
        'ModifyRedirect' => '/site?action=ModifyRedirect',
		// 添加网站重定向
        'CreateRedirect' => '/site?action=CreateRedirect',
		// 删除网站重定向
        'DeleteRedirect' => '/site?action=DeleteRedirect',
		// 获取重定向配置文件内容
        'GetRedirectFile' => '/site?action=GetRedirectFile',
		// 保存重定向配置文件内容
        'SaveRedirectFile' => '/site?action=SaveRedirectFile',
		
    ];

    /**
     * 获取网站列表
     * 
     * 本函数用于从服务器获取网站列表的数据.支持通过搜索关键字、分页、分类和排序规则来筛选和组织数据
     * 主要用于前端展示或进一步的数据处理
     * 
     * @param string $search 搜索关键字,用于筛选包含特定字符串的网站
     * @param int $page 当前页码,用于分页显示数据
     * @param int $limit 每页显示的数据条数,用于控制分页的显示数量
     * @param string $type 网站分类标识,用于筛选特定分类的网站.-1表示获取所有分类的网站,0表示默认分类
     * @param string $order 排序规则,用于指定数据的显示顺序.默认按照网站ID降序排列
     * 
     * @return mixed 返回获取的网站列表数据,如果发生异常,则返回错误信息
     */
    public function getList($search = '', $page = 1, $limit = 200, $type = '-1', $order = 'id desc')
    {
        // 构建请求参数数组,包括搜索关键字、页码、每页数量、分类标识和排序规则
        $data = [
            'search' => $search,
            'p' => $page,
            'limit' => $limit,
            'type' => $type,
            'order' => $order,
            'table' => 'sites',
        ];
        try {
            // 发起HTTP POST请求,并携带Cookie,请求网站列表数据.
            // 请求的URL由getUrl方法生成,具体取决于服务器的配置.
            return $this->httpPostCookie($this->getUrl('Websites'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息.
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站分类
     * 
     * 通过HTTP POST请求并使用cookie获取网站的分类信息
     * 此方法封装了对网站分类请求的处理,包括请求的发送和错误的处理
     * 
     * @return mixed 返回获取到的网站分类信息,如果发生异常,则返回错误信息
     */
    public function getSiteTypes()
    {
        try {
            // 尝试通过HTTP POST方法并使用cookie获取网站分类信息
            return $this->httpPostCookie($this->getUrl('WebTypes'));
        } catch (Exception $e) {
            // 捕获在请求过程中可能发生的异常,并返回异常信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取已安装的PHP版本列表
     * 
     * 本方法通过发送HTTP POST请求来获取服务器上已安装的PHP版本信息
     * 使用cookie作为请求的一部分,以确保请求的合法性
     * 如果请求成功,将返回PHP版本信息;如果请求失败,将返回错误信息
     * 
     * @return mixed 返回已安装的PHP版本信息字符串,或在错误时返回错误信息
     */
    public function getPHPVersion()
    {
        try {
            // 尝试通过HTTP POST请求并携带cookie来获取PHP版本信息
            return $this->httpPostCookie($this->getUrl('GetPHPVersion'));
        } catch (Exception $e) {
            // 在请求过程中发生异常时,返回异常的错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取指定网站运行的PHP版本
     * 
     * 通过HTTP POST请求向指定URL发送数据,以获取指定网站的PHP版本信息
     * 此方法主要用于与远程服务交互,获取指定网站的PHP版本
     * 
     * @param string $siteName 网站的名称,用于指定要查询PHP版本的网站
     * @return mixed 返回获取到的PHP版本信息,如果发生异常,则返回错误信息
     */
    public function getSitePHPVersion($siteName)
    {
        // 构建请求数据,包含要查询的网站名称
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发送HTTP POST请求,并携带Cookie,以获取网站的PHP版本信息
            return $this->httpPostCookie($this->getUrl('GetSitePHPVersion'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改指定网站的PHP版本
     * 
     * 本函数通过发送HTTP POST请求来设置指定网站的PHP版本
     * 使用cookie进行身份验证,确保只有授权用户可以执行此操作
     * 
     * @param string $siteName 网站的名称,用于识别要修改PHP版本的网站
     * @param string $version 指定要设置的PHP版本号
     * 
     * @return mixed 如果请求成功,返回HTTP响应;如果请求失败,返回错误信息
     */
    public function SetPHPVersion($siteName, $version)
    {
        // 构建请求数据
        $data = [
            'siteName' => $siteName,
            'version' => $version
        ];
        try {
            // 发送HTTP POST请求,并返回响应
            return $this->httpPostCookie($this->getUrl('SetPHPVersion'), $data);
        } catch (Exception $e) {
            // 处理请求过程中发生的异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建一个新的网站
     * 
     * 本函数通过接收一系列参数来创建一个新的网站,包括网站名称、路径、备注、PHP版本等
     * 它还支持创建FTP账户和数据库,并可以指定数据库字符集
     * 
     * @param string $webName 网站主域名和域名列表,以JSON格式传入
     * @param string $path 网站的根目录路径
     * @param string $ps 网站的备注信息
     * @param string $version PHP版本号
     * @param bool $ftp 是否创建FTP账户
     * @param string $ftpUsername FTP账户的用户名
     * @param string $ftpPassword FTP账户的密码
     * @param string $sql 是否创建MySQL数据库
     * @param string $coding 数据库的字符集,可选值为utf8|utf8mb4|gbk|big5
     * @param string $dataUser 数据库用户的用户名
     * @param string $dataPassword 数据库用户的密码
     * @param int $type_id 网站的类型ID
     * @param string $port 网站监听的端口号
     * 
     * @return mixed|array|bool 返回创建结果,可能是HTTP请求返回的数据,也可能是错误信息
     */
    public function add($webName, $path, $ps = '', $version = '', $sql = 'MySQL', $coding = 'utf8', $dataUser = '', $dataPassword = '', $ftp = false, $ftpUsername = '', $ftpPassword = '', $type_id = 0, $port = '80')
    {
        // 准备创建网站的数据,包括JSON格式的域名信息、路径、类型、版本等
        $data = [
            'webname' => json_encode([
                'domain' => $webName,
                'domainlist' => [],
                'count' => 0,
            ]),
            'path' => $path,
            'type_id' => $type_id,
            'type' => 'PHP',
            'version' => $version,
            'port' => $port,
            'ps' => $ps,
            'ftp' => $ftp,
            'ftp_username' => $ftpUsername,
            'ftp_password' => $ftpPassword,
            'sql' => $sql,
            'codeing' => $coding,
            'datauser' => $dataUser,
            'datapassword' => $dataPassword,
        ];
        try {
            // 发送HTTP POST请求,带有cookie,目标是创建新网站的URL
            return $this->httpPostCookie($this->getUrl('AddSite'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除网站
     * 
     * 本函数用于删除指定的网站及其相关资源,如FTP和数据库
     * 根据参数的不同,可以选择性地删除关联的FTP账户、数据库以及网站目录
     * 
     * @param int $id 网站ID,用于唯一标识要删除的网站.
     * @param string $webname 网站名称,作为删除操作的另一项确认标识
     * @param int $ftp 是否删除关联的FTP账户,1表示删除,其他值表示不删除
     * @param int $database 是否删除关联的数据库,1表示删除,其他值表示不删除
     * @param int $path 是否删除网站目录,1表示删除,其他值表示不删除
     * 
     * @return mixed|array|bool 返回值取决于删除操作的结果.成功时返回HTTP请求的结果,失败时返回错误信息
     */
    public function delete($id, $webname, $ftp = 1, $database = 1, $path = 1)
    {
        // 网站ID和网站名称是删除操作的必要信息
        $data = compact('id', 'webname');
        // 根据参数设置是否删除FTP、数据库和网站目录
        if ($ftp >= 1) {
            $data['ftp'] = 1;
        }
        if ($database >= 1) {
            $data['database'] = 1;
        }
        if ($path >= 1) {
            $data['path'] = 1;
        }
        // 尝试通过HTTP POST请求执行删除操作,如果发生异常,则返回错误信息
        try {
            return $this->httpPostCookie($this->getUrl('DeleteSite'), $data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 停用网站
     * 
     * 本函数用于停用指定ID和名称的网站
     * 它通过HTTP POST请求向服务器发送停用指令,并携带网站的ID和名称作为数据
     * 如果请求成功,函数将返回服务器的响应数据
     * 如果请求失败,函数将返回错误信息
     * 
     * @param int $id 网站的唯一标识ID,用于确定要停用的网站
     * @param string $name 网站的名称,作为辅助标识停用的网站
     * @return mixed|array|bool 返回类型为混合型,可能是服务器的响应数组,也可能是布尔值false表示失败
     */
    public function stop($id, $name)
    {
        // 组装传递给服务器的数据,包含网站的ID和名称
        $data = compact('id', 'name');
        try {
            // 尝试通过HTTP POST方法发送停用请求,并携带cookie
            // 请求的URL由getUrl('StopSite')方法生成
            return $this->httpPostCookie($this->getUrl('StopSite'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 启动指定网站
     * 
     * 本函数旨在通过发送HTTP POST请求来启动一个指定的网站
     * 它首先将网站ID和名称打包到一个数组中,然后尝试性发送这个请求
     * 如果请求成功,它将返回请求的结果;如果请求失败,它将返回错误信息
     * 
     * @param int $id 网站的唯一标识符.这个标识符用于确定要启动哪个网站
     * @param string $name 网站的名称.名称用于人类可读的标识,可能在某些情况下用于验证或显示
     * 
     * @return mixed|array|bool 如果请求成功,返回HTTP POST请求的结果;如果请求失败,返回错误信息
     */
    public function start($id, $name)
    {
        // 将网站ID和名称组合成一个数组
        $data = compact('id', 'name');
        try {
            // 尝试发送HTTP POST请求来启动网站,并返回结果
            return $this->httpPostCookie($this->getUrl('StartSite'), $data);
        } catch (Exception $e) {
            // 如果在发送请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站的到期时间
     * 
     * 本函数通过HTTP POST请求向指定URL发送数据,以更新网站的到期日期
     * 如果操作成功,将返回处理结果;如果发生异常,则返回错误信息
     * 
     * @param int $id 网站的唯一标识ID,用于确定要更新的网站
     * @param string $expired 网站的到期日期,默认为'0000-00-00'表示永久有效
     * 
     * @return mixed|array|bool 返回处理结果,可能是一个数组、布尔值或异常信息
     */
    public function setExpired($id, $expired = '0000-00-00')
    {
        // 构建待发送的数据,包含网站ID和到期日期
        $data = [
            'id' => $id,
            'edate' => $expired,
        ];
        try {
            // 尝试通过HTTP POST方法,并携带cookie发送数据到指定URL
            return $this->httpPostCookie($this->getUrl('SetExpired'), $data);
        } catch (Exception $e) {
            // 如果在发送请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改网站备注信息
     * 
     * 通过此方法可以更新指定网站的备注信息.它首先构造一个包含网站ID和新备注信息的数据数组
     * 然后尝试使用HTTP POST请求带有Cookie的方式发送该数据到指定的URL,以更新备注信息
     * 如果请求成功,它将返回处理结果;如果请求失败,它将返回错误信息
     * 
     * @param int $id 网站的唯一标识ID,用于指定要修改备注信息的网站
     * @param string $remark 新的备注内容,用于更新网站的当前备注信息
     * @return mixed|array|bool 返回值可以是多种类型
     *                          成功时可能是一个数组或者其它类型的结果
     *                          失败时则返回一个包含错误信息的数组
     */
    public function setRemark($id, $remark)
    {
        // 构造请求数据,包含网站ID和新的备注信息
        $data = [
            'id' => $id,
            'ps' => $remark,
        ];
        try {
            // 尝试使用HTTP POST请求并携带Cookie来提交数据,返回处理结果
            return $this->httpPostCookie($this->getUrl('SetPs'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息数组
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站备份列表
     * 
     * 该方法用于请求当前网站的备份列表.支持分页和根据网站ID进行搜索
     * 主要通过HTTP POST方式向指定URL发送请求,并携带必要的参数以获取备份列表数据
     * 
     * @param string $id 网站ID,用于搜索特定网站的备份列表
     * @param int $page 分页页码,默认为1,用于获取指定页码的备份列表
     * @param int $limit 分页条数,默认为5,用于指定每页返回的备份数量
     * 
     * @return mixed|array|bool 返回备份列表的数据.成功时返回备份列表的数组,失败时返回错误信息
     */
    public function getBackupList($id, $page = 1, $limit = 5)
    {
        // 构建请求参数数组,包括备份类型、分页信息和搜索条件
        $data = [
            'type' => 0,
            'limit' => $limit,
            'p' => $page,
            'search' => $id,
        ];
        try {
            // 发起HTTP POST请求,并携带cookie,请求备份列表的数据
            return $this->httpPostCookie($this->getUrl('WebBackups'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 创建网站备份
     * 
     * 本函数用于发起一个HTTP POST请求,以创建指定网站的备份
     * 它首先构造了一个包含网站ID的数据数组,然后尝试性发送这个请求
     * 如果请求成功,它将返回请求的结果;如果请求失败,则返回错误信息
     * 
     * @param int $id 网站的唯一标识符.这个ID用于确定要创建备份的网站
     * @return mixed|array|bool 返回值可以是多种类型：
     *                          成功时返回HTTP POST的响应数据(数组形式);
     *                          失败时返回一个包含错误信息的数组;在异常情况下返回false
     */
    public function addBackup($id)
    {
        // 构造请求的数据,包含网站ID
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试使用HTTP POST方法,并携带cookie,发送备份请求到指定URL
            return $this->httpPostCookie($this->getUrl('ToBackup'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除网站备份
     * 
     * 本函数通过HTTP POST请求向服务器发送指令,删除指定ID的网站备份
     * 使用cookie作为身份验证,确保只有授权用户可以执行此操作
     * 
     * @param int $id 备份文件的唯一标识符.此ID用于精确指定要删除的备份文件
     * @return mixed|array|bool 函数返回值取决于操作的结果
     *                          - 成功时,返回一个包含操作结果信息的数组
     *                          - 失败时,返回false,并可通过调用getError方法获取错误信息
     */
    public function deleteBackup($id)
    {
        // 构建待发送的数据,包含要删除的备份文件的ID
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试发送HTTP POST请求,使用cookie进行身份验证,并指定删除备份的URL
            // 如果请求成功,将返回服务器响应的数据
            return $this->httpPostCookie($this->getUrl('DelBackup'), $data);
        } catch (Exception $e) {
            // 如果在发送请求过程中发生异常,捕获异常并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站域名列表
     * 
     * 通过HTTP POST请求向指定URL发送数据,以获取指定网站ID的域名列表
     * 此函数封装了请求过程,包括处理可能的异常
     * 
     * @param int $id 网站的唯一标识ID,用于查询特定网站的域名列表
     * @return mixed|array|bool 返回值可以是数组(包含域名列表)、布尔值(请求失败)或错误信息
     */
    public function getDomainList($id)
    {
        // 构建请求数据,包含搜索标识和请求列表数据的标志
        $data = [
            'search' => $id,
            'list' => true
        ];
        try {
            // 尝试执行HTTP POST请求,并带上Cookie,返回处理结果
            return $this->httpPostCookie($this->getUrl('DomainList'), $data);
        } catch (Exception $e) {
            // 捕获请求过程中可能出现的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 添加网站域名
     * 该方法用于向系统中添加一个新的网站域名
     * 它通过HTTP POST请求向指定的URL发送数据,以添加域名信息
     * 
     * @param int $id 网站ID,用于标识要添加域名的网站
     * @param string $name 网站名称,提供网站的直观名称
     * @param string $domains 域名列表,多个域名可以用换行符分隔,且可以指定端口
     * 
     * @return mixed|array|bool 返回值取决于HTTP请求的结果.成功时可能返回一个数组,失败时返回false,异常情况下返回错误信息
     */
    public function addDomain($id, $name, $domains)
    {
        // 准备要发送的数据,包括网站ID、名称和域名列表
        $data = [
            'id' => $id,
            'webname' => $name,
            'domain' => $domains,
        ];
        try {
            // 尝试通过HTTP POST方法,并使用cookie进行身份验证,来发送数据到指定URL
            // 如果成功,将返回处理结果
            return $this->httpPostCookie($this->getUrl('AddDomain'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,捕获异常并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除网站域名
     * 
     * 本函数通过发送HTTP POST请求到指定URL,来删除一个网站的域名配置
     * 请求中包含网站的ID、名称、域名和端口信息
     * 如果操作成功,将返回处理结果,否则将返回错误信息
     * 
     * @param int $id 网站的唯一标识ID,用于确定要删除的网站
     * @param string $name 网站的名称,作为删除操作的一部分信息
     * @param string $domain 要删除的网站的域名
     * @param int $port 网站使用的端口号,默认为80,表示HTTP协议的默认端口
     * 
     * @return mixed|array|bool 如果删除成功,返回HTTP POST请求的结果;如果删除失败,返回错误信息
     */
    public function deleteDomain($id, $name, $domain, $port = 80)
    {
        // 构建要发送的数据,包含网站的ID、名称、域名和端口
        $data = [
            'id' => $id,
            'webname' => $name,
            'domain' => $domain,
            'port' => $port,
        ];
        try {
            // 发送HTTP POST请求,并带上cookies,请求删除指定的域名
            // 返回操作的结果
            return $this->httpPostCookie($this->getUrl('DelDomain'), $data);
        } catch (Exception $e) {
            // 如果在发送请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取可选的预定义伪静态列表
     * 
     * 本函数旨在通过HTTP POST请求,获取指定网站的伪静态规则列表
     * 这些规则通常是一组预定义的模式,用于将动态URL转换为静态或伪静态形式
     * 
     * @param string $siteName 网站名称,用于指定要获取伪静态规则的网站
     * @return mixed|array|bool 返回值可以是数组(包含伪静态规则列表),或者是布尔值(表示操作失败)
     *                          如果操作成功,返回的数组中将包含指定网站的伪静态规则列表
     *                          如果操作失败,将返回false,并通过错误函数输出错误信息
     */
    public function getRewriteList($siteName)
    {
        // 构建请求数据,包含网站名称
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发起HTTP POST请求,并携带cookie,请求获取伪静态规则列表的URL
            return $this->httpPostCookie($this->getUrl('GetRewriteList'), $data);
        } catch (Exception $e) {
            // 捕获请求过程中可能出现的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }

/**
     * 获取当前网站的伪静态内容
     * 
     * 
     * @param string $siteName 网站名称,用于指定要获取伪静态规则的网站
     * @return data bool  		返回值是data(伪静态规则内容),布尔值(表示操作成功或失败)
     *                          如果操作成功,返回的数组中将包含指定网站的伪静态规则内容
     *                          如果操作失败,将返回false,并通过错误函数输出错误信息
     */
    public function GetSiteRewrite($siteName)
    {
        // 构建请求数据,包含网站名称
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发起HTTP POST请求,并携带cookie,请求获取伪静态规则列表的URL
            return $this->httpPostCookie($this->getUrl('GetSiteRewrite'), $data);
        } catch (Exception $e) {
            // 捕获请求过程中可能出现的异常,并返回错误信息
            return $this->error($e->getMessage());
        }
    }

	
	/**
	 * 设置当前网站的伪静态内容
	 * @param string $siteName 网站名称,用于指定要设置伪静态规则的网站
	 * @param string $content 规则内容,即要写入到配置文件中的伪静态规则
     * @return bool 返回值是布尔值(表示操作失败) 
	 */
    public function SetSiteRewrite($siteName,$content)
    {
        // 构建请求数据
        $data = [
            'siteName' => $siteName,
			'data' => $content,
        ];
        try {
            // 发送HTTP POST请求,并返回响应
            return $this->httpPostCookie($this->getUrl('SetSiteRewrite'), $data);
        } catch (Exception $e) {
            // 处理请求过程中发生的异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
	 * 设置网站运行目录
	 * @param [type] $id 网站ID
	 */
    public function SetSiteRunPath($id,$runPath)
    {
        // 构建请求数据
        $data = [
            'id' => $id,
            'runPath' => $runPath
        ];
        try {
            // 发送HTTP POST请求,并返回响应
            return $this->httpPostCookie($this->getUrl('SetSiteRunPath'), $data);
        } catch (Exception $e) {
            // 处理请求过程中发生的异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    

    /**
     * 通过HTTP POST请求获取指定网站的根目录
     * 
     * 本函数旨在通过发送HTTP POST请求,使用cookie认证,来获取指定网站的根目录路径
     * 这对于需要知道网站基础路径的场景非常有用,比如文件上传、链接生成等
     * 
     * @param int $id 网站的唯一标识ID,用于定位特定网站
     * @return mixed|array|bool 返回值可以是多种类型
     * - 成功时,返回一个包含根目录信息的数组
     * - 失败时,返回false或者一个包含错误信息的数组
     * 
     * 注意：本函数内部使用了try-catch块来处理可能的异常,确保了函数的健壮性
     */
    public function getRoot(int $id)
    {
        // 准备请求的数据,包含网站的ID
        $data = [
            'id' => $id,
        ];
        try {
            // 发送HTTP POST请求,并带上cookie,请求获取网站根目录的URL
            return $this->httpPostCookie($this->getUrl('WebPath'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置密码访问网站
     * 
     * 本函数用于为指定的网站ID设置访问密码
     * 通过发送HTTP POST请求,将网站ID、用户名和密码封装在请求体中,发送到服务器端进行设置
     * 如果设置成功,服务器将返回相应的结果;如果设置失败,则会捕获异常并返回错误信息
     * 
     * @param int $id 网站ID,用于标识需要设置密码的网站
     * @param string $username 设置的用户名,用于网站的登录认证
     * @param string $password 设置的密码,与用户名一起用于网站的登录认证
     * 
     * @return mixed|array|bool 返回值取决于服务器的响应
     * - 成功时可能返回一个数组或其它类型的数据
     * - 失败时会返回一个包含错误信息的数组
     */
    public function setHasPwd($id, $username, $password)
    {
        // 准备请求数据,包括网站ID、用户名和密码
        $data = [
            'id' => $id,
            'username' => $username,
            'password' => $password,
        ];
        try {
            // 发送HTTP POST请求,带有Cookie,目标是服务器的SetHasPwd接口
            // 返回值取决于服务器的响应,可能是数组、对象等
            return $this->httpPostCookie($this->getUrl('SetHasPwd'), $data);
        } catch (Exception $e) {
            // 捕获在发送请求过程中可能出现的异常,返回错误信息数组
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭密码访问网站
     * 
     * 本函数通过发送HTTP POST请求来关闭指定网站的密码保护功能
     * 它首先构造一个包含网站ID的数据数组,然后尝试发送这个请求
     * 如果请求成功,它将返回处理结果;如果请求失败,它将返回错误信息
     * 
     * @param int $id 网站的唯一标识符.用于指定哪个网站的密码保护功能需要关闭
     * @return mixed|array|bool 如果请求成功,返回处理结果;如果请求失败,返回错误信息
     */
    public function closeHasPwd($id)
    {
        // 构造请求数据
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试发送HTTP POST请求,并返回结果
            return $this->httpPostCookie($this->getUrl('CloseHasPwd'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取指定网站的日志信息
     * 
     * 通过HTTP POST方式向服务器请求获取指定网站的日志数据
     * 使用cookie进行身份验证和会话管理
     * 
     * @param string $siteName 网站的名称,用于指定要获取日志的网站
     * @return mixed|array|bool 返回日志数据数组,如果请求失败则返回错误信息
     */
    public function getSiteLogs($siteName)
    {
        // 构建请求数据,包含网站名称
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发送HTTP POST请求,获取网站日志数据
            return $this->httpPostCookie($this->getUrl('GetSiteLogs'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站防盗链状态及规则信息
     * 
     * 本函数通过发送HTTP POST请求来获取指定网站的防盗链状态和规则信息
     * 请求发送到一个由getUrl方法生成的URL,该URL用于特定的防盗链查询操作
     * 请求包含两个参数：id和name,它们一起用于唯一标识目标网站
     * 
     * @param string $id 网站的唯一标识ID,用于查询防盗链状态和规则
     * @param string $name 网站的名称,作为查询防盗链信息的辅助参数
     * 
     * @return mixed|array|bool 返回值可以是多种类型：
     * - 如果请求成功,返回一个包含防盗链状态和规则信息的数组
     * - 如果请求失败,返回一个包含错误信息的数组
     * - 在异常情况下,返回false
     */
    public function getSecurity($id, $name)
    {
        // 准备请求的数据,包括网站的ID和名称
        $data = [
            'id' => $id,
            'name' => $name,
        ];
        try {
            // 发送HTTP POST请求,并携带准备好的数据,请求的URL由getUrl方法生成
            // 方法返回的值是处理请求后得到的响应数据
            return $this->httpPostCookie($this->getUrl('GetSecurity'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回一个包含异常信息的错误数组
            return $this->error($e->getMessage());
        }
    }

     /**
     * 设置网站防盗链配置
     * 
     * 本函数用于配置网站的防盗链设置,包括设置网站ID、网站名称、文件后缀、允许的域名和状态
     * 通过发送HTTP POST请求来提交这些配置到指定的URL,以更新网站的防盗链规则
     * 如果请求成功,将返回处理结果,否则将返回错误信息
     * 
     * @param int $id 网站的唯一标识ID,用于识别不同的网站
     * @param string $name 网站的名称,用于友好显示
     * @param string $fix 网站支持的文件后缀,用于限制防盗链的文件类型
     * @param string $domains 允许访问该网站的域名列表,以逗号分隔
     * @param int $status 防盗链的状态,通常为启用或禁用
	 * @param int $return_rule 404 
	 * @param int $none 允许空HTTP_REFERER请求的状态,通常为启用或禁用
     * 
     * @return mixed|array|bool 根据请求结果返回不同的值,可能是处理结果的数组、错误信息的数组或布尔值FALSE
     */
    public function setSecurity($id, $name, $fix, $domains, $status, $return_rule, $none)
    {
        // 构建请求数据
        $data = [
            'id' => $id,
            'name' => $name,
            'fix' => $fix,
            'domains' => $domains,
            'status' => $status,
	    'return_rule' => $return_rule,
            'none' => $none,
        ];
        try {
            // 发送HTTP POST请求,并返回结果
            return $this->httpPostCookie($this->getUrl('SetSecurity'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 通过HTTP POST请求获取指定网站目录的用户配置信息
     * 
     * 本函数旨在获取特定网站ID和运行目录对应的用户配置信息
     * 包含网站ID和运行目录路径到指定的URL,来获取配置信息
     * 如果请求成功,将返回配置信息,否则将返回错误信息
     * 
     * @param int $id 网站ID,用于识别特定的网站
     * @param string $path 网站的运行目录路径,用于定位配置文件
     * @return mixed|array|bool 返回获取的配置信息,如果失败则返回错误信息
     */
    public function getDirUserINI($id, $path)
    {
        // 构建请求数据
        $data = [
            'id' => $id,
            'path' => $path,
        ];
        try {
            // 发送HTTP POST请求,并返回结果
            return $this->httpPostCookie($this->getUrl('GetDirUserINI'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 将HTTP请求转换为HTTPS请求
     * 
     * 本函数用于强制将指定网站的HTTP请求重定向到HTTPS,以确保通信过程的安全性
     * 它通过发送一个HTTP POST请求到服务端接口来实现这个功能
     * 
     * @param string $siteName 网站的域名,不包含协议部分(例如,www.example.com)
     * @return mixed|array|bool 如果请求成功,返回服务端响应的数据;如果请求失败,返回错误信息
     */
    public function httpToHttps($siteName)
    {
        // 构建请求数据
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发送HTTP POST请求,并带有Cookie信息
            return $this->httpPostCookie($this->getUrl('HttpToHttps'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭强制HTTPS跳转
     * 
     * 本函数用于向服务端发送请求,以关闭指定站点的HTTPS强制跳转设置
     * 当站点不再需要强制HTTPS访问时,可以调用此函数进行配置更改
     * 
     * @param string $siteName 站点名称,仅包含域名,不包含协议头和路径
     * @return mixed|array|bool 返回值依情况而定,可能是HTTP请求的结果,也可能是错误信息
     */
    public function closeToHttps($siteName)
    {
        // 构建请求数据
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 尝试使用HTTP POST方法并携带Cookie进行请求
            return $this->httpPostCookie($this->getUrl('CloseToHttps'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置SSL域名证书
     * 
     * 本函数用于配置SSL证书相关的详细信息,并通过HTTP POST请求提交这些信息
     * 主要用于在支持SSL证书的平台上,为指定的网站域名设置或更新SSL证书
     * 
     * @param int $type 证书类型,表示不同类型的SSL证书
     * @param string $siteName 网站的域名,即证书将要绑定的域名
     * @param string $key 证书的私钥,用于生成或匹配证书
     * @param string $csr 证书签名请求,即CSR文件,用于生成证书
     * 
     * @return mixed|array|bool 返回值取决于请求的结果
     *                          成功时,返回一个包含请求结果的数组
     *                          失败时,返回一个包含错误信息的字符串
     *                          如果发生异常,返回false
     */
    public function setSSL($type, $siteName, $key, $csr)
    {
        // 构建包含证书信息的数组
        $data = [
            'type' => $type,
            'siteName' => $siteName,
            'key' => $key,
            'csr' => $csr,
        ];
        try {
            // 发送HTTP POST请求,携带证书信息,请求设置SSL证书
            // URL通过getUrl方法获取,该方法返回设置SSL证书的具体URL
            return $this->httpPostCookie($this->getUrl('SetSSL'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 续签 SSL 证书
     * 
     * 本函数用于发起续签 SSL 证书的请求
     * 它通过发送一个包含证书索引信息的HTTP POST请求来完成续签操作
     * 如果请求成功,它将返回处理结果;如果请求失败,则会返回错误信息
     * 
     * @param string $index 证书索引号,用于标识需要续签的证书
     * 
     * @return mixed|array|bool 返回值可以是多种类型
     * - 成功时,返回一个包含续签结果的数组
     * - 失败时,返回一个包含错误信息的数组
     * - 如果发生异常,返回false
     */
    public function renewCert($index)
    {
        // 构建请求数据,包含需要续签的证书的索引号.
        $data = [
            'index' => $index,
        ];
        try {
            // 发起HTTP POST请求,使用cookie认证,目标URL为续签证书的接口
            // 返回值是处理结果的数组
            return $this->httpPostCookie($this->getUrl('RenewCert'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息的数组
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭SSL配置
     * 
     * 本函数用于关闭指定站点的SSL加密配置
     * 通过向服务端发送HTTP POST请求来实现,如果操作成功,将返回相关数据,否则将返回错误信息
     * 
     * @param int $updateOf 修改操作的标识,用于指示具体的修改行为
     * @param string $siteName 站点的名称,不包含协议部分,如"http://"
     * 
     * @return mixed|array|bool 如果操作成功,返回服务端响应的数据;如果失败,返回错误信息
     */
    public function closeSSLConf($updateOf, $siteName)
    {
        // 构建请求的数据
        $data = [
            'updateOf' => $updateOf,
            'siteName' => $siteName,
        ];
        try {
            // 尝试发送HTTP POST请求来关闭SSL配置,并返回响应数据
            return $this->httpPostCookie($this->getUrl('CloseSSLConf'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取指定网站的SSL状态及证书信息
     * 
     * 本函数通过发送HTTP POST请求,获取指定网站的SSL证书详细信息
     * 主要用于检测网站是否启用了SSL,并获取相关证书信息,以评估网站的安全性
     * 
     * @param string $siteName 域名,不包含协议部分(如http://或https://),仅提供域名本身
     * @return mixed|array|bool 如果请求成功,返回一个包含SSL信息的数组;如果请求失败,返回false;在异常情况下,返回错误信息
     */
    public function getSSL($siteName)
    {
        // 构建请求数据,包含要查询的域名
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发送HTTP POST请求,并返回请求结果
            return $this->httpPostCookie($this->getUrl('GetSSL'), $data);
        } catch (Exception $e) {
            // 在请求过程中发生异常时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置 Let's Encrypt 证书
     * 
     * 本函数用于申请 Let's Encrypt 的免费 SSL 证书
     * 它通过指定的网站ID和域名
     * 向服务器发送请求以获取证书
     * 如果请求成功,函数将返回证书申请的相关信息,否则将返回错误信息
     * 
     * @param int $id 网站ID,用于标识证书申请对应的网站
     * @param string $domain 需要申请证书的域名,不包含协议和端口
     * 
     * @return mixed|array|bool 返回值可以是数组(申请成功的证书信息)、布尔值(false表示申请失败)或其他类型
     */
    public function getApplyCertApi($id = 0, $domain = '')
    {
        // 构建请求数据,包含域名、认证方式、认证目标ID等信息
        $data = [
            'domains' => [$domain],
            'auth_type' => 'http',
            'auth_to' => $id,
            'auto_wildcard' => 0,
            'id' => $id,
        ];
        try {
            // 尝试通过 HTTP POST 方法并使用 Cookie 认证发送请求来申请证书
            return $this->httpPostCookie($this->getUrl('ApplyCertApi'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站默认文件
     * 
     * 本函数通过HTTP POST请求向指定URL发送数据,以获取网站的默认文件信息
     * 主要用于处理网站配置或内容获取等场景,具体用途依赖于请求的URL和返回的数据结构
     * 
     * @param int $id 网站ID,用于标识特定的网站,ID的具体含义和使用方式取决于应用场景
     * 
     * @return mixed|array|bool 返回值可以是多种类型,具体取决于请求的结果
     * - 如果请求成功,可能会返回一个数组,数组中包含有请求成功后的数据
     * - 如果请求失败,会返回一个错误信息的字符串
     * - 在异常情况下,可能会返回布尔值false,表示请求过程中发生了异常或错误
     */
    public function GetIndex($id)
    {
        // 构建请求数据,包含网站ID
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试使用HTTP POST方法,并携带Cookie进行请求,请求的URL由getUrl方法返回
            // 如果请求成功,直接返回请求的结果
            return $this->httpPostCookie($this->getUrl('GetIndex'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,捕获异常并返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站默认文件
     * 
     * 本函数用于通过HTTP POST请求设置指定网站的默认首页文件
     * 它首先构造一个包含网站ID和指定首页文件名的数据数组,然后尝试使用httpPostCookie方法发送这个请求
     * 如果请求成功,它将返回相应的结果数据;
     * 如果请求失败,它将返回一个包含错误信息的数组
     * 
     * @param int $id 网站ID,用于标识要设置默认首页的网站
     * @param string $index 指定的默认首页文件名
     * @return mixed|array|bool 返回设置结果.成功时为HTTP POST返回的数据,失败时为错误信息数组
     */
    public function SetIndex($id, $index)
    {
        // 构造请求数据
        $data = [
            'id' => $id,
            'Index' => $index,
        ];
        try {
            // 尝试发送HTTP POST请求并返回结果
            return $this->httpPostCookie($this->getUrl('SetIndex'), $data);
        } catch (Exception $e) {
            // 请求失败时返回错误信息数组
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站流量限制信息
     * 
     * 通过HTTP POST请求向指定URL发送数据,以获取特定网站的流量限制信息
     * 此函数主要用于与外部服务进行通信,获取关于网站流量限制的详细数据
     * 
     * @param int $id 网站的唯一标识ID,用于指定要查询的网站
     * @return mixed|array|bool 返回值可以是多种类型：成功时返回一个包含流量限制信息的数组
     *                          失败时,返回一个包含错误信息的数组;在发生异常时,返回false
     */
    public function getLimitNet($id)
    {
        // 构建请求数据,包含要查询的网站ID
        $data = [
            'id' => $id,
        ];
        try {
            // 发送HTTP POST请求,并携带cookie,请求流量限制信息
            return $this->httpPostCookie($this->getUrl('GetLimitNet'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站流量限制信息
     * 
     * 通过此方法可以对指定网站的流量进行限制设置,包括并发限制、单IP限制和流量速率限制
     * 这些设置有助于控制网站的访问量和流量,以确保网站的稳定运行和资源的合理利用
     * 
     * @param int $id 网站ID,用于标识要设置流量限制的网站
     * @param string $perserver 并发限制,指定每个服务器允许的并发连接数
     * @param string $perip 单IP限制,指定每个IP地址允许的并发连接数
     * @param string $limit_rate 流量限制,指定网站的流量速率限制
     * 
     * @return mixed|array|bool 返回设置结果.成功时返回HTTP POST请求的结果,失败时返回错误信息
     */
    public function setLimitNet($id, $perserver, $perip, $limit_rate)
    {
        // 构建请求数据
        $data = [
            'id' => $id,
            'perserver' => $perserver,
            'perip' => $perip,
            'limit_rate' => $limit_rate,
        ];
        try {
            // 发送HTTP POST请求,并返回结果
            return $this->httpPostCookie($this->getUrl('SetLimitNet'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 关闭网站流量限制
     * 
     * 本函数用于发送请求以关闭指定网站的流量限制
     * 通过向服务端发送HTTP POST请求,并携带指定网站的ID作为参数,来实现关闭操作
     * 如果请求成功,函数将返回处理结果,否则将返回错误信息
     * 
     * @param int $id 网站ID,用于指定需要关闭流量限制的网站
     * 
     * @return mixed|array|bool 返回值取决于请求的结果
     * 成功时,返回服务端响应的数据;失败时,返回包含错误信息的数组
     */
    public function closeLimitNet(int $id)
    {
        // 构建请求数据,包含网站ID.
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试发送HTTP POST请求,并携带cookie,请求关闭流量限制
            return $this->httpPostCookie($this->getUrl('CloseLimitNet'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站301重定向状态
     * 
     * 本函数通过发送HTTP POST请求,获取指定网站的301重定向状态信息
     * 主要用于检查网站是否正确设置了301重定向,以确保URL重定向的正确性和SEO友好性
     * 
     * @param string $siteName 网站的名称或域名,用于构建请求的URL
     * @return mixed|array|bool 返回值可以是数组(包含重定向状态信息),或者是布尔值(表示请求失败)
     *                          如果请求成功,数组中将包含关于301重定向的详细信息
     */
    public function get301Status($siteName)
    {
        // 构建请求数据,包含网站名称
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发送HTTP POST请求,并携带cookie,请求获取301重定向状态
            // 使用getUrl方法获取请求的URL
            return $this->httpPostCookie($this->getUrl('Get301Status'), $data);
        } catch (Exception $e) {
            // 请求失败时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站301重定向信息
     * 
     * 本函数用于配置指定网站的301重定向规则,将来自旧域名的请求重定向到新域名
     * 这对于搜索引擎优化(SEO)和维护网站链接的统一性非常重要
     * 
     * @param string $siteName 网站名称,用于标识需要配置重定向的网站
     * @param string $toDomain 目标域名,即重定向请求应该被转发到的域名
     * @param string $srcDomain 源域名,即请求原本应该到达的旧域名
     * @param int $type 重定向类型,通常为301,表示永久重定向
     * 
     * @return mixed|array|bool 根据操作结果返回不同的值,可能是HTTP请求的结果、错误信息或布尔值
     */
    public function set301Status($siteName, $toDomain, $srcDomain, $type)
    {
        // 构建请求数据
        $data = [
            'siteName' => $siteName,
            'toDomain' => $toDomain,
            'srcDomain' => $srcDomain,
            'type' => $type,
        ];
        try {
            // 发送HTTP POST请求,带Cookie,用于身份验证和请求的完整性
            return $this->httpPostCookie($this->getUrl('Set301Status'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }
	
	
	/**
     * 获取网站重定向列表
     * @param [type] $siteName 网站名
     */
    public function GetRedirectList($siteName){
		
		// 构建请求数据
        $data = [
            'sitename' => $siteName,           
        ];
        try {
            // 发送HTTP POST请求,带Cookie,用于身份验证和请求的完整性
            return $this->httpPostCookie($this->getUrl('GetRedirectList'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 更新网站重定向
     * @param array
     * @return string
     */
    public function ModifyRedirect($sitename,$redirectname,$tourl,$redirectdomain,$redirectpath,$redirecttype,$type,$domainorpath,$holdpath){
		// 构建请求数据
        $data = [
            'sitename' => $sitename,   
			'redirectname' => $redirectname,
			'tourl' => $tourl,
			'redirectdomain' => $redirectdomain,
			'redirectpath' => $redirectpath,
			'redirecttype' => $redirecttype,
			'type' => $type,
			'domainorpath' => $domainorpath,
			'holdpath' => $holdpath,		
        ];
		if(is_array($data['redirectdomain'])){
            $data['redirectdomain'] = json_encode($data['redirectdomain']);
        }
        try {
            // 发送HTTP POST请求,带Cookie,用于身份验证和请求的完整性
            return $this->httpPostCookie($this->getUrl('ModifyRedirect'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }
		


    /**
     * 添加网站重定向 
     * @param array
     * @return string
     */
    public function CreateRedirect($sitename,$redirectname,$tourl,$redirectdomain,$redirectpath,$redirecttype,$type,$domainorpath,$holdpath){
        // 构建请求数据
        $data = [
            'sitename' => $sitename,   
			'redirectname' => $redirectname,
			'tourl' => $tourl,
			'redirectdomain' => $redirectdomain,
			'redirectpath' => $redirectpath,
			'redirecttype' => $redirecttype,
			'type' => $type,
			'domainorpath' => $domainorpath,
			'holdpath' => $holdpath,		
        ];
		if(is_array($data['redirectdomain'])){
            $data['redirectdomain'] = json_encode($data['redirectdomain']);
        }
        try {
            // 发送HTTP POST请求,带Cookie,用于身份验证和请求的完整性
            return $this->httpPostCookie($this->getUrl('CreateRedirect'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }	


    /**
     * 删除网站重定向
     * @param $sitename
     * @param $redirectname
     * @return string
     */
    public function DeleteRedirect($sitename, $redirectname){
		
		// 构建请求数据
        $data = [
            'sitename' => $sitename,   
			'redirectname' => $redirectname,
        ];
        try {
            // 发送HTTP POST请求,带Cookie,用于身份验证和请求的完整性
            return $this->httpPostCookie($this->getUrl('DeleteRedirect'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取重定向配置文件内容
     * @param $sitename
     * @param $redirectname
     * @param string $webserver
     * @return string
     */
    public function GetRedirectFile($sitename,$redirectname,$webserver='nginx'){
		// 构建请求数据
        $data = [
            'sitename' => $sitename,   
			'redirectname' => $redirectname,
			'webserver' => $webserver,
        ];
        try {
            // 发送HTTP POST请求,带Cookie,用于身份验证和请求的完整性
            return $this->httpPostCookie($this->getUrl('GetRedirectFile'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 保存重定向配置文件内容
     * @param [type] $path     规则名
     * @param [type] $datas     规则内容
     * @param string $encoding 规则编码强转utf-8
     */
    public function SaveRedirectFile($path,$datas,$encoding=''){
		// 构建请求数据
        $data = [
            'path' => $path,   
			'data' => $datas,
			'encoding' => $encoding?$encoding:'utf-8'
        ];
        try {
            // 发送HTTP POST请求,带Cookie,用于身份验证和请求的完整性
            return $this->httpPostCookie($this->getUrl('SaveRedirectFile'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }
	

	
    /**
     * 获取指定网站的代理服务器列表
     * 
     * 本函数通过向服务端发送HTTP POST请求,来获取指定网站的代理服务器列表
     * 请求中包含网站名称作为参数,服务端根据该名称返回相应的代理服务器信息
     * 如果请求成功,返回代理服务器列表的数据;如果请求失败,则返回错误信息
     * 
     * @param string $siteName 网站的名称,用于指定需要获取代理服务器列表的网站
     * @return mixed|array|bool 返回值可以是数组(包含代理服务器信息)、布尔值(请求失败)或错误信息
     */
    public function getProxyList($siteName)
    {
        // 构建请求数据,包含网站名称
        $data = [
            'siteName' => $siteName,
        ];
        try {
            // 发送HTTP POST请求,并返回请求结果
            return $this->httpPostCookie($this->getUrl('GetProxyList'), $data);
        } catch (Exception $e) {
            // 请求发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 添加网站反向代理配置
     * 该方法用于向系统中添加一个新的网站反向代理配置
     * 通过指定各种参数,如缓存设置、代理名称、目标域名等,来创建一个代理配置
     * 完成后,将通过HTTP POST请求提交此配置
     *
     * @param int $cache 是否启用缓存,1为启用,0为不启用
     * @param string $proxyname 代理配置的名称
     * @param string $cachetime 缓存的时间,单位为小时
     * @param string $proxydir 代理目录,指定哪些目录下的请求需要通过代理访问
     * @param string $proxysite 反向代理的URL地址
     * @param string $todomain 需要进行反向代理的目标域名
     * @param string $advanced 是否开启高级选项,如代理目录等
     * @param string $sitename 网站的名称
     * @param string $subfilter 文本替换的规则,以JSON格式表示
     * @param int $type 代理配置的类型,1表示开启,0表示关闭
     *
     * @return mixed|array|bool 返回添加结果,可能是布尔值表示成功或失败,也可能是包含错误信息的数组,或者是一个成功的响应数组
     */
    public function createProxy($cache, $proxyname, $cachetime, $proxydir, $proxysite, $todomain, $advanced, $sitename, $subfilter, $type)
    {
        // 构建请求数据
        $data = [
            'cache' => $cache,
            'proxyname' => $proxyname,
            'cachetime' => $cachetime,
            'proxydir' => $proxydir,
            'proxysite' => $proxysite,
            'todomain' => $todomain,
            'advanced' => $advanced,
            'sitename' => $sitename,
            'subfilter' => $subfilter,
            'type' => $type,
        ];
        try {
            // 发送HTTP POST请求来添加代理配置,并返回响应结果
            return $this->httpPostCookie($this->getUrl('CreateProxy'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改网站反向代理设置
     * 该方法用于通过HTTP POST请求更新网站的反向代理配置
     * 配置包括缓存设置、代理名称、缓存时间、代理目录、代理站点、目标域名等信息
     * 
     * @param int $cache 是否启用缓存,0表示关闭,1表示开启
     * @param string $proxyname 代理名称,用于标识这个代理配置
     * @param string $cachetime 缓存时间,单位为小时
     * @param string $proxydir 代理目录,指定哪些目录下的请求需要通过代理访问
     * @param string $proxysite 代理站点的URL,即请求被代理到的站点地址
     * @param string $todomain 目标域名,指定将请求的域名重定向到的目标域名
     * @param string $advanced 是否开启高级选项,用于开启一些额外的代理配置功能
     * @param string $sitename 网站名称,代理配置所应用的网站名称
     * @param string $subfilter 文本替换规则,以JSON格式指定需要进行文本替换的规则
     * @param int $type 是否启用代理,0表示关闭,1表示开启
     * 
     * @return mixed|array|bool 返回操作的结果,可能是HTTP请求的响应数据,也可能是错误信息
     */
    public function modifyProxy($cache, $proxyname, $cachetime, $proxydir, $proxysite, $todomain, $advanced, $sitename, $subfilter, $type)
    {
        // 构建请求数据
        $data = [
            'cache' => $cache,
            'proxyname' => $proxyname,
            'cachetime' => $cachetime,
            'proxydir' => $proxydir,
            'proxysite' => $proxysite,
            'todomain' => $todomain,
            'advanced' => $advanced,
            'sitename' => $sitename,
            'subfilter' => $subfilter,
            'type' => $type,
        ];
        try {
            // 发送HTTP POST请求,并返回响应结果
            return $this->httpPostCookie($this->getUrl('ModifyProxy'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站域名绑定二级目录信息
     * 
     * 通过HTTP POST请求向指定URL发送数据,以获取特定网站的域名绑定二级目录信息
     * 此函数主要用于处理与网站域名绑定相关的请求,对于理解和维护网站的域名配置至关重要
     * 
     * @param int $id 网站ID,用于识别特定的网站
     * @return mixed|array|bool 返回值可以是包含域名绑定信息的数组,或者是HTTP请求失败时的错误信息
     */
    public function getDirBinding($id)
    {
        // 构建请求数据,包含要查询的网站ID
        $data = [
            'id' => $id,
        ];
        try {
            // 发送HTTP POST请求,并携带cookie,返回处理结果
            return $this->httpPostCookie($this->getUrl('GetDirBinding'), $data);
        } catch (Exception $e) {
            // 请求异常时,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置网站域名绑定二级目录
     * 该函数用于向服务器发送请求,以绑定一个网站的域名到特定的二级目录
     * 这是通过发送一个HTTP POST请求来完成的,请求中包含必要的绑定信息
     *
     * @param int $id 网站ID,用于识别要绑定的网站
     * @param string $domain 要绑定的域名
     * @param string $dirName 二级目录的名称,域名将绑定到这个目录
     *
     * @return mixed|array|bool 函数返回值取决于请求的结果
     *                          如果请求成功,可能会返回一个包含服务器响应的数据数组
     *                          如果请求失败,将返回一个包含错误信息的数组
     *                          在异常情况下,可能会直接返回false
     */
    public function addDirBinding($id, $domain, $dirName)
    {
        // 准备绑定信息的数据数组
        $data = [
            'id' => $id,
            'domain' => $domain,
            'dirName' => $dirName,
        ];
        try {
            // 尝试使用HTTP POST方法,并携带cookie发送绑定请求到服务器
            // 请求的URL由getUrl方法根据操作类型'AddDirBinding'构造
            return $this->httpPostCookie($this->getUrl('AddDirBinding'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,返回一个包含错误信息的数组
            return $this->error($e->getMessage());
        }
    }

    /**
     * 删除网站域名绑定的二级目录
     * 
     * 本函数通过HTTP POST请求向指定URL发送数据,以删除一个特定的二级目录绑定
     * 这是与网站域名管理相关的操作,旨在提供一种方式来解除域名与二级目录的绑定关系
     * 
     * @param int $id 绑定的二级目录的ID.这个ID用于唯一标识待删除的目录绑定
     * @return mixed|array|bool 函数可能返回多种类型的结果
     *                          - 成功时,返回一个HTTP响应数组
     *                          - 失败时,返回一个包含错误信息的数组
     *                          - 在发生异常时,返回false
     */
    public function delDirBinding($id)
    {
        // 构造请求数据,包含待删除的二级目录的ID
        $data = [
            'id' => $id,
        ];
        try {
            // 尝试发送HTTP POST请求,并返回响应结果
            return $this->httpPostCookie($this->getUrl('DelDirBinding'), $data);
        } catch (Exception $e) {
            // 捕获异常,返回错误信息数组
            return $this->error($e->getMessage());
        }
    }

    /**
     * 获取网站子目录绑定伪静态信息
     * 
     * 本函数通过发送HTTP POST请求,获取指定ID的网站子目录的伪静态绑定信息
     * 如果$type被指定为非0值,请求中将包含额外的参数表示需要添加新的绑定
     * 
     * @param int $id 网站子目录的ID,用于识别特定的子目录
     * @param int $type 用于指定操作类型,0表示查询,非0值表示添加新的绑定
     * @return mixed|array|bool 返回值可以是包含伪静态信息的数组,或者是HTTP请求失败时的错误信息
     */
    public function getDirRewrite($id, $type = 0)
    {
        // 准备请求的数据,包括子目录的ID
        $data = [
            'id' => $id,
        ];
        // 如果$type不为0,表示需要添加新的绑定,此时在数据中加入相应的标识
        if ($type) {
            $data['add'] = 1;
        }
        try {
            // 发送HTTP POST请求,并返回请求的结果
            return $this->httpPostCookie($this->getUrl('GetDirRewrite'), $data);
        } catch (Exception $e) {
            // 如果请求过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 通过HTTP POST请求获取指定文件的内容
     * 
     * 本函数旨在通过发送HTTP POST请求,使用cookie认证,来获取指定文件的主体内容
     * 主要用于处理需要通过网络获取的文件内容,例如从远程服务器下载文件
     * 
     * @param string $path 文件的路径,可以是相对路径或者绝对路径
     *                     该路径指定了要获取内容的文件的位置
     * @return mixed|array|bool 返回文件的内容.如果请求成功,将返回文件的主体内容
     *                          如果发生异常,将返回错误信息的数组
     *                          在请求失败的情况下,返回false
     */
    public function getFileBody($path)
    {
        // 构建请求数据,包含文件路径信息
        $data = [
            'path' => $path,
        ];
        try {
            // 发送HTTP POST请求,使用cookie认证,并返回文件内容
            return $this->httpPostCookie($this->getUrl('GetFileBody'), $data);
        } catch (Exception $e) {
            // 捕获请求过程中可能出现的异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }

    /**
     * 设置文件内容
     * 
     * 通过HTTP POST请求将指定内容写入到文件中
     * 此方法封装了文件内容设置的流程,包括构建请求数据和处理可能的异常
     * 
     * @param string $path 文件路径.指定要写入内容的文件的路径
     * @param string $content 要写入文件的内容.指定文件的新内容
     * 
     * @return mixed|array|bool 返回值取决于HTTP请求的结果
     * 成功时可能返回一个数组或布尔值,失败时会返回错误信息的数组
     */
    public function setFileBody($path, $content)
    {
        // 构建请求数据,包括文件路径、内容和编码方式
        $data = [
            'path' => $path,
            'data' => $content,
            'encoding' => 'utf-8',
        ];
        try {
            // 尝试通过HTTP POST方法发送请求来保存文件内容
            // 使用内部方法`httpPostCookie`发送请求,并传入保存文件内容的URL和构建的请求数据
            return $this->httpPostCookie($this->getUrl('SaveFileBody'), $data);
        } catch (Exception $e) {
            // 如果在请求过程中发生异常,捕获异常并返回错误信息
            // 使用内部方法`error`处理异常并返回错误信息的数组
            return $this->error($e->getMessage());
        }
    }
}
