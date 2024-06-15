import axios from "axios";

const BASE_URL = 'https://apichallenge.grigorkf.com/api';

class DepartamentService {

  static async getDepartaments(params = {}) {
    try {
      const response = await axios.get(`${BASE_URL}/departament`, { params });
      return response.data;
    } catch (error) {
      console.error(error);
      throw error;
    }
  }

  static async getDepartamentNames() {
    try {
      const response = await axios.get(`${BASE_URL}/departament/listNames`);
      return response;
    } catch (error) {
      console.error(error);
      throw error;
    }
  }
}

export default DepartamentService;
