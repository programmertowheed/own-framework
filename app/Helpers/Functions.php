<?php

/**
 * delete file
 *
 * @param $path
 */
if (!function_exists('deleteFile')) {
    function deleteFile($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}


/**
 *  File upload function
 *
 * @param $request
 * @param $directory
 * @return string
 */
if (!function_exists('uploadFile')) {
    function uploadFile($request, $directory, $resizeImage = null)
    {
        $file = $request;
        $fileType = $file->getClientOriginalExtension();//file extention
        $fileName = time() . rand(10, 1000) . '.' . $fileType;//file name
        //$fileUrl = $directory.$fileName;//File Url
        if ($resizeImage) {
            $imageUrl = $directory . $fileName;//Image Url
            $resizeImage->save($imageUrl);
        } else {
            $file->move($directory, $fileName);
        }

        return $fileName;
    }
}


/**
 *  File update function
 *
 * @param $request
 * @param $directory
 * @return string
 */
if (!function_exists('updateFile')) {
    function updateFile($request, $directory, $oldFile, $resizeImage = null)
    {
        if ($oldFile != NULL) {
            $path = $directory . $oldFile;
            deleteFile($path);
        }
        return uploadFile($request, $directory, $resizeImage);
    }
}
