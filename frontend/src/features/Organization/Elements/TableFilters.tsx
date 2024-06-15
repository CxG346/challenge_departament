/* eslint-disable @typescript-eslint/no-explicit-any */
/* eslint-disable @typescript-eslint/no-unused-vars */
import { Row, Col, Radio, RadioChangeEvent, Select, Input } from "antd";
import React, { useState } from "react";
import style from "../Organization.module.less";
import { SearchProps } from "antd/es/input";
import { useDispatch } from "react-redux";
import { setData, setTotal } from "../../../store/TableSlice";
import DepartamentService from "../../../services/departaments.service";

const options = [
  {
    value: "name",
    label: "División",
  },
  {
    value: "departament_dad_id.name",
    label: "Divisón superior",
  },
  {
    value: "ambassador.name",
    label: "Embajadores",
  },
];

const { Search } = Input;

const TableFilters: React.FC = () => {
  const [placement, SetPlacement] = useState<"list" | "tree">("list");
  const [filterTable, setFilterTable] = useState("name");

  const dispatch = useDispatch();

  

  const fetchData = async (filter: string, search: string) => {
    try {
      const params = { filter, search };
      const response = await DepartamentService.getDepartaments(params);
      if (response.data && response.total) {
        dispatch(
          setData(
            response.data.map((departament: any) => ({
              ...departament,
              key: departament.id,
            }))
          )
        );
        dispatch(setTotal(response.total));
      } else {
        console.error("Unexpected response format:", response);
      }
    } catch (error) {
      console.error("Error fetching departaments:", error);
    }
  };

  const placementChange = (e: RadioChangeEvent) => {
    SetPlacement(e.target.value);
  };

  const onSearch: SearchProps["onSearch"] = (value, _, __) => {
    fetchData(filterTable, value);
  };

  const handleChange = (option: string) => {
    setFilterTable(option);
  };

  return (
    <Row className={style.tableActions}>
      <Col span={16}>
        <Radio.Group value={placement} onChange={placementChange}>
          <Radio.Button value="list">Listado</Radio.Button>
          <Radio.Button value="tree">Árbol</Radio.Button>
        </Radio.Group>
      </Col>
      <Col span={8} className={style.filterTable}>
        <Select
          defaultValue="name"
          options={options}
          onChange={handleChange}
          style={{ width: "40%" }}
        />
        <Search
          placeholder="input search text"
          onSearch={onSearch}
          style={{ width: "50%" }}
        />
      </Col>
    </Row>
  );
};

export default TableFilters;
