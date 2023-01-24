<?php

namespace common\models\categories;

use Yii;
use yii\db\ActiveRecord;
use common\models\posts\Posts;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $title_category
 */
class Categories extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_category'], 'string', 'max' => 64],
            [['title_category'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_category' => 'Title Category',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getPosts()
    {
        return $this->hasOne(Posts::class, ['id_category' => 'id']);
    }
}
