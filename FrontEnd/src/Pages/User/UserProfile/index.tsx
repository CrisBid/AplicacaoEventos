import { useState, useEffect } from 'react';
import axios from 'axios';
import defaultAvatar from '../../../Images/Profile.png';
import './styles.css';
import api from '../../../api/axios';

interface UserData {
  id: number;
  user: string;
  email: string;
  Authtoken: string;
  avatar?: string;
}

interface EventHistory {
  id: number;
  name: string;
  date: string;
  location: string;
}

const UserProfilePage: React.FC = () => {
  const [userData, setUserData] = useState<UserData | undefined>();
  const [eventHistory, setEventHistory] = useState<EventHistory[]>([]);

  useEffect(() => {
      const userDataString = localStorage.getItem('userData');
      if (userDataString) {
        const userData: UserData = JSON.parse(userDataString);
        // Redirecionar para a página de dashboard caso o usuário já esteja logado
        setUserData(userData);
      } 

    const fetchEventHistory = async () => {
      try {
        const historyResponse = await axios.get('/api/users/history');
        setEventHistory(historyResponse.data);
      } catch (error) {
        console.error(error);
      }
    };

    fetchEventHistory();
  }, []);

  const avatarSrc = userData?.avatar || defaultAvatar;

  return (
    <div className="UserProfilecontainer">
      <h1>User Profile</h1>
      <div className="personal-info-container">
        <h2>Informaçoes Pessoais</h2>
        <div className="user-avatar">
          <img className="avatar" src={avatarSrc} alt="User Avatar" />
        </div>
        <p>Name: {userData?.user}</p>
        <p>Email: {userData?.email}</p>
      </div>
      <div className="event-history-container">
        <h2>Historico de Eventos</h2>
        <ul>
          {eventHistory.map((event) => (
            <li key={event.id}>
              <p>Event Name: {event.name}</p>
              <p>Date: {event.date}</p>
              <p>Location: {event.location}</p>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default UserProfilePage;
