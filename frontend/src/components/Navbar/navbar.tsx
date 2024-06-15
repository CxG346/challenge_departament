import React, { useState } from "react";
import { Layout, Menu, MenuProps } from "antd";
import styles from "./Navbar.module.less";
import logoUrl from "../../assets/logos/x.svg";
import { FaAngleDown, FaBriefcase, FaQuestionCircle, FaBell } from 'react-icons/fa';

const { Header } = Layout;

type MenuItem = Required<MenuProps>["items"][number];

const items: MenuItem[] = [
  {
    label: "Dashboard",
    key: "dashboard",
  },
  {
    label: "Organización",
    key: "organization",
  },
  {
    label: (
      <>
        Modelos <FaAngleDown />
      </>
    ),
    key: "models",
    children: [
      {
        type: "group",
        label: "Item 1",
        children: [
          { label: "Option 1", key: "setting:1" },
          { label: "Option 2", key: "setting:2" },
        ],
      },
      {
        type: "group",
        label: "Item 2",
        children: [
          { label: "Option 3", key: "setting:3" },
          { label: "Option 4", key: "setting:4" },
        ],
      },
    ],
  },
  {
    label:(
      <>
        Seguimiento <FaAngleDown />
      </>
    ),
    key: "tracker",
    children: [
      {
        type: "group",
        label: "Item 1",
        children: [
          { label: "Option 1", key: "setting:1" },
          { label: "Option 2", key: "setting:2" },
        ],
      },
      {
        type: "group",
        label: "Item 2",
        children: [
          { label: "Option 3", key: "setting:3" },
          { label: "Option 4", key: "setting:4" },
        ],
      },
    ],
  },
];

const actions: MenuItem[] = [
  {
    label: (
      <>
        <FaBriefcase />
      </>
    ),
    key: "briefcase",
  },
  {
    label: (
      <>
        <FaQuestionCircle />
      </>
    ),
    key: "question",
  },
  {
    label: (
      <>
        <FaBell />
      </>
    ),
    key: "question",
  },
  {
    label: (
      <>
        Administrador <FaAngleDown />
      </>
    ),
    key: "question",
  },
  
];

const NavbarComponent: React.FC = () => {
  const [current, setCurrent] = useState("organization");
  const [currentAction, setCurrentAction] = useState(""); 

  const onClick: MenuProps["onClick"] = (e) => {
    console.log("click ", e);
    setCurrent(e.key);
  };

  const onClickAction: MenuProps["onClick"] = (e) => {
    console.log("click ", e);
    setCurrentAction(e.key);
  };

  return (
    <Layout className="layout">
      <Header className={styles.header}>
          <img src={logoUrl} />
          <Menu
            theme="dark"
            onClick={onClick}
            selectedKeys={[current]}
            mode="horizontal"
            items={items}
          />
          <Menu
            theme="dark"
            onClick={onClickAction}
            selectedKeys={[currentAction]}
            mode="horizontal"
            className={styles.rightMenu}
            items={actions}
          />
      </Header>
    </Layout>
  );
};

export default NavbarComponent;
