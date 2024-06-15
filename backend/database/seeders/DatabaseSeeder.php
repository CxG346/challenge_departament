<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departament;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */




    public function run()
    {

        function getRandomName()
        {
            $firstNames = ["Carlos", "Luis", "Ana", "María", "Jose", "Lucía", "Juan", "Marta", "Pedro", "Laura"];
            $lastNames = ["García", "Rodríguez", "Martínez", "Hernández", "López", "González", "Pérez", "Sánchez", "Ramírez", "Torres"];

            $firstName = $firstNames[array_rand($firstNames)];
            $lastName1 = $lastNames[array_rand($lastNames)];
            $lastName2 = $lastNames[array_rand($lastNames)];

            return $firstName . ' ' . $lastName1 . ' ' . $lastName2;
        }

        $dataSeeder = [
            [
                "departamento" => "Recursos Humanos",
                "subdepartamentos" => [
                    "Reclutamiento y Selección",
                    "Capacitación y Desarrollo",
                    "Compensaciones y Beneficios",
                    "Relaciones Laborales"
                ]
            ],
            [
                "departamento" => "Finanzas",
                "subdepartamentos" => [
                    "Contabilidad",
                    "Tesorería",
                    "Auditoría Interna",
                    "Planificación Financiera"
                ]
            ],
            [
                "departamento" => "Marketing",
                "subdepartamentos" => [
                    "Publicidad",
                    "Investigación de Mercados",
                    "Relaciones Públicas",
                    "Gestión de Marca"
                ]
            ],
            [
                "departamento" => "Ventas",
                "subdepartamentos" => [
                    "Ventas Directas",
                    "Ventas en Línea",
                    "Atención al Cliente",
                    "Postventa"
                ]
            ],
            [
                "departamento" => "Operaciones",
                "subdepartamentos" => [
                    "Logística",
                    "Producción",
                    "Mantenimiento",
                    "Control de Calidad"
                ]
            ],
            [
                "departamento" => "Tecnología de la Información",
                "subdepartamentos" => [
                    "Desarrollo de Software",
                    "Soporte Técnico",
                    "Seguridad Informática",
                    "Administración de Redes"
                ]
            ],
            [
                "departamento" => "Compras",
                "subdepartamentos" => [
                    "Proveedores",
                    "Inventarios",
                    "Almacén",
                    "Negociación de Contratos"
                ]
            ],
            [
                "departamento" => "Investigación y Desarrollo",
                "subdepartamentos" => [
                    "Innovación",
                    "Desarrollo de Productos",
                    "Pruebas y Ensayos"
                ]
            ],
            [
                "departamento" => "Legal",
                "subdepartamentos" => [
                    "Asuntos Corporativos",
                    "Cumplimiento Normativo",
                    "Propiedad Intelectual"
                ]
            ],
            [
                "departamento" => "Comunicación",
                "subdepartamentos" => [
                    "Comunicación Interna",
                    "Comunicación Externa",
                    "Gestión de Crisis"
                ]
            ]
        ];

        foreach ($dataSeeder as $data) {
            $departament = new Departament();
            $departament->name = $data["departamento"];
            $departament->save();

            $rndm1 = rand(3, 12);

            for ($i = 0; $i < $rndm1; $i++) {
                $isSave = rand(0, 3);

                $employee = new Employee();
                $employee->departament_id = $departament->id;
                $employee->name = $isSave == 1 ? getRandomName() : null;
                $employee->level = rand(0, 3);
                $employee->save();


                if ($isSave == 1) {
                    $findDepartament = Departament::find($departament->id);
                    $findDepartament->ambassador = $employee->id;
                    $findDepartament->save();
                }
            }

            foreach ($data["subdepartamentos"] as $subdepartamentName) {
                $existingDepartament = Departament::where('name', $subdepartamentName)->first();

                if (!$existingDepartament) {
                    $subdepartament = new Departament();
                    $subdepartament->name = $subdepartamentName;
                    $subdepartament->departament_dad_id = $departament->id;
                    $subdepartament->save();
                } else {
                    $subdepartament = $existingDepartament;
                }

                $rndm2 = rand(3, 12);

                for ($i = 0; $i < $rndm2; $i++) {
                    $isSave = rand(0, 8);

                    $employeeSD = new Employee();
                    $employeeSD->departament_id = $subdepartament->id;
                    $employeeSD->name = $isSave == 1 ? getRandomName() : null;
                    $employeeSD->level = rand(0, 3);
                    $employeeSD->save();


                    if ($isSave == 1) {
                        $findDepartament = Departament::find($subdepartament->id);
                        $findDepartament->ambassador = $employeeSD->id;
                        $findDepartament->save();
                    }
                }
            }
        }
    }
}
