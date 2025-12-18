import React from 'react';

export const Button = ({ children, onClick, variant = 'primary', className = '' }) => {
  const variants = {
    primary: "bg-indigo-600 text-white hover:bg-indigo-700",
    outline: "border border-indigo-600 text-indigo-600 hover:bg-indigo-50",
    danger: "bg-red-50 text-red-600 hover:bg-red-100"
  };
  return (
    <button
      onClick={onClick}
      className={`px-4 py-2 rounded-lg font-medium transition-colors ${variants[variant]} ${className}`}
    >
      {children}
    </button>
  );
};