import React, { useState, useEffect, ChangeEvent } from 'react';
import { Link } from 'react-router-dom';
import './styles.css'
import api from '../../../api/axios';
import defaultAvatar from '../../../Images/Event.jpg';

interface Event {
  id: number;
  name: string;
  description: string;
  date: string;
  time: string;
  price: string;
  local: string;
  category: string;
  img: string;
  // Add other event properties here
}

interface UserData {
  id: number;
  user: string;
  email: string;
  Authtoken: string;
  avatar?: string;
}

const EventListPage: React.FC = () => {
  const [events, setEvents] = useState<Event[]>([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('');
  const [userData, setUserData] = useState<UserData | undefined>();

  useEffect(() => {
    const userDataString = localStorage.getItem('userData');
    if (userDataString) {
      const userData: UserData = JSON.parse(userDataString);
      // Redirecionar para a página de dashboard caso o usuário já esteja logado
      setUserData(userData);
    } 
    fetchEvents();
  }, []);

  const fetchEvents = async () => {
    try {
      const response = await api.get('/events');
      setEvents(response.data);
    } catch (error) {
      console.error(error);
    }
  };

  const handleSearchChange = (event: ChangeEvent<HTMLInputElement>) => {
    setSearchTerm(event.target.value);
  };

  const handleCategoryChange = (event: ChangeEvent<HTMLSelectElement>) => {
    setSelectedCategory(event.target.value);
  };

  const handleRegister = async (eventId: number) => {

    const data = { 
      userId: userData?.id, 
      eventId: eventId 
    };

    try {
      // Fazer chamada para a API para registrar o usuário no evento
      await api.post('events/registrate', data);
      console.log('Usuário registrado no evento com sucesso!');
    } catch (error) {
      console.error(error);
    }
  };

  let filteredEvents: Event[] = [];
  if (events.length > 0) {
    filteredEvents = events.filter((event) =>
      event.name.toLowerCase().includes(searchTerm.toLowerCase()) &&
      (selectedCategory === '' || event.category === selectedCategory)
    );
  }

  const imgSrc = defaultAvatar;

  return (
    <div className="container">
      <div className="headercontainer">
        <h1>Eventos</h1>

        <div className="search-container">
          <input
            type="text"
            className="search-input"
            placeholder="Search"
            value={searchTerm}
            onChange={handleSearchChange}
          />

          <select
            value={selectedCategory}
            onChange={handleCategoryChange}
            className="category-select"
          >
            <option value="">Todas as Categorias</option>
            <option value="conferencias">Conferências</option>
            <option value="festivais">Festivais</option>
            <option value="concertos">Concertos</option>
            <option value="feiras">Feiras</option>
            <option value="palestras">Palestras</option>
            <option value="workshops">Workshops</option>
            <option value="exposicoes">Exposições</option>
            <option value="eventos_esportivos">Eventos esportivos</option>
            <option value="cursos_treinamentos">Cursos e treinamentos</option>
            <option value="eventos_networking">Eventos de networking</option>
          </select>
        </div>
      </div>
      <div className="bodycontainer">
        {filteredEvents.length > 0 ? (
          filteredEvents.map((event) => (
            <div key={event.id} className='eventcontainer'>
              <div className="EventImg_Container">
                <img className="EventImg" src={event.img || imgSrc} alt="EventImg" />
              </div>
              <div className='eventtextscontainer'>
                <h3>{event.name}</h3>
                <p>{event.description}</p>
                <p>{event.date}:{event.time}</p>
                <p>Category: {event.category}</p>
                <Link to={`/events/${event.id}`}>
                  <button className='eventbutton'>Saiba mais</button>
                </Link>
                <button onClick={() => handleRegister(event.id)} className='eventbutton'>Registrar</button>
              </div>
            </div>
          ))
        ) : (
          <div className="no-events-container">
            <p>Não há eventos disponíveis.</p>
          </div>
        )}
          <Link to="/eventcreate" className="create-event-button">Criar Evento</Link>
      </div>
    </div>
  );
};

export default EventListPage;
