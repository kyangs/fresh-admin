<?php
declare (strict_types=1);

namespace app\repository\file;

/**
 * 管理员
 * Class FileRepository
 * @package app\repository\file
 * @author  kyangs@163.com
 */
abstract class FileRepository
{
    protected $setting;
    /**
     * @param $sourceFile
     * @param string $sourceName
     * @param string $type
     * @return array
     */
    public abstract function upload($sourceFile, $sourceName = '', $type = 'image/jpeg');



}
