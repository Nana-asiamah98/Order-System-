<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploadService
{
    private $targetDirectory;
    /**
     * @var SluggerInterface
     */
    private $slugger;


    /**
     * FileUploadService constructor.
     * @param string $targetDirectory
     * @param SluggerInterface $slugger
     */
    public function __construct(string $targetDirectory,SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function fileUpload(UploadedFile $file): ?string
    {
        if (null === $file) {
            return null;
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalName);
        $newFileName = $safeFileName.'_'.uniqid().'.'.$file->getExtension();

        try {
            $file->move($this->getTargetDirectory(),$newFileName);
        }catch (FileException $e){
            throw new FileException(sprintf("There's no service '%s'.",$e));
        }

        return $newFileName;

    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }


}