import React, { useState, ChangeEvent } from 'react';
import api from '../../../api/axios';
import './styles.css';
import { useNavigate } from 'react-router-dom';

interface Event {
  name: string;
  date: string;
  local: string;
  description: string;
  time: string;
  category: string;
  price: number;
  img: string;
}

const CreateEventPage: React.FC = () => {
  const [event, setEvent] = useState<Event>({
    name: '',
    date: '',
    local: '',
    description: '',
    time: '',
    category: '',
    price: 0,
    img: '',
  });

  const navigate = useNavigate();

  const handleInputChange = (event: ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = event.target;
    setEvent((prevEvent) => ({
      ...prevEvent,
      [name]: value
    }));
  };
  

  const handleCreateEvent = () => {
    api
      .post('events/create', event)
      .then((response) => {
        // Lógica após a criação do evento bem-sucedida
        console.log(response.data); // Exemplo: exibir dados da resposta
        navigate('/eventlist');
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
          <label>Descrição</label>
          <input
            type="text"
            name="description"
            value={event.description}
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
          <label>Hora</label>
          <input
            type="time"
            name="time"
            value={event.time}
            onChange={handleInputChange}
          />
        </div>
        <div className="form-group">
          <label>Localização</label>
          <input
            type="text"
            name="local"
            value={event.local}
            onChange={handleInputChange}
          />
        </div>
        <div className="form-group">
          <label>Categoria</label>
          <select
            value={event.category}
            onChange={(event) => handleInputChange(event)}
            className="category-select"
            name="category"
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

        <div className="form-group">
          <label>Preço</label>
          <input
            type="number"
            name="price"
            value={event.price}
            onChange={handleInputChange}
          />
        </div>
        <div className="form-group">
          <label>Imagem</label>
          <input
            type="text"
            name="img"
            value={event.img}
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
