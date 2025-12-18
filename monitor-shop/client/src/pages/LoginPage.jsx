import React, { useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { Card } from '../components/ui/Card';
import { Button } from '../components/ui/Button';

export default function LoginPage() {
  const [name, setName] = useState('');
  const { login } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();

  const handleSubmit = () => {
    if (name.trim()) {
      login(name);
      const from = location.state?.from?.pathname || '/catalog';
      navigate(from, { replace: true });
    }
  };

  return (
    <div className="flex justify-center items-center min-h-[60vh]">
      <Card className="w-full max-w-sm p-8">
        <h2 className="text-2xl font-bold text-center mb-6">Вход в MonitorMarket</h2>
        <input
          className="w-full px-4 py-2 border rounded-lg mb-4 focus:ring-2 focus:ring-indigo-500 outline-none"
          placeholder="Ваше имя"
          value={name}
          onChange={(e) => setName(e.target.value)}
          onKeyDown={(e) => e.key === 'Enter' && handleSubmit()}
        />
        <Button className="w-full" onClick={handleSubmit}>
          Войти
        </Button>
      </Card>
    </div>
  );
}