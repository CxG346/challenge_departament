/* eslint-disable @typescript-eslint/no-explicit-any */
export const columnsOrganization = (filterOptions: {text: string; value: number}[]) => [
  {
    title: "Division",
    dataIndex: "name",
    sorter: (a: any, b: any) => {
      return a.name.localeCompare(b.name);
    },
    filters: filterOptions,
  },
  {
    title: "Division superior",
    dataIndex: "departament_dad_id",
    render: (departament: { name: string; }) => departament ? departament.name : '--',
    sorter: (a: any, b: any) => {
      return a.departament_dad_id.name.localeCompare(b.departament_dad_id.name);
    },
  },
  {
    title: "Colaboradores",
    dataIndex: "employees_count",
    sorter: (a: any, b: any) => {
      return a.employees_count - b.employees_count;
    }
  },
  {
    title: "Nivel",
    dataIndex: "level",
    render: () => '--',
  },
  {
    title: "Subdivisiones",
    dataIndex: "subdivision_count",
  },
  {
    title: "Embajadores",
    dataIndex: "ambassador",
    render: (ambassador: { name: string; }) => ambassador ? ambassador.name : '--',
    sorter: (a: any, b: any) => {
      return a.ambassador.name.localeCompare(b.ambassador.name);
    },
  },
];