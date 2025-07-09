CREATE TABLE IF NOT EXISTS athletes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    birthdate DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS coaches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS guardians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS guardian_athlete (
    guardian_id INT NOT NULL,
    athlete_id INT NOT NULL,
    PRIMARY KEY (guardian_id, athlete_id),
    FOREIGN KEY (guardian_id) REFERENCES guardians(id),
    FOREIGN KEY (athlete_id) REFERENCES athletes(id)
);

CREATE TABLE IF NOT EXISTS club_dues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guardian_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    due_date DATE,
    paid_at DATE,
    FOREIGN KEY (guardian_id) REFERENCES guardians(id)
);

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT,
    coach_id INT,
    guardian_id INT,
    service_type VARCHAR(100),
    amount DECIMAL(10,2) NOT NULL,
    paid_at DATE,
    FOREIGN KEY (athlete_id) REFERENCES athletes(id),
    FOREIGN KEY (coach_id) REFERENCES coaches(id),
    FOREIGN KEY (guardian_id) REFERENCES guardians(id)
);

CREATE TABLE IF NOT EXISTS performances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT,
    score INT,
    event_date DATE,
    notes TEXT,
    FOREIGN KEY (athlete_id) REFERENCES athletes(id)
);
CREATE TABLE IF NOT EXISTS categorias (
  id INT NOT NULL,
  nombre VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE categorias
  ADD PRIMARY KEY (id);

ALTER TABLE categorias
  MODIFY id INT NOT NULL AUTO_INCREMENT;
COMMIT;
CREATE TABLE IF NOT EXISTS training_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS athlete_training (
    athlete_id INT NOT NULL,
    training_type_id INT NOT NULL,
    PRIMARY KEY (athlete_id, training_type_id),
    FOREIGN KEY (athlete_id) REFERENCES athletes(id),
    FOREIGN KEY (training_type_id) REFERENCES training_types(id)
);
CREATE TABLE IF NOT EXISTS athlete_coach_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT NOT NULL,
    coach_id INT NOT NULL,
    training_type_id INT,
    session_mode ENUM('zoom','presencial','flex') NOT NULL DEFAULT 'presencial',
    monthly_fee DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (athlete_id) REFERENCES athletes(id),
    FOREIGN KEY (coach_id) REFERENCES coaches(id),
    FOREIGN KEY (training_type_id) REFERENCES training_types(id)
);