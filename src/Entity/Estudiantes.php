<?php
// Tabla estudiantes
namespace App\Entity;

use App\Repository\EstudiantesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstudiantesRepository::class)]
class Estudiantes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // columna id
    private ?int $id = null;
    //coluna nombre
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nombre = null;
    //columna salon
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $salon = null;
    //columna acudiente
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $acudiente = null;
    //columna edad
    #[ORM\Column(type: 'integer')]
    private ?int $edad = null;
    //columna genero
    #[ORM\Column(type: 'string', length: 10)]
    private ?string $genero = null;
    //columna habilitado
    #[ORM\Column(type: 'boolean')]
    private ?bool $habilitado = null;

    public function __construct()
    {
        $this->habilitado = false; // valor como predeterminado o sea que esta habilitado
    }

    //getters y setters id
    public function getId(): ?int
    {
        return $this->id;
    }
    
    //setters y getters nombre
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }
    //setters y getters salon
    public function getSalon(): ?string
    {
        return $this->salon;
    }

    public function setSalon(string $salon): static
    {
        $this->salon = $salon;

        return $this;
    }
    //setters y getters acudiente
    public function getAcudiente(): ?string
    {
        return $this->acudiente;
    }

    public function setAcudiente(string $acudiente): static
    {
        $this->acudiente = $acudiente;

        return $this;
    }
    //setters y getters edad
    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(int $edad): static
    {
        $this->edad = $edad;

        return $this;
    }
    //setters y getters genero
    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): static
    {
        $this->genero = $genero;

        return $this;
    }
    //setters y getters habilitado
    public function getHabilitado(): ?bool
    {
        return $this->habilitado;
    }

    public function setHabilitado(bool $habilitado): static
    {
        $this->habilitado = $habilitado;

        return $this;
    }
}
