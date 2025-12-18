import axios from 'axios';

const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
  },
});

/**
 * Получение списка мониторов
 * @param {number} page
 * @param {number} limit
 */
export const getMonitors = async (page = 1, limit = 10) => {
  const response = await api.get('/goods', {
    params: { page, limit }
  });
  return response.data;
};

/**
 * Получение одного монитора
 * @param {number|string} id
 */
export const getMonitorById = async (id) => {
  const response = await api.get(`/goods/${id}`);
  return response.data;
};

export default api;