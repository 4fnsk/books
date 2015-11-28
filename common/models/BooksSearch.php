<?php
/**
 * Created by PhpStorm.
 * User: wiz
 * Date: 25.11.15
 * Time: 13:50
 */

namespace common\models;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use yii;


class BooksSearch extends Books
{

    /**
     * @var string author full name
     */
    public $fullName;

    /**
     * @var string date from search
     */
    public $dateFrom;

    /**
     * @var string date to search
     */
    public $dateTo;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_create', 'date_update', 'date', 'author_id'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255],
            [['fullName', 'dateFrom', 'dateTo'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Converts date to timestamp
     * @return bool
     */
    public function beforeValidate() {
        try {
            $this->dateFrom = Yii::$app->formatter->asTimestamp($this->dateFrom);
            $this->dateTo = Yii::$app->formatter->asTimestamp($this->dateTo);
            if ($this->dateTo == 0 || $this->dateFrom == 0) {
                $this->dateTo = null;
                $this->dateFrom = null;
            }
        } catch(\Exception $e) {
            $this->dateFrom = null;
            $this->dateTo = null;
        }
        return parent::beforeValidate();
    }



    /**
     * Returns ActiveDataProvider with sort and filters
     * @param array
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Books::find()->joinWith('author');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'preview',
                'date',
                'date_create',
                'fullName' => [
                    'asc' => ['authors.lastname' => SORT_ASC, 'authors.firstname' => SORT_ASC],
                    'desc' => ['authors.lastname' => SORT_DESC, 'authors.firstname' => SORT_DESC],
                    'label' => 'fullName'
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            //$query->joinWith(['author']);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'preview' => $this->preview,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['between', 'date', $this->dateFrom, $this->dateTo]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}