import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from './Pages/Home';
import LoginPage from './Pages/Login';
import EventListPage from './Pages/EventList';
import EventDetailsPage from './Pages/EventDetails';

const App: React.FC = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/">
          <Route index element={<Home />} />
          <Route path="login" element={<LoginPage/>} />
          <Route path="eventlist" element={<EventListPage/>} />
          <Route path="eventdetails" element={<EventDetailsPage/>} />
        </Route>
      </Routes>
  </BrowserRouter>
  );
};

export default App;
