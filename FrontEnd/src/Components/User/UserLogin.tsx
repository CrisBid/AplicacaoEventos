import React, { useState, useEffect } from 'react';
import './UserLoginStyles.css'
import api from '../../api/axios';
import { useNavigate } from 'react-router-dom';

const Login: React.FC = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    // Verificar se o usuário já está logado (se há dados no localStorage)
    const userData = localStorage.getItem('userData');
    if (userData) {
      // Redirecionar para a página de dashboard caso o usuário já esteja logado
      navigate('/dashboard');
    }
  }, []);

  const handleEmailChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setEmail(event.target.value);
  };

  const handlePasswordChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setPassword(event.target.value);
  };

  const handleLogin = () => {
    // Fazer a chamada para o backend PHP para autenticar o usuário
    api
      .post('users/login', { email, password })
      .then((response) => {
        // Lógica após o login bem-sucedido
        console.log(response.data); // Exemplo: exibir dados da resposta
        // Salvar os dados do usuário no local storage ou em um estado global (ex: Redux)
        localStorage.setItem('userData', JSON.stringify(response.data));
        // Redirecionar para a página de dashboard
        navigate('/dashboard');
      })
      .catch((error) => {
        // Lógica em caso de erro de autenticação
        console.error(error);
      });
  };

  return (
    <div className="container">
      <h1>Login</h1>
      <form className="form">
        <div className="inputcontainer">
          <label className="textofinput">Email</label>
          <input type="email" value={email} onChange={handleEmailChange} className="input-field" />
        </div>
        <div className="inputcontainer">
          <label className="textofinput">Senha</label>
          <input type="password" value={password} onChange={handlePasswordChange} className="input-field" />
        </div>
        <button type="button" onClick={handleLogin} className="login-button">Login</button>
      </form>
    </div>
  );
};

export default Login;
