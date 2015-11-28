<?php

namespace common\models;


class Authors extends ARAuthors
{

    /**
     * Returns author full name
     * @return string book name
     */
    public function getFullName() {
        return $this->lastname . ' ' . $this->firstname;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            //'fullname' => 'Author',
        ];
    }
}