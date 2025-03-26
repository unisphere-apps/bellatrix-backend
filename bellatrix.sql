-- Table des activités
CREATE TABLE bel_activites (
    id_activite INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    lieu VARCHAR(150),
    date DATETIME NOT NULL,
    capacite INT,
    statut ENUM('ouverte', 'complète', 'annulée') DEFAULT 'ouverte',
    organisateur_id INT NOT NULL
    -- FOREIGN KEY (organisateur_id) REFERENCES user(id_user) -- si tu veux l'activer
);

-- Table des réservations
CREATE TABLE bel_reservations (
    id_reservation INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    activite_id INT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('confirmée', 'annulée') DEFAULT 'confirmée',
    FOREIGN KEY (activite_id) REFERENCES bel_activites(id_activite)
    -- FOREIGN KEY (utilisateur_id) REFERENCES user(id_user) -- si besoin plus tard
);
