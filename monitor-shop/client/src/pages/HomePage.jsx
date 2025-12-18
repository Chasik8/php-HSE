import React from 'react';
import { useNavigate } from 'react-router-dom';
import { Button } from '../components/ui/Button';
import { Monitor } from 'lucide-react';

export default function HomePage() {
  const navigate = useNavigate();

  return (
    <div className="text-center py-24 px-4">
      <div className="inline-block p-4 bg-indigo-50 rounded-full mb-6 text-indigo-600">
        <Monitor size={48} />
      </div>
      <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
        Твой идеальный монитор
      </h1>
      <p className="text-xl text-gray-600 max-w-2xl mx-auto mb-10">
        Огромный выбор профессиональных и игровых дисплеев. Авторизуйтесь, чтобы получить доступ к эксклюзивному каталогу.
      </p>
      <Button onClick={() => navigate('/catalog')} className="px-8 py-4 text-lg shadow-lg shadow-indigo-200">
        Перейти к выбору
      </Button>
    </div>
  );
}