<?php
/**
 * 帮助函数
 */
if (! function_exists('psf')) {
    /**
     * 获取一个psf实例
     *
     * @param string $group 分组名
     * @return \Psf\Laravel\Psf;
     */
    function psf($group = '')
    {
        return app('psf')->group($group);
    }
}