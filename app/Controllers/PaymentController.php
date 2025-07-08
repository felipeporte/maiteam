<?php
namespace App\Controllers;

use App\Models\Payment;

class PaymentController
{
    private Payment $model;

    public function __construct()
    {
        $this->model = new Payment();
    }

    public function list(): void
    {
        $payments = $this->model->all();
        require __DIR__ . '/../Views/payments/list.php';
    }

    public function form(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $payment = $id ? $this->model->find($id) : ['athlete_id'=>'','coach_id'=>'','guardian_id'=>'','service_type'=>'','amount'=>'','paid_at'=>''];
        $athletes  = $this->model->athletes();
        $guardians = $this->model->guardians();
        $coaches   = $this->model->coaches();
        require __DIR__ . '/../Views/payments/form.php';
    }

    public function save(): void
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $data = [
            'athlete_id'  => (int)($_POST['athlete_id'] ?? 0),
            'coach_id'    => (int)($_POST['coach_id'] ?? 0),
            'guardian_id' => (int)($_POST['guardian_id'] ?? 0),
            'service_type'=> (string)($_POST['service_type'] ?? ''),
            'amount'      => (float)($_POST['amount'] ?? 0),
            'paid_at'     => $_POST['paid_at'] ?? null,
        ];
        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }
        header('Location: ?r=payments/list');
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?r=payments/list');
    }
}