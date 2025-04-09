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
		$produtos = Produtos::find()->all();
		$categorias = Categorias::find()->all();
		
		//echo '<pre>'; print_r( $produtos ); echo'</pre>'; exit;
		//echo '<pre>'; print_r( $categorias ); echo'</pre>'; exit;
		
		return $this->render( 
			'index', 
			[
				'produtos' => $produtos,
				'categorias' => $categorias,
			]
		);
	}
	
	public function actionCreate()
	{
		$produto = new Produtos();
		$categorias = Categorias::find()->all();
		
		
		if( $produto->load( Yii::$app->request->post() ) ){
			
			if( $produto->save() ){
				
				Yii::$app->session->setFlash('success', 'Item criado com sucesso.');
				return $this->redirect(['index']);
				
			}
			else{
				
				// Mostra os erros de validação no flash message
				$errors = implode('<br>', $produto->getFirstErrors());
				Yii::$app->session->setFlash('error', 'Erro ao gravar: ' . $errors);
				
				// Log para depuração
				Yii::error('Erro ao salvar produto: ' . print_r($produto->errors, true));
				
			}
			
		}
		
		return $this->render(
			'create', 
			[
				'produto' => $produto,
				'categorias' => $categorias,
			]
		);
		
	}
	
	public function actionUpdate()
	{
		echo'Update';
		
		//return $this->render('update');
	}
	
	public function actionDelete()
	{
		echo'Delete';
		
		//return $this->render('delete');
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
