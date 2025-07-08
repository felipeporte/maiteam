<?php
namespace App\Controllers;

use App\Models\Guardian;

class GuardianController
{
    private Guardian $model;

    public function __construct()
    {
        $this->model = new Guardian();
    }

    public function list(): void
    {
        $guardians = $this->model->all();
        require __DIR__ . '/../Views/guardians/list.php';
    }

    public function form(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $guardian = $id ? $this->model->find($id) : ['name'=>'','email'=>'','phone'=>''];
        require __DIR__ . '/../Views/guardians/form.php';
    }

    public function save(): void
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $data = [
            'name'  => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
        ];
        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }
        header('Location: ?r=guardians/list');
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?r=guardians/list');
    }
}