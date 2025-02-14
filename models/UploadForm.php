<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $pdfFile;

    public function rules()
    {
        return [
            [['pdfFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . $this->pdfFile->baseName . '.' . $this->pdfFile->extension;
            Yii::info("Attempting to save file to: $filePath", __METHOD__);
            if ($this->pdfFile->saveAs($filePath)) {
                Yii::info("File successfully saved to: $filePath", __METHOD__);
                return true;
            } else {
                Yii::error("Failed to save file to: $filePath", __METHOD__);
                return false;
            }
        } else {
            Yii::error("File validation failed: " . json_encode($this->errors), __METHOD__);
            return false;
        }
    }
}
