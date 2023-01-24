<?php

namespace frontend\controllers;

use common\models\categories\Categories;
use common\models\posts\Posts;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\personaData\PersonalData;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    public $date = '';
    public $temps = [];
    public $weeks = [];
    public $months = [];

    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionForms()
    {

        $modelPersonalData = new PersonalData();
//igor.makariew@yandex.ru
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $modelPersonalData->fio = $data['fio'];
            $modelPersonalData->email = $data['email'];
            if ($modelPersonalData->save()) {
                if ($modelPersonalData->sendEmail($data)) {
                    return json_encode($data);
                }
            }
        }

        return 'Error';
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionPost()
    {
        $modelCategory = new Categories();
        $modelPost = new Posts();
        if ($modelCategory->load(Yii::$app->request->post()) && $modelCategory->save()) {
            return $this->redirect(['site/post']);
        }

        if ($modelPost->load(Yii::$app->request->post())) {
            $modelPost->id_user = Yii::$app->user->id;
            $modelPost->status_post = 0;
            if ($modelPost->save()) {
                return $this->redirect(['site/post']);
            }
        }

        return $this->render('post', [
            'modelCategory' => $modelCategory,
            'modelPost' => $modelPost,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию! Проверьте свой E-mail.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Ваш email подтвержден!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * start testing task
     *
     * @return array|mixed
     */
    public function actionServer()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $data = \yii\helpers\Json::decode(Yii::$app->request->getRawBody());

        $param = $data['data'];

        $path = $_SERVER['DOCUMENT_ROOT'] . "/frontend/controllers/weather_statistics.csv";

        $rows = [];
        $handle = fopen($path, "r");
        fgetcsv($handle, 10000, ",");
        while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
            $row = [];
            array_push($row, $data[0], $data[1]);
            $rows[] = $row;
        }

        switch ($param) {
            case 'Days':
                return $this->getDay($rows);
            case 'Months':
                return $this->getMonth($rows);
            case 'Weeks':
                return $this->getWeek($rows);
            default:
                return $this->getDay($rows);
        }
    }

    public function getDay($paramsOnYear)
    {
        $days = [];
        foreach ($paramsOnYear as $index => $param) {
            if (empty($this->date)) {
                $this->date = explode(' ', $param[0])[0];
            }

            if (!empty($this->date) && $this->date != explode(' ', $param[0])[0]) {
                $this->date = explode(' ', $param[0])[0];
            }

            if (strpos($param[0], $this->date) === 0) {
                if (empty($days[$this->date])) {
                    $days[$this->date] = $param[1];
                } else {
                    $days[$this->date] .= ', ' . $param[1];
                }
            }
        }

        return $this->avgTempDays($days);
    }

    public function getMonth($paramsOnYear): array
    {
        $days = $this->getDay($paramsOnYear);
        $months = [];
        foreach ($days as $day) {
            if (!array_key_exists($this->getNumberMonth($day['date']), $this->months)) {
                $months[$this->getNumberMonth($day['date'])][] = $day['temp'];
            } else {
                $months[$this->getNumberMonth($day['date'])][] = $day['temp'];
            }
        }

        return $this->avgTempMonth($months);
    }

    public function getWeek($paramsOnYear)
    {
        $days = $this->getDay($paramsOnYear);
        for ($index = 0; $index < (365 / 7); $index++) {
            $this->weeks[] = [
                'temp' => $this->avgTempWeeks(array_slice($days, ($index * 7), 7, true)),
                'date' => 'Week №' . ($index + 1)
            ];
        }

        return $this->weeks;
    }

    public function avgTempDays($days)
    {
        foreach ($days as $index => $temps) {
            $this->temps[] = [
                'temp' => round(array_sum(explode(',', $temps)) / count(explode(',', $temps)), 1),
                'date' => $index
            ];
        }

        return $this->temps;
    }

    public function avgTempWeeks($weeks)
    {
        $temp = 0;
        foreach ($weeks as $tempWeek) {
            $temp += $tempWeek['temp'];
        }

        return round($temp / 7, 1);
    }

    public function getNumberMonth($day)
    {
        return explode('.', $day)[1];
    }

    public function avgTempMonth($months): array
    {
        foreach ($months as $index => $month) {
            $this->months[] = [
                'temp' => round((array_sum($month) / count($month)), 1),
                'date' => 'Month №' . $index
            ];
        }

        return $this->months;
    }
}
