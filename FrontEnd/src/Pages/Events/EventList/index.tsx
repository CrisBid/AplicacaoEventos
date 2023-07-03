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

const EventListPage: React.FC = () => {
  const [events, setEvents] = useState<Event[]>([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('');

  useEffect(() => {
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
        <h1>Event List</h1>

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
            <option value="">All Categories</option>
            <option value="parties">Parties</option>
            <option value="bars">Bars</option>
            <option value="shows">Shows</option>
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
                <p>Category: {event.category}</p>
                <Link to={`/events/${event.id}`}>
                  <button className='eventbutton'>Saiba mais</button>
                </Link>
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
