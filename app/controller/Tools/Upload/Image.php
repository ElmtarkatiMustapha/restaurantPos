<?php


namespace TOOL\Upload;

use TOOL\HTTP\RES;
use TOOL\HTTP\RESException;

final class Image
{

    /**
     * Upload method
     * 
     * @param array $file
     * 
     * @return RES
     */
    static function upload(array $file)
    {

        // Difine upload dir
        $UPLOAD_DIR = BASEUPLOAD . '/';

        // New upload
        $uploader = new Uploader();
        $data = $uploader->upload($file, array(
            'limit' => 10, //Maximum Limit of files. {null, Number}
            'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => ['jpg', 'png', 'jpeg', 'gif'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => $UPLOAD_DIR, //Upload directory {String}
            'title' => array('auto', 20), //New file name {null, String, Array} *please read documentation in README.md
            'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
            'replace' => false, //Replace the file if it already exists {Boolean}
            'perms' => null, //Uploaded file permisions {null, Number}
            'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
            'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
            'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
            'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
            'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
            'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
        ));


        // Has errors
        if ($data['hasErrors'])
            throw new RESException((string) $data['errors'][0][0]);

        return RES::return(RES::SUCCESS, null, $data['data']['metas'][0]);
    }
}
