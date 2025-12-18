import React from 'react';
import { useServerGoods } from '../hooks/useServerGoods.js';
import { Loader2, AlertCircle } from 'lucide-react';

const CatalogPage = () => {
  const { goods, loading, error, hasMore, loadMore, refresh } = useServerGoods(12);

  if (loading && goods.length === 0) {
    return (
      <div className="flex flex-col items-center justify-center min-h-[400px]">
        <Loader2 className="w-12 h-12 text-blue-600 animate-spin mb-4" />
        <p className="text-gray-500">Загрузка мониторов...</p>
      </div>
    );
  }

  if (error) {
    return (
      <div className="bg-red-50 border border-red-200 rounded-xl p-8 text-center">
        <AlertCircle className="w-12 h-12 text-red-500 mx-auto mb-4" />
        <h2 className="text-xl font-bold text-red-800 mb-2">Ошибка соединения</h2>
        <p className="text-red-600 mb-6">{error}</p>
        <button
          onClick={refresh}
          className="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition"
        >
          Попробовать снова
        </button>
      </div>
    );
  }

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-3xl font-bold text-gray-900">Каталог мониторов</h1>
        <p className="text-gray-500 mt-2">Найдено товаров: {goods.length}</p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {goods.map((monitor) => (
          <div key={monitor.id} className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
            <div className="aspect-video bg-gray-100 relative">
              <div className="absolute inset-0 flex items-center justify-center text-gray-400">
                [Изображение монитора {monitor.name}]
              </div>
            </div>
            <div className="p-5">
              <div className="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-2">
                {monitor.specs?.matrix || 'IPS'}
              </div>
              <h3 className="text-lg font-bold text-gray-900 mb-1 line-clamp-1">{monitor.name}</h3>
              <p className="text-sm text-gray-500 mb-4 line-clamp-2">{monitor.description}</p>
              <div className="flex items-center justify-between mt-auto">
                <span className="text-xl font-black text-gray-900">
                  {Number(monitor.price).toLocaleString()} ₽
                </span>
                <button className="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition">
                  В корзину
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      {hasMore && (
        <div className="flex justify-center pt-6">
          <button
            onClick={loadMore}
            disabled={loading}
            className="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 transition"
          >
            {loading ? 'Загрузка...' : 'Загрузить ещё'}
          </button>
        </div>
      )}
    </div>
  );
};

export default CatalogPage;