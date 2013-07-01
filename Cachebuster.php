<?php

namespace DannyNimmo;

class Cachebuster
{

    const ERROR_FILE_DOESNT_EXIST = 'File `%s` does not exist.';

    private $file_root;
    private $web_root;

    /**
     * Allows for variables to be set upon construction.
     * @param array $options 
     * @return type
     */
    public function __construct($options = null) {
        if(isset($options->file_root)){
            $this->setFileRoot($options->file_root);
        }

        if(isset($options->web_root)){
            $this->setWebRoot($options->web_root);
        }

        return $this;
    }

    /**
     * Set the file root
     * @param string $file_root 
     * @return type
     */
    public function setFileRoot($file_root) {
        $this->file_root = rtrim($file_root, ' /') . '/';
        return $this;
    }

    /**
     * Set the web root
     * @param string $web_root 
     * @return type
     */
    public function setWebRoot($web_root) {
        $this->web_root = rtrim($web_root, ' /') . '/';
        return $this;
    }

    /**
     * Returns the cache busted URL based unpon last modification time.
     * @param type $file 
     * @return type
     */
    public function getUrl($file) {
        $file = ltrim($file, ' /');
        $full_file = $this->file_root . $file;

        // Check if the file exists before we make its URI.
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
