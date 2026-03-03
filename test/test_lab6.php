<?php
declare(strict_types=1);

/**
 * Script de test Lab 6 - Architecture Multicouche
 * Version personnalisée (Style organisé)
 */

spl_autoload_register(function(string $className) {
    $baseNamespace = 'App\\';
    $srcDirectory = __DIR__ . '/../src/';
    $prefixLen = strlen($baseNamespace);

    if (strncmp($className, $baseNamespace, $prefixLen) !== 0) return;

    $relativeClass = substr($className, $prefixLen);
    $targetFile = $srcDirectory . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

    if (is_file($targetFile)) {
        require $targetFile;
    }
});

use App\Container\AppFactory;
use App\Controller\Response;

/**
 * Fonction d'affichage stylisée
 */
function displayTestResult(string $testName, Response $resp): void {
    // Kanghlfiw koulchi f <pre> bach l-navigateur i-7tarem l-formatage
    echo "<div style='margin-bottom: 20px; font-family: monospace;'>";
    echo "<pre style='background-color: #fdfdfd; padding: 20px; border: 1px solid #ccc; border-left: 10px solid #333; box-shadow: 2px 2px 5px #eee; border-radius: 4px;'>";
    
    $line = str_repeat("═", 85);
    // Success b l-khder o Failure b l-7mer
    $statusColor = $resp->isSuccess() ? "#28a745" : "#dc3545";
    $statusIcon  = $resp->isSuccess() ? " SUCCESS" : " FAILURE";
    $statusText  = "<span style='color: $statusColor; font-weight: bold;'>$statusIcon</span>";
    
    echo "$line\n";
    echo " TEST : " . str_pad($testName, 50) . " | STATUS : $statusText\n";
    echo str_repeat("-", 85) . "\n";

    if ($resp->isSuccess()) {
        echo " <span style='color: #0056b3;'> DATA RECEIVED :</span> " . json_encode($resp->getData(), JSON_PRETTY_PRINT) . "\n";
    } else {
        echo " <span style='color: #856404;'> ERROR MESSAGE :</span> " . $resp->getError() . "\n";
    }

    echo "</pre></div>";
}
// Initialisation
$application = AppFactory::createController();

echo " LANCEMENT DES TESTS DE VALIDATION MÉTIER\n";

// --- TEST 1 : Transaction (Filière + Étudiant) ---
$res1 = $application->handle([
    'action'  => 'create_filiere_then_student',
    'code'    => 'dec_2026',      
    'libelle' => 'Décimologie et evaluation',
    'cne'     => 'CNE1987',       
    'nom'     => 'EL ALAMI', 
    'prenom'  => 'IMANE', 
    'email'   => 'alamiimane23@gmail.com'
]);
displayTestResult('Transaction : Création Groupée', $res1);

// --- TEST 2 : Validation Email ---
$res2 = $application->handle([
    'action'     => 'create_etudiant',
    'cne'        => 'CNE5555', 
    'nom'        => 'Benani', 
    'prenom'     => 'Omar', 
    'email'      => 'omar@mailinator.com',
    'filiere_id' => 1
]);
displayTestResult('Contrôle : Email Domaine Interdit', $res2);

// --- TEST 3 : Validation Regex CNE ---
$res3 = $application->handle([
    'action'     => 'create_etudiant',
    'cne'        => 'REGEX_FAIL', 
    'nom'        => 'Tazi', 
    'prenom'     => 'Adil', 
    'email'      => 'adil@example.com',
    'filiere_id' => 1
]);
displayTestResult('Contrôle : Format CNE (Regex)', $res3);

// --- TEST 4 : Intégrité Référentielle ---
$res4 = $application->handle([
    'action' => 'delete_filiere', 
    'id'     => 1
]);
displayTestResult('Sécurité : Suppression Filière Non Vide', $res4);


echo "FIN DU RAPPORT DE TEST\n";