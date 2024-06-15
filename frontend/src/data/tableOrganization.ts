export const columnsOrganization = (filterOptions: {text: string; value: number}[]) => [
  {
    title: "Division",
    dataIndex: "name",
    sorter: () => {},
    filters: filterOptions,
  },
  {
    title: "Division superior",
    dataIndex: "departament_dad_id",
    render: (departament) => departament ? departament.name : '--',
    sorter: () => {},
  },
  {
    title: "Colaboradores",
    dataIndex: "employees_count",
    sorter: () => a.partners - b.partners,
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
    render: (ambassador) => ambassador ? ambassador.name : '--',
    sorter: () => {},
  },
];
