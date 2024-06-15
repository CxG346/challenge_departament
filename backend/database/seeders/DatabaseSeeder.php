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
                $employee = new Employee();
                $employee->departament_id = $departament->id;
                if($i == 0){
                    $employee->name = "Ambassador " . $departament->name;
                }
                $employee->level = rand(0, 3);
                $employee->save();
            }

            foreach ($data["subdepartamentos"] as $subdepartamentName) {
                $subdepartament = new Departament();
                $subdepartament->name = $subdepartamentName;
                $subdepartament->departament_dad_id = $departament->id;
                $subdepartament->save();

                $rndm1 = rand(3, 12);

                for ($i = 0; $i < $rndm1; $i++) {
                    $employee = new Employee();
                    $employee->departament_id = $subdepartament->id;
                    if($i == 0){
                        $employee->name = "Ambassador " . $subdepartamentName;
                    }
                    $employee->level = rand(0, 3);
                    $employee->save();
                }
            }
        }
    }
}
