import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import MapComponent from '../../../Components/MapComponent';
import api from '../../../api/axios';
import './styles.css';

interface Event {
  id: number;
  name: string;
  description: string;
  date: string;
  time: string;
  location: string;
  category: string;
  price: number;
  latitude: number;
  longitude: number;
}

type EventParams = {
  eventId: string;
};

const EventDetailsPage: React.FC = () => {
  const { eventId } = useParams<EventParams>();
  const [event, setEvent] = useState<Event | null>(null);
  const [isRegistered, setIsRegistered] = useState(false);

  useEffect(() => {
    fetchEvent();
  }, []);

  const fetchEvent = async () => {
    try {
      const response = await api.get(`/events/details/${eventId}`);
      setEvent(response.data[0]);
    } catch (error) {
      console.error(error);
    }
  };

  const handleRegistration = async () => {
    try {
      // Send a POST request to your backend API to register the user for the event
      await api.post(`/events/registrate`, { userId: 'seuUserId', eventId });
      
      // Set the registration status to true
      setIsRegistered(true);
      
      // Optionally, you can show a success message or redirect the user to a confirmation page
    } catch (error) {
      console.error(error);
      // Handle the error, show an error message, or perform any necessary actions
    }
  };

  if (!event) {
    return <div>Loading...</div>;
  }

  return (
    <div className="event-details-container">
      <h1 className="event-title">{event.name}</h1>
      <p className="event-description">{event.description}</p>
      <p className="event-info">Date: {event.date}</p>
      <p className="event-info">Time: {event.time}</p>
      <p className="event-info">Location: {event.location}</p>
      <p className="event-info">Category: {event.category}</p>
      <p className="event-info">Price: {event.price}</p>

      <button
        className="registration-button"
        onClick={handleRegistration}
        disabled={isRegistered}
      >
        {isRegistered ? 'Registered' : 'Register'}
      </button>
    </div>
  );
};

export default EventDetailsPage;
