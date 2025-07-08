<?php
namespace App\Controllers;

use App\Models\ClubDue;

class ClubDueController
{
    private ClubDue $model;

    public function __construct()
    {
        $this->model = new ClubDue();
    }

    public function list(): void
    {
        $dues = $this->model->all();
        require __DIR__ . '/../Views/club_dues/list.php';
    }

    public function form(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $due = $id ? $this->model->find($id) : ['guardian_id'=>'','amount'=>'','due_date'=>'','paid_at'=>''];
        $guardians = $this->model->guardians();
        require __DIR__ . '/../Views/club_dues/form.php';
    }

    public function save(): void
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $data = [
            'guardian_id' => (int)($_POST['guardian_id'] ?? 0),
            'amount'      => (float)($_POST['amount'] ?? 0),
            'due_date'    => $_POST['due_date'] ?? null,
            'paid_at'     => $_POST['paid_at'] ?? null,
        ];
        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }
        header('Location: ?r=club_dues/list');
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?r=club_dues/list');
    }

    public function report(): void
    {
        $report = $this->model->sumaryByGuardian();
        require __DIR__ . '/../Views/club_dues/report.php';
    }
}