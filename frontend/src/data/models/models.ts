export interface Employee {
    id: number;
    departament_id: number;
    level: 0 | 1 | 2 | 3;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface DepartamentDad {
    id: number;
    name: string;
    ambassador: number;
    departament_dad_id: number;
    created_at: string;
    updated_at: string;
}

export interface Departament {
    id: number;
    name: string;
    ambassador: Employee;
    departament_dad_id: DepartamentDad;
    created_at: string;
    updated_at: string;
    employees_count: number;
    subdivision_count: number;
}

export interface Params {
    page?: number;
    perPage?: number;
    sortField?: string;
    sortOrder?: string;
    filter?: string;
    search?: string;
}