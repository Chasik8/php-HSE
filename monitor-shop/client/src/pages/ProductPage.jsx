import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Card } from '../components/ui/Card';
import { Button } from '../components/ui/Button';
import { ChevronRight, Monitor } from 'lucide-react';
import { getMonitorById } from '../services/ApiService.js';

export default function ProductPage() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [item, setItem] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchItem = async () => {
      try {
        const data = await getMonitorById(id);
        setItem(data);
      } catch (err) {
        setError('Не удалось загрузить товар');
        console.error(err);
      } finally {
        setLoading(false);
      }
    };
    fetchItem();
  }, [id]);

  if (loading) return <div className="text-center py-20">Загрузка данных...</div>;
  if (error || !item) return <div className="text-center py-20">Товар не найден</div>;

  return (
    <div className="max-w-4xl mx-auto">
      <button
        onClick={() => navigate('/catalog')}
        className="mb-4 text-gray-500 hover:text-indigo-600 flex items-center text-sm"
      >
        <ChevronRight className="rotate-180 w-4 h-4 mr-1" /> Назад в каталог
      </button>
      <Card className="flex flex-col md:flex-row p-0">
        <div className="md:w-1/2 bg-gray-50 flex items-center justify-center p-10">
          <Monitor size={140} className="text-gray-400" />
        </div>
        <div className="md:w-1/2 p-8">
          <div className="mb-4">
            <h1 className="text-3xl font-bold text-gray-900">{item.name}</h1>
            <p className="text-sm text-gray-500 mt-1">Дата выхода: {item.releaseDate}</p>
          </div>
          <div className="text-3xl font-bold text-indigo-600 mb-6">
            {Number(item.price).toLocaleString()} ₽
          </div>
          <div className="space-y-3 mb-8">
            <h3 className="font-semibold text-gray-900">Характеристики:</h3>
            <ul className="text-sm text-gray-600 space-y-2">
              <li className="flex justify-between border-b pb-1">
                <span>Разрешение</span> <span className="font-medium text-gray-900">{item.specs?.resolution}</span>
              </li>
              <li className="flex justify-between border-b pb-1">
                <span>Частота обновления</span> <span className="font-medium text-gray-900">{item.specs?.refreshRate}</span>
              </li>
              <li className="flex justify-between border-b pb-1">
                <span>Тип матрицы</span> <span className="font-medium text-gray-900">{item.specs?.matrix}</span>
              </li>
            </ul>
          </div>
          <p className="text-gray-600 mb-8 leading-relaxed">{item.description}</p>
          <Button className="w-full py-3">Добавить в корзину</Button>
        </div>
      </Card>
    </div>
  );
}