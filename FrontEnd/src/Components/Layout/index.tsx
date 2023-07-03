import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import './styles.css';
import { Outlet } from 'react-router-dom';
import defaultAvatar from '../../Images/Profile.png';
import { useNavigate } from 'react-router-dom';

interface UserData {
  id: number;
  user: string;
  email: string;
  Authtoken: string;
  avatar?: string;
}

const Layout: React.FC = ({ children }: any) => {
  const [menuOpen, setMenuOpen] = useState(false);
  const [isLoggedIn, setisLoggedIn] = useState(false);
  const [userData, setUserData] = useState<UserData | undefined>();
  const navigate = useNavigate();

  useEffect(() => {
    // Verificar se o usuário já está logado (se há dados no localStorage)
    const userDataString = localStorage.getItem('userData');
    if (userDataString) {
      const userData: UserData = JSON.parse(userDataString);
      // Redirecionar para a página de dashboard caso o usuário já esteja logado
      setUserData(userData);
      setisLoggedIn(true);
    }
  }, []);

  const toggleMenu = () => {
    setMenuOpen(!menuOpen);
  };

  const handleLogout = () => {
    localStorage.removeItem('userData');
    setUserData(undefined);
    setisLoggedIn(false);
    navigate('/home');
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
              <p>{userData?.user}</p>
            </div>
            {menuOpen && (
              <ul className="dropdown-menu">
                <div className="dropdown_menuContainer">
                  <Link to="/profile">Perfil</Link>
                  <button onClick={handleLogout} className="dropdown_menuContainer_button">Logout</button>
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
