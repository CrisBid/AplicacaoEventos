import React, { useState, useEffect } from 'react';
import axios from 'axios';

const EventList: React.FC = () => {
  const [featuredEvents, setFeaturedEvents] = useState<Event[]>([]);

  useEffect(() => {
    // Aqui, você pode fazer a chamada para o backend PHP e obter a lista de eventos

    axios
      .get('/api/featured-events')
      .then((response) => setFeaturedEvents(response.data))
      .catch((error) => console.log(error));
  }, []);

  return (
    <div>
      <h1>Lista de Eventos</h1>
      {/* Renderize a lista de eventos aqui */}
      <ul>
        {featuredEvents.map((event:any) => (
          <li key={event.id}>{event.title}</li>
        ))}
      </ul>
    </div>
  );
};

export default EventList;
