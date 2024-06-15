import BarActions from "./Elements/BarActions";
import TableFilters from "./Elements/TableFilters";
import TableComponent from "./Elements/TableComponent";
import { useEffect } from "react";
import DepartamentService from "../../services/departaments.service";
import { useDispatch } from "react-redux";
import { setData, setTotal } from "../../store/TableSlice";

const OrganizationComponent: React.FC = () => {
  const dispatch = useDispatch();

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await DepartamentService.getDepartaments();
        console.log(response);
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

    fetchData();
  }, [dispatch]);

  return (
    <>
      <BarActions></BarActions>
      <TableFilters></TableFilters>
      <TableComponent></TableComponent>
    </>
  );
};

export default OrganizationComponent;
