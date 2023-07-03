import React, { useState, useEffect } from 'react';
import api from '../api/axios';
import './EventListStyles.css';
import defaultAvatar from '../Images/Event.jpg';

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

const EventList: React.FC = () => {
  const [featuredEvents, setFeaturedEvents] = useState<Event[]>([]);

  useEffect(() => {
    // Aqui, você pode fazer a chamada para o backend PHP e obter a lista de eventos

    api
      .get('events')
      .then((response) => setFeaturedEvents(response.data))
      .catch((error) => console.log(error));
  }, []);

  const imgSrc = defaultAvatar;

  return (
    <div className="event-list-container">
      <h1 className="event-list-title">Lista de Eventos</h1>
      <ul className="event-list">
        {featuredEvents.map((event: any) => (
          <div key={event.id} className="event-list-item">
            <div className="EventImg_Container">
              <img className="EventImg" src={event.img || imgSrc} alt="EventImg" />
            </div>
            <div className="EventText_Container">
              <p>Nome</p>
              <p>{event.name}</p>
            </div>
            <div className="EventText_Container">
              <p>Data</p>
              <p>{event.date}:{event.time}</p>
            </div>
          </div>
        ))}
      </ul>
    </div>
  );
};

export default EventList;
