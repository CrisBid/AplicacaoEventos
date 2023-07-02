import { useState, useEffect } from 'react';
import axios from 'axios';
import defaultAvatar from '../../../../public/Images/Profile.png';
import './styles.css';

interface UserData {
  name: string;
  email: string;
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
    const fetchUserProfile = async () => {
      try {
        const profileResponse = await axios.get('/api/users/profile');
        setUserData(profileResponse.data);
      } catch (error) {
        console.error(error);
      }
    };

    const fetchEventHistory = async () => {
      try {
        const historyResponse = await axios.get('/api/users/history');
        setEventHistory(historyResponse.data);
      } catch (error) {
        console.error(error);
      }
    };

    fetchUserProfile();
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
        <p>Name: {userData?.name}</p>
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
