import React from 'react';

export const Badge = ({ children, icon: Icon }) => (
  <span className="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">
    {Icon && <Icon size={12} />}
    {children}
  </span>
);