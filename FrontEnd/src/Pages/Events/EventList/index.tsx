import React, { useState, useEffect, ChangeEvent } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import './styles.css'

interface Event {
  id: number;
  title: string;
  description: string;
  category: string;
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
      const response = await axios.get('/api/events');
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

  const filteredEvents = events.filter((event) =>
    event.title.toLowerCase().includes(searchTerm.toLowerCase()) &&
    (selectedCategory === '' || event.category === selectedCategory)
  );

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
        <ul>
          {filteredEvents.map((event) => (
            <li key={event.id}>
              <h3>{event.title}</h3>
              <p>{event.description}</p>
              <p>Category: {event.category}</p>
              <Link to={`/events/${event.id}`}>
                <button>Saiba mais</button>
              </Link>
            </li>
          ))}
        </ul>
        <Link to="/eventcreate" className="create-event-button">Criar Evento</Link>
      </div>
    </div>
  );
};

export default EventListPage;
