<?php

declare(strict_types=1);

namespace yixinba\Bt;

use Exception;

class File extends Base
{
    /**
     * 系统状态相关接口
     *
     * @var string[]
     */
    protected $config = [
        // 上传文件
        'Upload' => '/files?action=upload'
    ];

    /**
     * 上传文件到指定路径
     * 
     * 本函数负责将本地文件上传到服务器指定路径
     * 它首先构造文件相关信息的数组,然后使用HTTP POST方法提交文件
     * 如果上传成功,将返回上传结果;如果上传失败,则返回错误信息
     * 
     * @param string $uploadPath 上传文件的目标路径
     * @param string $localFilePath 本地文件的路径
     * 
     * @return mixed|array|bool 返回上传结果,如果失败返回错误信息
     */
    public function upload($uploadPath, $localFilePath)
    {
        // 通过文件路径获取文件名
        file($localFilePath);
        $fileName = explode('/', $localFilePath);
        // 构造上传文件的信息数组
        $data = [
            'f_path' => $uploadPath,
            'f_name' => end($fileName),
            'f_size' => filesize($localFilePath),
            'f_start' => 0,
            'blob' => new \CURLFile($localFilePath, '', 'blob'),
        ];
        try {
            // 使用HTTP POST方法上传文件,并返回上传结果
            return $this->httpPostCookie($this->getUrl('Upload'), $data, $localFilePath);
        } catch (Exception $e) {
            // 如果上传过程中发生异常,返回错误信息
            return $this->error($e->getMessage());
        }
    }
}
