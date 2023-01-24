<?php

namespace common\models\personaData;

use common\models\User;
use Yii;

/**
 * This is the model class for table "personal_data".
 *
 * @property int $id
 * @property string|null $fio
 * @property string|null $email
 */
class PersonalData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personal_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'email' => 'Email',
        ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail($data)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailTest-html', 'text' => 'emailTest-text'],
                ['data' => $data]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($data['email'])
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
