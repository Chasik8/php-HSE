import React from 'react';
import { BrowserRouter, Routes, Route, Navigate, useLocation } from 'react-router-dom';
import { AuthProvider, useAuth } from './context/AuthContext';
import { Header } from './components/layout/Header';

import HomePage from './pages/HomePage';
import LoginPage from './pages/LoginPage';
import CatalogPage from './pages/CatalogPage';
import ProductPage from './pages/ProductPage';

const ProtectedRoute = ({ children }) => {
  const { user } = useAuth();
  const location = useLocation();

  if (!user) {
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  return children;
};

const AppContent = () => {
  return (
    <div className="min-h-screen bg-gray-50 text-gray-900 font-sans">
      <Header /> {/* Хедер теперь доступен на всех страницах */}

      <main className="max-w-7xl mx-auto px-4 py-8">
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/login" element={<LoginPage />} />

          <Route
            path="/catalog"
            element={
              <ProtectedRoute>
                <CatalogPage />
              </ProtectedRoute>
            }
          />

          <Route path="/product/:id" element={<ProductPage />} />

          {/* Маршрут для 404 (опционально) */}
          <Route path="*" element={<div className="text-center py-20">Страница не найдена</div>} />
        </Routes>
      </main>
    </div>
  );
};

export default function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <AppContent />
      </BrowserRouter>
    </AuthProvider>
  );
}