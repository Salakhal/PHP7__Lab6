<?php
declare(strict_types=1);
namespace App\Dto;

class EtudiantCreateDTO {
    private $cne;
    private $nom;
    private $prenom;
    private $email;
    private $filiereId;

    public function __construct(string $cne, string $nom, string $prenom, string $email, int $filiereId) {
        $this->cne = $cne; $this->nom = $nom; $this->prenom = $prenom;
        $this->email = $email; $this->filiereId = $filiereId;
    }

    public function getCne(): string { return $this->cne; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getFiliereId(): int { return $this->filiereId; }
}