<?php
namespace App\Controllers;

use App\Models\Athlete;
use App\Models\TrainingType;   

class AthleteController
{
    private Athlete $model;
    private TrainingType $types;

    public function __construct()
    {
        $this->model = new Athlete();
        $this->types = new TrainingType();

    }

    public function list(): void
    {
        $athletes = $this->model->all();
        require __DIR__ . '/../Views/athletes/list.php';
    }

    public function form(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $athlete    = $id ? $this->model->find($id) : ['name'=>'','rut'=>'','email'=>'','birthdate'=>'','training_type_id'=>null];
        $relations  = $id ? $this->model->getRelations($id) : [];
        if (!$relations) {
            $relations = [['modalidad_id'=>null,'nivel_id'=>null,'subnivel'=>null]];
        }
        $modalidades = $this->model->getModalidades();
        $trainingTypes = $this->types->all();
        $levelsList  = [];
        $subsList    = [];
        foreach ($relations as $rel) {
            $levelsList[] = $rel['modalidad_id'] ? $this->model->getLevels((int)$rel['modalidad_id']) : [];
            $subsList[]   = $rel['nivel_id'] ? $this->model->getSublevels((int)$rel['nivel_id']) : [];
        }
        require __DIR__ . '/../Views/athletes/form.php';
    }

    public function save(): void
    {
        $id   = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $mods = $_POST['modalidad_id'] ?? [];
        $lvls = $_POST['nivel_id']     ?? [];
        $subs = $_POST['subnivel']     ?? [];
        $data = [
            'name'      => trim($_POST['name'] ?? ''),
            'rut'       => trim($_POST['rut'] ?? ''),
            'email'     => trim($_POST['email'] ?? ''),
            'birthdate' => $_POST['birthdate'] ?? null,
        ];
        $trainingTypesId = isset($_POST['training_type_id']) ? (int)$_POST['training_type_id'] : null;
        $this->model->saveFicha($id ?: null, $data, $mods, $lvls, $subs, $trainingTypesId);
        header('Location: ?r=athletes/list');
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?r=athletes/list');
    }
}