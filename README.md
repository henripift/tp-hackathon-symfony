# TP1 Hackathon – Symfony & Doctrine ORM

**BTS SIO SLAM – Henri PIFTEAU** · PHP 8.4 · Symfony 8.1 · Doctrine ORM 3 · MySQL 8.4

## Procédure d'installation

**1. Création du projet**
```bash
composer create-project symfony/skeleton:"8.1.*" tp1-hackathon-symfony
cd tp1-hackathon-symfony
composer require webapp
composer require --dev orm-fixtures
```

**2. Création de la base et de l'utilisateur (MySQL, en root)**
```sql
CREATE DATABASE hackathon CHARACTER SET utf8mb4;
CREATE USER '[UTILISATEUR]'@'localhost' IDENTIFIED BY '[MDP]';
GRANT ALL PRIVILEGES ON hackathon.* TO '[UTILISATEUR]'@'localhost';
FLUSH PRIVILEGES;
```
Puis dans `.env` :
```env
DATABASE_URL="mysql://[UTILISATEUR]:[MDP]@127.0.0.1:3306/hackathon?serverVersion=8.4.0&charset=utf8mb4"
```

**3. Entités, tables et données de test**
```bash
php bin/console make:entity Hackathon          # idem pour chaque entité
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

> Pour récupérer ce dépôt : `git clone`, `composer install`, étape 2, puis `doctrine:migrations:migrate` et `doctrine:fixtures:load`.

## Entités créées

| Entité | Attributs |
|---|---|
| Hackathon | dateHeureDebut, dateHeureFin, lieu, ville, theme |
| Organisateur | statut, nom, siteweb, email |
| Projet | description, retenu |
| Participant | nom, prenom, email, telephone, dateNaissance, lienPortefolio |
| Inscription | num, date, competence |
| Equipe | nom, lienPrototype |

**Relations du modèle** (à mapper au TP suivant, les entités de ce TP sont créées *sans* relations) :

- Hackathon **N—N** Organisateur *(table d'association `Organiser`)*
- Hackathon **1—N** Projet
- Hackathon **1—N** Inscription
- Participant **1—N** Inscription
- Projet **1—N** Equipe
- Equipe **1—N** Inscription *(membres de l'équipe, table `Regrouper`)*
- Inscription **1—N** Equipe *(inscription qui a créé l'équipe)*

## Requête de test

```bash
php bin/console dbal:run-sql "SELECT * FROM hackathon"
```

```
 ---- --------------------- --------------------- ------------------ -------- ---------------
  id   date_heure_debut      date_heure_fin        lieu               ville    theme
 ---- --------------------- --------------------- ------------------ -------- ---------------
  1    2026-11-14 09:00:00   2026-11-15 18:00:00   Cité des Congrès   Nantes   IA et santé
  2    2026-12-05 08:30:00   2026-12-06 17:00:00   Epitech            Rennes   Ville durable
  3    2027-02-20 10:00:00   2027-02-21 16:00:00   Station F          Paris    Cybersécurité
 ---- --------------------- --------------------- ------------------ -------- ---------------
```

---

# TP 2 - Application Web : Response HTTP en mode Client/Serveur

## Prérequis
- PHP 8.4, Composer
- MySQL 8.4, Doctrine ORM 3

## Commande de base pour gérer la logique applicative
Composants intervenant dans le cycle de vie d'une requête/réponse HTTP :
**Request** (navigateur) → **Routeur** (`#[Route]`) → **Controller** (`HackathonController`) → **Repository** Doctrine (`findAll()`) → **Response** (HTML ou JSON) renvoyée au client.

```bash
php bin/console make:controller Hackathon   # création du contrôleur
php bin/console debug:router                # vérification des routes
php bin/console cache:clear                 # vidage du cache
php -S localhost:8000 -t public             # lancement du serveur
```

| Version | Route | Méthode du contrôleur | Réponse |
|---|---|---|---|
| 1 – HTML | `GET /hackathons` | `index()` | `new Response($html)` |
| 2 – JSON | `GET /hackathons/json` | `indexJson()` | `$this->json($hackathons)` |

## Test d'interrogation de l'application web :
URL requêtée :

```bash
http://localhost:8000/hackathons
http://localhost:8000/hackathons/json
```

Résultat (extrait) :

```json
[
  {
    "id": 1,
    "dateHeureDebut": "2026-11-14T09:00:00+00:00",
    "dateHeureFin": "2026-11-15T18:00:00+00:00",
    "lieu": "Cité des Congrès",
    "ville": "Nantes",
    "theme": "IA et santé"
  },
  ...
]
```

## Difficultés rencontrées
- Oubli du `use ...\JsonResponse` pour la version JSON : la classe n'était pas trouvée.
- La route `/hackathons/json` renvoyait une erreur 404 : le cache n'avait pas pris la nouvelle route en compte, réglé avec `cache:clear` et vérifié avec `debug:router`.
