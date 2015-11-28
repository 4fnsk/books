<?php

namespace common\models;

use Yii;

class Books extends ARBooks
{
    /**
     * @var string author first name
     */
    public $firstName;

    /**
     * @var string author last name
     */
    public $lastName;

    /**
     * Returns full name of author
     * @return string|null
     */
    public function getFullName() {
        $author = $this->getAuthor()->one();
        if ($author == null) {
            return null;
        }
        $this->firstName = $author->firstname;
        $this->lastName = $author->lastname;
        return $this->lastName . ' ' . $this->firstName;
    }

    /**
     * Sets date_update to current time
     * Whether new book sets date_create to current time
     * @return string|null
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->date_create = time();
        }
        $this->date_update = time();
        return parent::beforeSave($insert);
    }
}