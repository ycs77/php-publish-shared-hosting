<?php

require_once './zip_trait.php';

echo '<div style="font-family: system-ui; margin-bottom: 1rem"><div role="alert" style="color: #721c24; background-color: #f8d7da; position: relative; padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid #f5c6cb; border-radius: 0.25rem"><h4 style="color: inherit; margin: 0 0 0.5rem; font-size: 1.5rem; font-family: inherit; font-weight: bold; line-height: 1.2">Warning!</h4><p style="margin: 0">This PHP script is very insecure, please delete it immediately after use!</p></div>
</div>';

class Production
{
    use ZipTrait;

    public function __construct($relativePath = '../')
    {
        $this->init($relativePath);
    }

    public function unzip()
    {
        $zipFileName = $this->getZipFileName();
        $zipFilePath = $this->getZipFilePath($zipFileName);

        if (!file_exists($zipFilePath)) {
            exit("Error: \"$zipFileName\" not exists");
        }

        if ($this->zip->open($zipFilePath) !== true) {
            exit("Error: can't open \"$zipFileName\"");
        }

        $this->zip->extractTo($this->rootPath);
        $this->zip->close();

        $this->removeZipFile($zipFilePath);
    }

    public function removeZipFile(string $path)
    {
        unlink($path);
    }
}

ini_set('max_execution_time', 600);
ini_set('memory_limit','1024M');

$production = new Production();
$production->unzip();

echo 'Unzip successfully.';
