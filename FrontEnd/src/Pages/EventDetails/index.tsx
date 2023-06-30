import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import MapComponent from '../../Components/MapComponent';

interface Event {
  id: number;
  title: string;
  description: string;
  date: string;
  time: string;
  location: string;
  category: string;
  price: number;
}

const EventDetailsPage: React.FC = () => {
  const { eventId } = useParams<{ eventId: string }>();
  const [event, setEvent] = useState<Event | null>(null);
  const [isRegistered, setIsRegistered] = useState(false);

  useEffect(() => {
    fetchEvent();
  }, []);

  const fetchEvent = async () => {
    try {
      const response = await axios.get(`/api/events/${eventId}`);
      setEvent(response.data);
    } catch (error) {
      console.error(error);
    }
  };

  const handleRegistration = async () => {
    try {
      // Send a POST request to your backend API to register the user for the event
      const response = await axios.post('/api/registrations', {
        eventId: eventId,
        userId: 'currentUserId', // Replace with the actual user ID or a session/user authentication mechanism
      });
      
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
    <div>
      <h1>{event.title}</h1>
      <p>{event.description}</p>
      <p>Date: {event.date}</p>
      <p>Time: {event.time}</p>
      <p>Location: {event.location}</p>
      <p>Category: {event.category}</p>
      <p>Price: {event.price}</p>

      <div>
        <MapComponent latitude={event.latitude} longitude={event.longitude} />
      </div>

        <button onClick={handleRegistration} disabled={isRegistered}>
            {isRegistered ? 'Registered' : 'Register'}
        </button>
    </div>
  );
};

export default EventDetailsPage;
