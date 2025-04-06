```markdown
# 📘 Bellatrix API – Documentation

API de gestion des activités et réservations, avec système d'authentification basé sur token.

---

## 🌐 Base URL

```
http://localhost/bellatrix-backend/public
```

Toutes les routes suivantes sont relatives à cette URL.

---

## 🔐 Authentification

### POST `/login`

> Authentifie un utilisateur.

**Body (JSON)**

```json
{
  "email": "jp@free.fr",
  "password": "root"
}
```

**Réponse (200 OK)**

```json
{
  "token": "abc123...",
  "user_id": 1,
  "role_id": 2
}
```

**Erreurs**

| Code | Message                   |
|------|---------------------------|
| 401  | Identifiants invalides    |
| 500  | Erreur serveur            |

---

### POST `/register`

> Inscrit un nouvel utilisateur.

**Body (JSON)**

```json
{
  "nom": "Jean",
  "prenom": "Pierre",
  "etablissement": "Lycée Lumière",
  "email": "jp@free.fr",
  "password": "root"
}
```

**Réponse (201 Created)**

```json
{
  "message": "Utilisateur enregistré avec succès"
}
```

**Erreurs**

| Code | Message                |
|------|------------------------|
| 409  | Email déjà utilisé     |
| 500  | Erreur serveur         |

---

## 🔑 Authentification requise

> Toutes les routes ci-dessous nécessitent un token Bearer dans l'en-tête :

```
Authorization: Bearer {TOKEN}
```

---

## 📚 Activités

### GET `/activites`

> Liste toutes les activités.

**Réponse**

```json
[
  {
    "id_activite": 1,
    "titre": "Randonnée",
    "description": "Sortie en montagne",
    "lieu": "Chamonix",
    "date": "2025-05-01",
    "capacite": 20,
    "statut": "ouverte",
    "organisateur_id": 1
  }
]
```

---

## 📅 Réservations

### GET `/reservations`

> Liste toutes les réservations.

```json
[
  {
    "id_reservation": 1,
    "utilisateur_id": 1,
    "activite_id": 2,
    "date": "2025-04-06",
    "statut": "confirmée"
  }
]
```

---

### GET `/reservations/user/{id}`

> Liste les réservations d’un utilisateur.

**Exemple :**
```
GET /reservations/user/1
```

---

### POST `/reservations`

> Crée une réservation.

**Body**

```json
{
  "utilisateur_id": 1,
  "activite_id": 2
}
```

**Réponse (201 Created)**

```json
{
  "message": "Réservation effectuée"
}
```

---

### DELETE `/reservations/{id}`

> Supprime une réservation.

**Exemple :**
```
DELETE /reservations/3
```

**Réponse**

```json
{
  "message": "Réservation annulée"
}
```

---

## ⚠️ Codes HTTP utilisés

| Code | Signification             |
|------|---------------------------|
| 200  | OK                        |
| 201  | Créé                      |
| 400  | Requête invalide          |
| 401  | Non autorisé              |
| 404  | Ressource non trouvée     |
| 409  | Conflit                   |
| 500  | Erreur serveur interne    |

---

## 🧠 Sécurité

- Toutes les routes protégées doivent inclure :
```
Authorization: Bearer VOTRE_TOKEN
```
- Les tokens sont générés lors du login.
- Stockage temporaire sans expiration (à améliorer).

```
