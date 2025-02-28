<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\mapage;
use app\models\Internaute;
use app\models\Trajet;
use app\models\Voyage;
use app\models\RechercheVoyage;
use app\models\Reservation;



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
                'only' => ['logout', 'reservervoyage'],
                'rules' => [
                    [
                        'actions' => ['logout', 'reservervoyage'],
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
        return $this->redirect(["site/recherchevoyage"]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        Yii::$app->response->format = Yii::$app->request->isAjax ? Response::FORMAT_JSON : Response::FORMAT_HTML;
    
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    
        $model = new \app\models\LoginForm();
    
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return [
                    'status' => 'success',
                    'message' => 'Connexion réussie !',
                    'redirect' => Yii::$app->urlManager->createUrl(['site/index']), // Redirection vers la page d'accueil
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Pseudo ou mot de passe incorrect.',
                    'errors' => $model->getErrors(), // Retourne les erreurs de validation
                ];
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
    Yii::$app->response->format = Response::FORMAT_JSON; // Réponse en JSON
    Yii::$app->user->logout();

    return [
        'status' => 'success',
        'message' => 'Vous avez été déconnecté avec succès.',
        'redirect' => Yii::$app->urlManager->createUrl(['site/index'])
    ];
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

    
    public function actionMapage()
    {
        $model = new mapage();
        return $this->render('mapage', ['model' => $model]);
    }
    


    public function actionInternaute()
{
    // Vérifie si l'utilisateur est connecté
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']); 
    }

    // Récupère l'utilisateur connecté
    $internaute = Yii::$app->user->identity;

    // Rend la vue avec les informations de l'utilisateur connecté
    return $this->render('internaute', [
        'internaute' => $internaute,
        'voyages' => $internaute->voyagesproposes,
        'reservations' => $internaute->reservationsproposes,
    ]);
}

    
//action pour recherche un voyage 
   public function actionRecherchevoyage()
{   
    try{
    $model = new RechercheVoyage();
    $voyages = null;

    // Vérification  si c'est une requête AJAX
    if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
        
        $trajet = Trajet::getInfotrajet($model->villeDepart, $model->villeArrivee);

        if ($trajet) {
            $voyages = Voyage::getVoyagesByTrajet($trajet->id);
            $voyages = array_filter($voyages, function ($voyage) use ($model) {
                return $voyage->getNombrePlacesDisponible() >= $model->nombrePersonnes;
            });
        }

        
        $message = $voyages && count($voyages) > 0
            ? 'Voyage trouvé.'
            : 'Aucun voyage trouvé pour les critères donnés.';

        // Retourner la réponse JSON pour AJAX
        return $this->asJson([
            'html' => $this->renderPartial('_resultats', ['voyages' => $voyages, 'model' => $model]),
            'message' => $message,
        ]);
    }

    
    return $this->render('recherchevoyage', [
        'model' => $model,
    ]);
}
catch (\Exception $e) {
    Yii::error("Erreur dans actionRecherchevoyage : " . $e->getMessage());
    return $this->asJson([
        'html' => '',
        'message' => 'Une erreur interne est survenue. Veuillez réessayer plus tard.',
    ]);
}
}

//action pour reserve un voyage
public function actionReservervoyage()
{
    Yii::$app->response->format = Response::FORMAT_JSON;

    if (Yii::$app->user->isGuest) {
        return [
            'status' => 'error',
            'message' => 'Vous devez être connecté pour réserver.',
            'redirect' => Yii::$app->urlManager->createUrl(['site/login']),
        ];
    }

    $id = Yii::$app->request->post('id');
    $nbplaceresa = Yii::$app->request->post('nbplaceresa', 1);

    if (!$id || !$nbplaceresa) {
        return [
            'status' => 'error',
            'message' => 'Paramètres manquants ou invalides.',
        ];
    }

    //récupérer le voyage disponible
    $voyage = Voyage::getAvailableVoyage($id, $nbplaceresa);
    if (!$voyage) {
        return [
            'status' => 'error',
            'message' => 'Le voyage est introuvable ou le nombre de places demandées dépasse les places disponibles.',
        ];
    }

    // Créer et sauvegarder la réservation
    $reservation = new Reservation([
        'voyage' => $voyage->id,
        'voyageur' => Yii::$app->user->id,
        'nbplaceresa' => $nbplaceresa,
    ]);

    if ($reservation->save()) {
        return [
            'status' => 'success',
            'message' => 'Votre réservation a été enregistrée avec succès.',
            'redirect' => Yii::$app->urlManager->createUrl(['site/internaute', 'pseudo' => Yii::$app->user->identity->pseudo]),
        ];
    }

    return [
        'status' => 'error',
        'message' => 'Une erreur est survenue lors de la sauvegarde de la réservation.',
        'errors' => $reservation->getErrors(),
    ];
}


//action pour cree un compte
public function actionRegisterpage()
{
    if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Internaute();

        if ($model->load(Yii::$app->request->post())) {
            // Vérification d'unicité en utilisant les méthodes du modèle
            if (Internaute::isPseudoTaken($model->pseudo)) {
                return [
                    'status' => 'error',
                    'message' => 'Ce pseudo est déjà utilisé.',
                ];
            }

            if (Internaute::isEmailTaken($model->mail)) {
                return [
                    'status' => 'error',
                    'message' => 'Cette adresse email est déjà utilisée.',
                ];
            }

            // Si tout va bien, on sauvegarde l'internaute
            if ($model->validate() && $model->saveInternaute()) {
                return [
                    'status' => 'success',
                    'message' => 'Inscription réussie ! Vous pouvez maintenant vous connecter.',
                    'redirect' => Yii::$app->urlManager->createUrl(['site/login']),
                ];
            }
        }

        // Retourner les erreurs de validation s'il y a un problème
        return [
            'status' => 'error',
            'message' => 'Erreur lors de l\'inscription.',
            'errors' => $model->getErrors(),
        ];
    }

    return $this->render('registerpage', [
        'model' => new Internaute(),
    ]);
}

//action pour proposer un voyage
public function actionProposevoyage()
{
    if (Yii::$app->user->isGuest) {
        return [
            'success' => false,
            'message' => 'Vous devez être connecté pour proposer un voyage.',
            'redirect' => Yii::$app->urlManager->createUrl(['site/login']),
        ];
    }

    $user = Yii::$app->user->identity;

    // Vérification du permis
    if (empty($user->permis)) {
        return $this->asJson([
            'success' => false,
            'message' => 'Vous devez avoir un permis pour proposer un voyage.',
        ]);
    }

    $model = new Voyage();

    if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
        // Rechercher le trajet correspondant aux villes saisies
        $trajet = Trajet::getInfotrajet($model->depart, $model->arrivee);

        if ($trajet) {
            $model->trajet = $trajet->id;
            $model->conducteur = $user->id;

            if ($model->save()) {
                return $this->asJson([
                    'success' => true,
                    'message' => 'Votre voyage a été proposé avec succès.',
                    'redirect' => Yii::$app->urlManager->createUrl(['site/internaute', 'pseudo' => $user->pseudo]),
                ]);
            }
             else {
                return $this->asJson([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de la sauvegarde du voyage.',
                ]);
            }
        } else {
            return $this->asJson([
                'success' => false,
                'message' => 'Le trajet spécifié n\'existe pas. Veuillez vérifier les villes de départ et d\'arrivée.',
            ]);
        }
    }

    return $this->render('proposevoyage', ['model' => $model]);
}






}