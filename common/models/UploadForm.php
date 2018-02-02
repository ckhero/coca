<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;


class UploadForm extends Model
{
	public $files;

    public function rules()
    {
        return [
           // [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', maxSize],
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, mp4', 'maxFiles' => 4],
        ];
    }
    
    public function upload()
    {

    	foreach($this->files as $file) {
    		$attachment = uploadPath('uploads/'.date('Ymd').'/') . uuid() . '.' . $file->extension;
	    	$file->saveAs($attachment);
	    	$attachments[]['path'] = $attachment;
    	}
    	return $attachments;
    }
}
  