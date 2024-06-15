/* eslint-disable @typescript-eslint/no-explicit-any */
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
  const [filterOptions, setFilterOptions] = useState<
    { text: string; value: number }[]
  >([]);
  const [pageSize, setPageSize] = useState<number>(10);

  const dispatch = useDispatch();

  useEffect(() => {
    const fetchDepartamentNames = async () => {
      try {
        const response = await DepartamentService.getDepartamentNames();
        setFilterOptions(
          response.data.map((data: { name: any }) => ({
            text: data.name,
            value: data.name,
          }))
        );
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

  const handleTableAction = (
    filters: any,
    sorter: any
  ) => {
    if (sorter.order) {
      const params = {
        sortField: sorter.field,
        sortOrder: sorter.order.substring(0, 3) == "asc" ? "asc" : "desc",
      };
      fetchData(params);
    } else if (filters.name != null) {
      const params = {
        filter: "name",
        search: filters.name.map((data: any) => `${data}`).join(","),
      };
      fetchData(params);
    } else {
      console.log("Entro");
      fetchData({});
    }
  };

  const handlePagination = (
    page: number,
    pageSize: React.SetStateAction<number>
  ) => {
    setPageSize(pageSize);
    fetchData({ page, perPage: pageSize });
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
          onChange={(_, filters, sorter) =>
            handleTableAction(filters, sorter)
          }
        />
        <Row justify="end">
          <Pagination
            defaultCurrent={1}
            total={total}
            pageSize={pageSize}
            showSizeChanger={true}
            onChange={(page, pageSize) => handlePagination(page, pageSize)}
          />
        </Row>
      </Col>
    </Row>
  );
};

export default TableComponent;
