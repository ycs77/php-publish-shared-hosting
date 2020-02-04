<?php

require_once './zip_trait.php';

class Local
{
    use ZipTrait;

    /** @var array */
    protected $ignoreFiles = [
        '.',
        '..',
    ];

    /** @var array */
    protected $ignoreMatchFiles = [
        '/node_modules/',
        '/\.git/',
        '/\.vscode/',
    ];

    public function __construct($relativePath = '../')
    {
        $this->init($relativePath);
        $this->ignoreMatchFiles[] = '/' . $this->getPwdDirName() . '/';
    }

    public function zip()
    {
        $zipFileName = $this->getZipFileName();
        $zipFilePath = $this->getZipFilePath($zipFileName);

        if ($this->zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            exit("Error: can't create \"$zipFileName\"");
        }

        if (is_dir($this->rootPath)) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->rootPath), RecursiveIteratorIterator::SELF_FIRST);

            /** @var \SplFileInfo $file */
            foreach ($files as $file) {
                if ($this->canIgnore($file->getFilename(), $file->getRealPath())) {
                    continue;
                }

                $filePath = $file->getRealPath();
                $fileName = str_replace($this->rootPath . DIRECTORY_SEPARATOR, '', $filePath);
                $fileName = str_replace('\\', '/', $fileName);

                if (is_dir($filePath)) {
                    $this->zip->addEmptyDir($fileName);
                } elseif (is_file($filePath)) {
                    $this->zip->addFromString($fileName, file_get_contents($filePath));
                }
            }
        }

        $this->zip->close();
    }

    public function canIgnore($filename, $path)
    {
        if (in_array($filename, $this->ignoreFiles)) {
            return true;
        }

        return array_filter($this->ignoreMatchFiles, function ($pattern) use ($path) {
            return preg_match($pattern, $path);
        });
    }
}

ini_set('max_execution_time', 600);
ini_set('memory_limit','1024M');

$local = new Local();
$local->zip();

$zipFileName = $local->getZipFileName();

echo "Create Zip Archive: $zipFileName successfully.";
