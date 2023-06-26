import React, { useState } from 'react';
import axios from 'axios';

const Login: React.FC = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleEmailChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setEmail(event.target.value);
  };

  const handlePasswordChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setPassword(event.target.value);
  };

  const handleLogin = () => {
    // Fazer a chamada para o backend PHP para autenticar o usuário
    axios
      .post('/api/login', { email, password })
      .then((response) => {
        // Lógica após o login bem-sucedido
        console.log(response.data); // Exemplo: exibir dados da resposta
      })
      .catch((error) => {
        // Lógica em caso de erro de autenticação
        console.error(error);
      });
  };

  return (
    <div>
      <h1>Login</h1>
      <form>
        <div>
          <label>Email:</label>
          <input type="email" value={email} onChange={handleEmailChange} />
        </div>
        <div>
          <label>Senha:</label>
          <input type="password" value={password} onChange={handlePasswordChange} />
        </div>
        <button type="button" onClick={handleLogin}>Login</button>
      </form>
    </div>
  );
};

export default Login;
