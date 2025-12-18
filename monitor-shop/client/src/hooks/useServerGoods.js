import { useState, useEffect, useCallback } from 'react';
import { getMonitors } from '../services/ApiService.js';

/**
 * Кастомный хук для загрузки товаров с поддержкой 'Load More'
 * @param {number} initialLimit - количество элементов на одну загрузку
 * @returns {{
 *   goods: Array,
 *   loading: boolean,
 *   error: string | null,
 *   hasMore: boolean,
 *   loadMore: () => void,
 *   refresh: () => void
 * }}
 */
export const useServerGoods = (initialLimit = 10) => {
  const [goods, setGoods] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);

  const fetchData = useCallback(async (isFirstLoad = false) => {
    try {
      setLoading(true);
      setError(null);
      const currentPage = isFirstLoad ? 1 : page;
      const result = await getMonitors(currentPage, initialLimit);
      if (isFirstLoad) {
        setGoods(result.data);
      } else {
        setGoods(prev => [...prev, ...result.data]);
      }
      setHasMore(result.hasMore);
      if (!isFirstLoad) {
        setPage(prev => prev + 1);
      } else {
        setPage(2);
      }
    } catch (err) {
      setError('Ошибка соединения');
      console.error(err);
    } finally {
      setLoading(false);
    }
  }, [page, initialLimit]);

  useEffect(() => {
    fetchData(true);
  }, []);

  return {
    goods,
    loading,
    error,
    hasMore,
    loadMore: () => fetchData(false),
    refresh: () => fetchData(true)
  };
};