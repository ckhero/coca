<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadForm extends Model
{
	public $files;

    public function rules()
    {
        return [
           // [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', maxSize],
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif, mp4', 'maxFiles' => 4, 'maxSize'=> 1024*1024*256],
        ];
    }
    
    public function upload()
    {

    	foreach($this->files as $file) {
            $fileName =  uuid() . '.' . $file->extension;
    		$attachment = uploadPath('uploads/'.date('Ymd').'/') . $fileName;
	    	$file->saveAs($attachment);
	    	$attachments[] = [
                'type'=> $file->extension,
                'name'=> $fileName,
                'original_name'=> $file->baseName.$file->extension,
                'path'=> 'https://'.Yii::$app->request->serverName.'/'.$attachment,
            ];
    	}
    	return $attachments;
    }
}
  