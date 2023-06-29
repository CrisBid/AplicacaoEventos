import React from 'react';
import './styles.css';

const Layout: React.FC = ({ children }:any) => {
  return (
    <div>
      <header>
        <h1>Meu App</h1>
        <nav>
          {/* Links de navegação */}
        </nav>
        <p>Usuario</p>
      </header>
      <main>
        {children}
      </main>
    </div>
  );
};

export default Layout;
