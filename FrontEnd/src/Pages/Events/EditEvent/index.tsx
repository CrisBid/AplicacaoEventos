import React, { useState, useEffect } from 'react';
import './styles.css';
import api from '../../../api/axios';

interface Event {
  id: string;
  name: string;
  date: string;
  location: string;
}

interface EditEventProps {
  eventId: string;
}

const EditEventPage: React.FC<EditEventProps> = ({ eventId }) => {
    const [event, setEvent] = useState<Event | null>(null);

    useEffect(() => {
      fetchEvent();
    }, []);

  useEffect(() => {
    // Buscar dados do evento existente ao carregar a página
    fetchEvent();
  }, []);

  const fetchEvent = async () => {
    try {
      const response = await api.get(`/api/events/${eventId}`);
      const eventData = response.data;
      setEvent(eventData);
    } catch (error) {
      console.error(error);
    }
  };

  if (!event) {
    return <div>Loading...</div>;
  }

  return (
    <div className="edit-event-container">
      <h1>Edit Event</h1>
      <form>
        <div className="form-group">
          <label htmlFor="name">Name</label>
          <input type="text" id="name" value={event.name} />
        </div>
        <div className="form-group">
          <label htmlFor="date">Date</label>
          <input type="text" id="date" value={event.date} />
        </div>
        <div className="form-group">
          <label htmlFor="location">Location</label>
          <input type="text" id="location" value={event.location} />
        </div>
        <button type="submit">Save</button>
      </form>
    </div>
  );
};

export default EditEventPage;
