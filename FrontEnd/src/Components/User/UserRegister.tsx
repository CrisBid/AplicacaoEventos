import React, { useState } from 'react';
import './UserRegisterStyles.css';
import api from '../../api/axios';
import axios from 'axios';

const Register: React.FC = () => {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [registerdata, setRegisterdata] = useState('');

  const handleNameChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setName(event.target.value);
  };

  const handleEmailChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setEmail(event.target.value);
  };

  const handlePasswordChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setPassword(event.target.value);
  };

  const handleRegister = async () => {
    const data = { 
      name: name,
      email: email,
      password: password,
      role: 'admin', 
    };

  
    try {
      const response = await api.post('users/register', data);
      // Lógica após o registro bem-sucedido
      setRegisterdata(response.data.id);
      console.log(response.data); // Exemplo: exibir dados da resposta
    } catch (error) {
      // Lógica em caso de erro de registro
      console.error(error);
    }
  };
  
  return (
    <div className="container">
      <h1>Register</h1>
      <form className="form">
        <div>
          <label className="textofinput">Name</label>
          <input type="text" value={name} onChange={handleNameChange} className="input-field" />
        </div>
        <div>
          <label className="textofinput">Email</label>
          <input type="email" value={email} onChange={handleEmailChange} className="input-field" />
        </div>
        <div>
          <label className="textofinput">Password</label>
          <input type="password" value={password} onChange={handlePasswordChange} className="input-field" />
        </div>
        <button type="button" onClick={handleRegister} className="register-button">Register</button>
      </form>
    </div>
  );
};

export default Register;
