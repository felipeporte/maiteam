<?php
namespace App\Controllers;

use App\Models\GuardianAthlete;

class GuardianAthleteController
{
    private GuardianAthlete $model;

    public function __construct()
    {
        $this->model = new GuardianAthlete();
    }

    public function list(): void
    {
        $relations = $this->model->all();
        require __DIR__ . '/../Views/guardian_athlete/list.php';
    }

    public function form(): void
    {
        $guardians = $this->model->guardians();
        $athletes  = $this->model->athletes();
        require __DIR__ . '/../Views/guardian_athlete/form.php';
    }

    public function save(): void
    {
        $g = (int)($_POST['guardian_id'] ?? 0);
        $a = (int)($_POST['athlete_id'] ?? 0);
        if ($g && $a) {
            $this->model->create($g, $a);
        }
        header('Location: ?r=guardian_athlete/list');
    }

    public function delete(): void
    {
        $g = (int)($_GET['g'] ?? 0);
        $a = (int)($_GET['a'] ?? 0);
        if ($g && $a) {
            $this->model->delete($g, $a);
        }
        header('Location: ?r=guardian_athlete/list');
    }
}