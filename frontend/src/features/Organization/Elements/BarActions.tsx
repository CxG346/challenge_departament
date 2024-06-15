import React, { useState } from "react";
import { Col, Row } from "antd";
import { Menu } from "antd";
import style from "../Organization.module.less";
import {
  DownloadOutlined,
  PlusOutlined,
  UploadOutlined,
} from "@ant-design/icons";
import { Button, Flex } from "antd";

import type { MenuProps } from "antd";

type MenuItem = Required<MenuProps>["items"][number];

const items: MenuItem[] = [
  {
    label: "Divisiones",
    key: "divisions",
  },
  {
    label: "Colaboradores",
    key: "partners",
    disabled: true,
  },
];

const BarActions: React.FC = () => {
  const [current, setCurrent] = useState("divisions");

  const onClick: MenuProps["onClick"] = (e) => {
    console.log("click ", e);
    setCurrent(e.key);
  };

  return (
    <Row className={style.mainHeader}>
      <Col span={18}>
        <Row>
          <h3>Organización</h3>
        </Row>
        <Row>
          <Menu
            onClick={onClick}
            selectedKeys={[current]}
            mode="horizontal"
            items={items}
          />
        </Row>
      </Col>
      <Col span={6} className={style.actions}>
        <Flex gap="small" wrap>
          <Button type="primary" icon={<PlusOutlined />} size={"large"} />
          <Button
            type="default"
            icon={<UploadOutlined style={{ color: "#1890FF" }} />}
            size={"large"}
          />
          <Button
            type="default"
            icon={<DownloadOutlined style={{ color: "#1890FF" }} />}
            size={"large"}
          />
        </Flex>
      </Col>
    </Row>
  );
};

export default BarActions;
