import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import './styles.css';
import { Outlet } from 'react-router-dom';
import defaultAvatar from '../../../public/Images/Profile.png';

interface UserData {
  name: string;
  email: string;
  avatar?: string;
}

const Layout: React.FC = ({ children }: any) => {
  const [menuOpen, setMenuOpen] = useState(false);
  const [isLoggedIn, setisLoggedIn] = useState(false);
  const [userData, setUserData] = useState<UserData | undefined>();

  const toggleMenu = () => {
    setMenuOpen(!menuOpen);
  };

  const avatarSrc = userData?.avatar || defaultAvatar;

  return (
    <div>
      <header>
        <h1>Meu App</h1>
        <nav>
          <ul>
            <Link to="/home">Home</Link>
            <Link to="/eventlist">Eventos</Link>
            <Link to="/dashboard">Dashboard</Link>
          </ul>
        </nav>

        {!isLoggedIn && (
            <div className="login-menu">
              <Link to="/login" className="login-button">Login</Link>
              <Link to="/register" className="login-button">Cadastro</Link>
            </div>
          )}
        {isLoggedIn && (
          <div className="user-menu" onClick={toggleMenu}>
            <div className="user-botton-menu">
              <img className="headeravatar" src={avatarSrc} alt="User Avatar" />
              <p>Usuário</p>
            </div>  
            {menuOpen && (
              <ul className="dropdown-menu">
                <div className="dropdown_menuContainer">

                    <Link to="/profile">Perfil</Link>

                    <Link to="/logout">Logout</Link>

                </div>
              </ul>
            )}
          </div>
        )}
      </header>
      <main>
        <Outlet /> {children}
      </main>
    </div>
  );
};

export default Layout;
