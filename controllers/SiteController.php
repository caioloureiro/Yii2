<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Produtos;
use app\models\Categorias;

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
                    'create' => ['post'],
                    'update' => ['post'],
                    'delete' => ['post'],
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
			'create' => 'app\controllers\actions\CreateAction',
            'update' => 'app\controllers\actions\UpdateAction',
            'delete' => 'app\controllers\actions\DeleteAction',
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		
		$produtos = Produtos::find()->all(); //PUXA A TABELA PRODUTOS
		$categorias = Categorias::find()->all(); //PUXA A TABELA PRODUTOS
		//echo '<pre>'; print_r( $categorias ); echo'</pre>'; exit; //TESTE
	
        return $this->render(
			'index',
			[
				'produtos' => $produtos,
				'categorias' => $categorias
			]
		);
		
    }
	
	public function actionCreate()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		try {
			$model = new Produtos();
			if (!$model->load(Yii::$app->request->post())) {
				throw new \Exception('Falha ao carregar dados');
			}
			
			if (!$model->save()) {
				return $this->asJson([
					'success' => false,
					'errors' => $model->errors
				]);
			}
			
			return $this->asJson([
				'success' => true,
				'id' => $model->id
			]);
			
		} catch (\Exception $e) {
			Yii::error($e->getMessage());
			return $this->asJson([
				'success' => false,
				'errors' => $e->getMessage()
			]);
		}
	}

	public function actionUpdate($id)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$model = Produtos::findOne($id);
		
		if (!$model) {
			return ['success' => false, 'errors' => ['Produto não encontrado']];
		}
		
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				return ['success' => true];
			}
			return ['success' => false, 'errors' => $model->errors];
		}
		
		return ['success' => false, 'errors' => 'Dados inválidos'];
	}

	public function actionDelete($id)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$model = Produtos::findOne($id);
		
		if (!$model) {
			return ['success' => false, 'errors' => ['Produto não encontrado']];
		}
		
		if ($model->delete()) {
			return ['success' => true];
		}
		
		return ['success' => false, 'errors' => 'Erro ao excluir'];
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
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

        return $this->goHome();
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
        return $this->render('about');
    }
}
