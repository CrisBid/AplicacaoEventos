import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import "./App.css";

import Home from './Pages/Home';

import LoginPage from './Pages/User/Login';
import RegisterPage from './Pages/User/Register';

import UserProfilePage from './Pages/User/UserProfile';

import EventListPage from './Pages/Events/EventList';
import EventDetailsPage from './Pages/Events/EventDetails';
import CreateEventPage from './Pages/Events/CreateEvents';
import EditEventPage from './Pages/Events/EditEvent';

import AdminDashboardPage from './Pages/AdminDashboard';

import Layout from './Components/Layout';

const App: React.FC = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/login" element={<LoginPage/>} />
        <Route path="/register" element={<RegisterPage/>} />
        <Route path="/" element={<Layout/>}>
          <Route index element={<Home />} />
          <Route path="home" element={<Home />} />
          <Route path="eventlist" element={<EventListPage/>} />
          <Route path="events/:eventId" element={<EventDetailsPage />} />
          <Route path="eventcreate" element={<CreateEventPage/>} />
          <Route path="eventedit/:eventId" element={<EditEventPage />} />
          <Route path="profile" element={<UserProfilePage/>} />
          <Route path="dashboard" element={<AdminDashboardPage/>} />
        </Route>
      </Routes>
  </BrowserRouter>
  );
};

export default App;
