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

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT,
    coach_id INT,
    amount DECIMAL(10,2) NOT NULL,
    paid_at DATE,
    FOREIGN KEY (athlete_id) REFERENCES athletes(id),
    FOREIGN KEY (coach_id) REFERENCES coaches(id)
);

CREATE TABLE IF NOT EXISTS performances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT,
    score INT,
    event_date DATE,
    notes TEXT,
    FOREIGN KEY (athlete_id) REFERENCES athletes(id)
);
