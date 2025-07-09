<?php
namespace App\Controllers;

use App\Models\AthleteCoachSession;

class AthleteCoachSessionController
{
    private AthleteCoachSession $model;

    public function __construct()
    {
        $this->model = new AthleteCoachSession();
    }

    public function list(): void
    {
        $sessions = $this->model->all();
        require __DIR__ . '/../Views/athlete_coach_sessions/list.php';
    }

    public function form(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $session = $id ? $this->model->find($id) : ['athlete_id'=>'','coach_id'=>'','training_type_id'=>'','session_mode'=>'presencial','monthly_fee'=>''];
        $athletes = $this->model->athletes();
        $coaches = $this->model->coaches();
        $trainingTypes = $this->model->trainingTypes();
        require __DIR__ . '/../Views/athlete_coach_sessions/form.php';
    }

    public function save(): void
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $data = [
            'athlete_id' => (int)($_POST['athlete_id'] ?? 0),
            'coach_id' => (int)($_POST['coach_id'] ?? 0),
            'training_type_id' => (int)($_POST['training_type_id'] ?? 0),
            'session_mode' => $_POST['session_mode'] ?? 'presencial',
            'monthly_fee' => (float)($_POST['monthly_fee'] ?? 0),
        ];
        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->create($data);
        }
        header('Location: ?r=athlete_coach_sessions/list');
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?r=athlete_coach_sessions/list');
    }

    public function report(): void
    {
        $byCoach = $this->model->summaryByCoach();
        $byAthlete = $this->model->summaryByAthlete();
        require __DIR__ . '/../Views/athlete_coach_sessions/report.php';
    }
}