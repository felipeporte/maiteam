<?php
namespace App\Controllers;

use App\Models\Athlete;

class AthleteController
{
    private Athlete $model;

    public function __construct()
    {
        $this->model = new Athlete();
    }

    public function list(): void
    {
        $athletes = $this->model->all();
        require __DIR__ . '/../Views/athletes/list.php';
    }

    public function form(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $athlete = $id ? $this->model->find($id) : ['name'=>'','rut'=>'','email'=>'','birthdate'=>''];
        require __DIR__ . '/../Views/athletes/form.php';
    }

    public function save(): void
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'rut' => trim($_POST['rut'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'birthdate' => $_POST['birthdate'] ?? null,
        ];
        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }
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
