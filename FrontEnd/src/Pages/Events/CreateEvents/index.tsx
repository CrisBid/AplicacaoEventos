import React, { useState, ChangeEvent } from 'react';
import api from '../../../api/axios';
import './styles.css'

interface Event {
  name: string;
  date: string;
  location: string;
}

const CreateEventPage: React.FC = () => {
  const [event, setEvent] = useState<Event>({
    name: '',
    date: '',
    location: '',
  });

  const handleInputChange = (event: ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setEvent((prevEvent) => ({
      ...prevEvent,
      [name]: value,
    }));
  };

  const handleCreateEvent = () => {
    api
      .post('/api/events', event)
      .then((response) => {
        // Lógica após a criação do evento bem-sucedida
        console.log(response.data); // Exemplo: exibir dados da resposta
      })
      .catch((error) => {
        // Lógica em caso de erro na criação do evento
        console.error(error);
      });
  };

  return (
    <div className="create-event-container">
      <h1>Criar Evento</h1>
      <form>
        <div className="form-group">
          <label>Nome</label>
          <input
            type="text"
            name="name"
            value={event.name}
            onChange={handleInputChange}
          />
        </div>
        <div className="form-group">
          <label>Data</label>
          <input
            type="date"
            name="date"
            value={event.date}
            onChange={handleInputChange}
          />
        </div>
        <div className="form-group">
          <label>Localização</label>
          <input
            type="text"
            name="location"
            value={event.location}
            onChange={handleInputChange}
          />
        </div>
        <button type="button" onClick={handleCreateEvent}>
          Criar Evento
        </button>
      </form>
    </div>
  );
};

export default CreateEventPage;
