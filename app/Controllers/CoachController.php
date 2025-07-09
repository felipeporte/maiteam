<?php
namespace App\Controllers;

use App\Models\Coach;

class CoachController
{
    private Coach $model;

    public function __construct()
    {
        $this->model = new Coach();
    }

    public function list(): void
    {
        $coaches = $this->model->all();
        require __DIR__ . '/../Views/coaches/list.php';
    }

    public function form(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $coach = $id ? $this->model->find($id) : ['name' => '', 'email' => ''];
        require __DIR__ . '/../Views/coaches/form.php';
    }

    public function save(): void
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $data = [
            'name'  => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
        ];
        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }
        header('Location: ?r=coaches/list');
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?r=coaches/list');
    }
}