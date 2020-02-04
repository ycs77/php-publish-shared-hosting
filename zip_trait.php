<?php

trait ZipTrait
{
    /** @var ZipArchive */
    protected $zip;

    /** @var string */
    protected $rootPath;

    /** @var string */
    protected $rootRelativePath;

    public function init($relativePath = '../')
    {
        if (!extension_loaded('zip')) {
            exit("Error: the PHP zip extension not loaded");
        }

        $this->zip = new ZipArchive();
        $this->rootRelativePath = $this->getRootRelativePath($relativePath);
        $this->rootPath = $this->getRootPath($this->rootRelativePath);
    }

    public function getRootPath($default = null)
    {
        if (!$path = realpath($default)) {
            exit("Error: path \"{$default}\" not found");
        }

        return $path;
    }

    public function getRootRelativePath($default = null)
    {
        return $_GET['rootRelativePath'] ?? $default;
    }

    public function getZipFileName($default = null)
    {
        return ($_GET['zipFileName'] ?? $default ?? basename($this->rootPath)) . '.zip';
    }

    public function getZipFilePath($zipFileName = null)
    {
        $fileName = $zipFileName ?? $this->getZipFileName();

        if ($_GET['isSaveToRoot'] ?? false) {
            return implode(DIRECTORY_SEPARATOR, [
                $this->rootPath,
                $fileName,
            ]);
        }

        return $fileName;
    }

    public function getPwdDirName()
    {
        return basename(realpath('.'));
    }
}
