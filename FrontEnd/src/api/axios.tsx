import axios from "axios"

const api = axios.create({
  baseURL: 'http://backend.test'
});

export default api;