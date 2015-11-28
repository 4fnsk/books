<?php
namespace common\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * Update Book form
 */
class UpdateBookForm extends Model
{
    /**
     * @var Books instance of Books
     */
    public $book;

    /**
     * @var string book name
     */
    public $name;

    /**
     * @var string book date release
     */
    public $date;

    /**
     * @var int
     */
    public $author_id;

    /**
     * @var string book image
     */
    public $preview;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['date', 'filter', 'filter' => 'trim'],
            ['date', 'required'],
            ['date', 'string', 'min' => 2, 'max' => 255],

            ['author_id', 'required'],
            ['author_id', 'integer'],

            [
                ['preview'],
                'file',
                'extensions' => 'jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxFiles' => 1,
                'skipOnEmpty' => true,
            ],

        ];
    }

    /**
     * Builds the model
     */
    public function __construct($book){
        $this->book = $book;
        $this->name = $book->name;
        $this->date = Yii::$app->formatter->asDate($book->date);
        $this->author_id = $book->author_id;
        $this->preview = $book->preview;
    }

    /**
     * Uploads the preview image, returns filename or false
     * @return string|bool
     */
    public function upload()
    {
        $fileName = false;
        if ($this->validate()) {
            if ($this->preview instanceof UploadedFile) {
                $fileName = Yii::$app->getSecurity()->generateRandomString() . '.' . $this->preview->extension;
                $this->preview->saveAs(Yii::getAlias('@webroot') . '/images/' . $fileName);
            }
        }
        return $fileName;
    }


    /**
     * Updates the model
     */
    public function update()
    {
        $this->book->name = $this->name;
        $this->book->date = $this->date;
        $this->book->author_id = $this->author_id;
        $fileName = $this->upload();
        if ($fileName) {
            $this->book->preview = $fileName;
        }
        $this->book->save();
    }

    /**
     * Converts date to timestamp
     */
    public function beforeValidate() {
        try {
            $this->date = Yii::$app->formatter->asTimestamp($this->date);
        } catch(\Exception $e) {
            $this->addError('date', 'Wrong date release book');
            return false;
        }
        return parent::beforeValidate();
    }
}
