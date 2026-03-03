# 📑 Rapport de Réalisation - LAB 6 — Architecture en Couches (Controller / Service / DAO)



---

## 🛠️ Architecture Logicielle
Le projet a été structuré en respectant le principe de **Séparation des Préoccupations** (SoC) :

1. **Couche Présentation (Controller)** : Reçoit les requêtes et pilote les services.
2. **Couche Métier (Service)** : Centralise les règles de gestion (Validations CNE, Email, Business Rules).
3. **Couche Accès aux Données (DAO)** : Encapsule les requêtes SQL via PDO.
4. **Transport (DTO)** : Utilisation d'objets de transfert pour la sécurité des données.


---

## 🛡️ Points Clés de l'Implémentation

### ✅ Gestion des Transactions
L'action de création simultanée (Filière + Étudiant) est sécurisée par une **Transaction SQL**. En cas d'erreur sur l'étudiant (ex: format CNE invalide), la filière n'est pas créée en base (Rollback), garantissant l'**Atomicité** des données.


### 🔍 Validations Implémentées
* **Regex CNE** : Format `CNE####` obligatoire.
* **Blacklist Email** : Blocage automatique des domaines comme `mailinator.com`.
* **Contrainte d'Intégrité** : Interdiction de supprimer une filière contenant des étudiants rattachés.

---

## 🚦 Résultats des Tests
Les tests ont été automatisés dans un script de diagnostic (`test_lab6.php`). 
* L'affichage a été stylisé en **HTML/CSS** pour une meilleure lisibilité.
* Le rapport valide à la fois les **succès de persistance** et les **blocages métier** prévus.


<img width="1194" height="805" alt="image" src="https://github.com/user-attachments/assets/d87f3ec8-a6df-4034-b16d-7843b25a4f38" />
