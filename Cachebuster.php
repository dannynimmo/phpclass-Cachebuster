<?php

namespace DannyNimmo;

class Cachebuster
{

    const ERROR_FILE_DOESNT_EXIST = 'File `%s` does not exist.';

    private $file_root;
    private $web_root;

    public function setFileRoot($file_root) {
        $this->file_root = rtrim($file_root, ' /') . '/';
        return $this;
    }

    public function setWebRoot($web_root) {
        $this->web_root = rtrim($web_root, ' /') . '/';
        return $this;
    }

    public function getUrl($file) {
        $file = ltrim($file, ' /');
        $full_file = $this->file_root . $file;
        if (!file_exists($full_file)) {
            throw new \Exception(sprintf(self::ERROR_FILE_DOESNT_EXIST, $full_file));
        } else {
            $url_path = substr($file, 0, strrpos($file, '.') + 1);
            $modification_time = filemtime($full_file);
            $file_extension = substr($file, strrpos($file, '.'));
            $cachebusted_file = $this->web_root . $url_path . $modification_time . $file_extension;
            return $cachebusted_file;
        }
    }

}
