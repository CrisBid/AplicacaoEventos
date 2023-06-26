// Importe as dependências necessárias
import React from 'react';
import EventList from '../../Components/EventList';

// Defina o componente Home
const Home: React.FC = () => {
  return (
    <div>
      <h1>Lista de Eventos em Destaque</h1>
      <EventList/>
    </div>
  );
};

export default Home;
