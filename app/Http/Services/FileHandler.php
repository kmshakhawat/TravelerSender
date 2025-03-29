<?php

namespace App\Http\Services;

trait FileHandler
{
    public function handleFile($file, $path, $existingFile)
    {
        if ($file) {
            $this->removeFile($existingFile);
            return $this->getFile($file, $path);
        }
        return $existingFile;
    }

    private function getFile($file, $path): string
    {
//        $fileExtension = time().'_'.$file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
        $fileExtension = time() . '_' . $file->getClientOriginalName();
        $uploadPath = $path;
        $file->move(storage_path('app/public/'. $uploadPath), $fileExtension);
        return $uploadPath . $fileExtension;
    }

    public function removeFile($existingFile): void
    {
        if ($existingFile && file_exists(storage_path('app/public/'. $existingFile))) {
            unlink(storage_path('app/public/'. $existingFile));
        }
    }

}
