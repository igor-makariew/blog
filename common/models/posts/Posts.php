<?php

namespace common\models\posts;

use Yii;
use common\models\categories\Categories;
use common\models\User;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string|null $title_post
 * @property string|null $text_post
 * @property int|null $id_user
 * @property int|null $id_category
 * @property int|null $status_post
 */
class Posts extends \yii\db\ActiveRecord
{
    public $file;
    public $nameFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text_post'], 'string'],
            [['id_user', 'id_category', 'status_post'], 'integer'],
            [['title_post'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_post' => 'Title Post',
            'text_post' => 'Text Post',
            'id_user' => 'Id User',
            'id_category' => 'Id Category',
            'status_post' => 'Status Post',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategories()
    {
        return $this->hasOne(Categories::class, ['id' => 'id_category']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    /**
     * upload file
     *
     * @return bool
     */
    public function upload()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/backend/web/images/';
        $this->nameFile = $this->randomFileName($this->file->extension);
        $file = $dir . $this->nameFile;
        $this->file->saveAs($file);
        return true;
    }

    public function uploadFrontend()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/frontend/web/images/';
        $this->nameFile = $this->randomFileName($this->file->extension);
        $file = $dir . $this->nameFile;
        $this->file->saveAs($file);
        return true;
    }

    /**
     * set random name
     *
     * @param bool $extension
     * @return string
     */
    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));
            $file = $name . $extension;
        } while (file_exists($file));

        return $file;
    }
}
