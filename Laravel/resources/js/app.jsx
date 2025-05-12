import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import Login from './components/Login';

// Inicializar los componentes React
const initReactComponents = () => {
    // Inicializar componente de Login
    const loginContainer = document.getElementById('login-container');
    if (loginContainer) {
        const root = createRoot(loginContainer);
        root.render(<Login />);
    }
};

// Cargar componentes cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initReactComponents); 