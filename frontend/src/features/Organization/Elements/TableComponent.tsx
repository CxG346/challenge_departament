import React, { useEffect, useState } from "react";
import type { TableProps } from "antd";
import { Row, Table, Col, Pagination } from "antd";
import { columnsOrganization } from "../../../data/tableOrganization";
import style from "../Organization.module.less";
import { Departament } from "../../../data/models/models";
import { useDispatch, useSelector } from "react-redux";
import DepartamentService from "../../../services/departaments.service";
import { setData, setTotal } from "../../../store/TableSlice";

const TableComponent: React.FC = () => {
  const tableProps: TableProps<Departament> = {
    bordered: true,
    size: "large",
    rowSelection: {},
    pagination: false,
  };
  const [filterOptions, setFilterOptions] = useState<{text: string; value: number}[]>([]);

  const dispatch = useDispatch();

  useEffect(() => {
    const fetchDepartamentNames = async () => {
      try {
        const response = await DepartamentService.getDepartamentNames();
        setFilterOptions(response.data.map(data => ({ text: data.name, value: data.name })));
      } catch (error) {
        console.error("Error fetching departament names:", error);
      }
    };

    fetchDepartamentNames();
  }, []);

  const fetchData = async (params: Record<string, unknown>) => {
    try {
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

  const handleTableAction = (pagination, filters, sorter) => {
    console.log("pagination", pagination);
    console.log("filters", filters);
    console.log("sorter", sorter);
    console.log('sorter.order', sorter.order)
    console.log('filters.name', filters.name)

    if(sorter.order){
      const params = {sortField: sorter.field, sortOrder: sorter.order.substring(0, 3) == 'asc' ? 'asc' : 'desc'};
      fetchData(params);
    }else if(filters.name != null){
      const params = {filter: 'name', search: filters.name.map(data => `${data}`).join(",")};
      fetchData(params);
    }else{
      console.log('Entro')
      fetchData({});
    }
  };

  const data = useSelector((state: any) => state.table.data);
  const total = useSelector((state: any) => state.table.total);

  return (
    <Row className={style.tableData}>
      <Col span={23}>
        <Table
          {...tableProps}
          columns={columnsOrganization(filterOptions)}
          dataSource={data}
          onChange={(pagination, filters, sorter) =>
            handleTableAction(pagination, filters, sorter)
          }
        />
        <Row justify="end">
          <Pagination defaultCurrent={1} total={total} />
        </Row>
      </Col>
    </Row>
  );
};

export default TableComponent;
