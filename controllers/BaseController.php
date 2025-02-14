<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'create2','cargar','cargarMunicipios','cargarDistritos', 'final'], // Permite login y create
                        'controllers' => ['tbl-alumno','tbl-f1'], // Especifica que "create" es para TblAlumnoController
                        'roles' => ['?'], // Permitir acceso a usuarios invitados
                    ],
                    [
                        'allow' => true,
                        'actions' => [], // Acciones permitidas para usuarios autenticados
                        'roles' => ['@'], // Rol de usuario autenticado
                    ],
                ],
            ],
        ];
    }
}

?>