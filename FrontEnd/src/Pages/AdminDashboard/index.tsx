import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './styles.css';
import api from '../../api/axios';

interface Event {
  id: string;
  name: string;
  date: string;
  location: string;
}

interface Registration {
  id: string;
  eventId: string;
  userId: string;
}

interface User {
  id: string;
  name: string;
  email: string;
  role: string;
}

interface UserData {
  id: number;
  user: string;
  email: string;
  Authtoken: string;
  avatar?: string;
}

interface AdminDashboardProps {}

const AdminDashboardPage: React.FC<AdminDashboardProps> = () => {
  const [events, setEvents] = useState<Event[]>([]);
  const [registrations, setRegistrations] = useState<Registration[]>([]);
  const [users, setUsers] = useState<User[]>([]);
  const [userData, setUserData] = useState<UserData | undefined>();

  useEffect(() => {

    const userDataString = localStorage.getItem('userData');
    if (userDataString) {
      const userData: UserData = JSON.parse(userDataString);
      // Redirecionar para a página de dashboard caso o usuário já esteja logado
      setUserData(userData);
    } 

    fetchEvents(userData?.id);
    fetchRegistrations(userData?.id);
    fetchUsers();
  }, []);

  const fetchEvents = async (userId: number | undefined) => {
    try {
      const response = await axios.get(`events/registrations/user/${userId}`);
      const eventList = response.data;
      setEvents(eventList);
    } catch (error) {
      console.error(error);
    }
  };

  const fetchRegistrations = async (userId: number| undefined) => {
    try {
      const response = await axios.get(`events/registrations/user/${userId}`);
      const registrationList = response.data;
      setRegistrations(registrationList);
    } catch (error) {
      console.error(error);
    }
  };

  const fetchUsers = async () => {
    try {
      const response = await api.get('/users');
      const userList = response.data;
      setUsers(userList);
    } catch (error) {
      console.error(error);
    }
  };

  const handleDeleteUser = async (userId: string) => {
    try {
      await api.delete(`users/delete/${userId}`);
      fetchUsers();
    } catch (error) {
      console.error(error);
    }
  };

  const handleModifyUser = async (userId: string) => {
    // Lógica para modificar o usuário
  };

  return (
    <div className="admin-dashboard-container">
      <h1>Admin Dashboard</h1>
      <div className="dashboard-section">
        <h2>Events</h2>
        <ul>
          {events.map((event) => (
            <li key={event.id}>{event.name}</li>
          ))}
        </ul>
      </div>
      <div className="dashboard-section">
        <h2>Registrations</h2>
        <ul>
          {registrations.map((registration) => (
            <li key={registration.id}>{registration.userId}</li>
          ))}
        </ul>
      </div>
      <div className="dashboard-section">
        <h2>Users</h2>
        <ul>
          {users.map((user) => (
            <div key={user.id} className='userlist-container'>
              <div className='userlistinfo-container'>
                <p>Nome</p>
                <p>{user.name}</p>
              </div>
              <div className='userlistinfo-container'>
                <p>Email</p>
                <p>{user.email}</p>
              </div>
              <div className='userlistinfo-container'>
                <p>Nivel de Acesso</p>
                <p>{user.role}</p>
              </div>
              <div className='button-container'>
                <button onClick={() => handleDeleteUser(user.id)}>Deletar</button>
                <button onClick={() => handleModifyUser(user.id)}>Modificar</button>
              </div>
            </div>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default AdminDashboardPage;
