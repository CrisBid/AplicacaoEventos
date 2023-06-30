import React, { useState, useEffect } from 'react';
import axios from 'axios';

const EventListPage: React.FC = () => {
  const [events, setEvents] = useState([]);
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

  const handleSearchChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setSearchTerm(event.target.value);
  };

  const handleCategoryChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
    setSelectedCategory(event.target.value);
  };

  const filteredEvents = events.filter(event =>
    event.title.toLowerCase().includes(searchTerm.toLowerCase()) &&
    (selectedCategory === '' || event.category === selectedCategory)
  );

  return (
    <div>
      <h1>Event List</h1>

      <div>
        <input type="text" placeholder="Search" value={searchTerm} onChange={handleSearchChange} />

        <select value={selectedCategory} onChange={handleCategoryChange}>
          <option value="">All Categories</option>
          <option value="parties">Parties</option>
          <option value="bars">Bars</option>
          <option value="shows">Shows</option>
          {/* Add more categories here */}
        </select>
      </div>

      <ul>
        {filteredEvents.map(event => (
          <li key={event.id}>
            <h3>{event.title}</h3>
            <p>{event.description}</p>
            <p>Category: {event.category}</p>
            {/* Display other event details */}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default EventListPage;
