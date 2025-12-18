import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import { Monitor, LogOut, User } from 'lucide-react';
import { Button } from '../ui/Button';

export const Header = () => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/');
  };

  return (
    <header className="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
      <div className="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
        {/* Логотип */}
        <Link to="/" className="flex items-center gap-2 text-indigo-600 font-bold text-xl hover:opacity-80 transition">
          <Monitor className="fill-indigo-600/20" /> MonitorMarket
        </Link>

        {/* Навигация */}
        <nav className="flex items-center gap-6">
          <Link to="/" className="hover:text-indigo-600 transition-colors font-medium text-gray-700">Главная</Link>
          <Link to="/catalog" className="hover:text-indigo-600 transition-colors font-medium text-gray-700">Каталог</Link>

          {user ? (
            <div className="flex items-center gap-4 ml-2 pl-4 border-l border-gray-200">
              <span className="flex items-center gap-2 font-medium bg-gray-100 px-3 py-1 rounded-full text-sm text-gray-700">
                <User size={14}/> {user.name}
              </span>
              <button
                onClick={handleLogout}
                className="text-red-400 hover:text-red-600 transition-colors"
                title="Выйти"
              >
                <LogOut size={20}/>
              </button>
            </div>
          ) : (
            <Button onClick={() => navigate('/login')} className="px-6 ml-2">
              Войти
            </Button>
          )}
        </nav>
      </div>
    </header>
  );
};