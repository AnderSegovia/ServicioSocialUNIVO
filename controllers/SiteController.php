<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::info('Loaded post data: ' . print_r(Yii::$app->request->post(), true));
            if ($model->login()) {
                Yii::info('Login successful for email: ' . $model->email);
                return $this->redirect(['index']);
            } else {
                Yii::error('Login failed for email: ' . $model->email);
            }
        }
    
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->render('login');

    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('index');
    }
    public function actionRegisterUser()
    {
        $email = ''; 
        $password = '';
    
        $user = new User();
        $user->email = $email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->auth_key = Yii::$app->security->generateRandomString(); // Genera un valor para auth_key
    
        // Configura las fechas de creación y actualización
        $user->created_at = time(); // Establece la fecha actual como timestamp
        $user->updated_at = time(); // Establece la fecha actual como timestamp
    
        if ($user->save()) {
            echo "Usuario registrado exitosamente.";
        } else {
            // Formatear los errores para mostrarlos como una cadena
            $errors = [];
            foreach ($user->errors as $attributeErrors) {
                foreach ($attributeErrors as $error) {
                    $errors[] = $error;
                }
            }
            echo "Error al registrar el usuario: " . implode(", ", $errors);
        }
    }
    
    
}
 