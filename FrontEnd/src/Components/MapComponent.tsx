import React, { useEffect } from 'react';
import L from 'leaflet';

interface MapProps {
  latitude: number;
  longitude: number;
}

const MapComponent: React.FC<MapProps> = ({ latitude, longitude }) => {
  useEffect(() => {
    const map = L.map('map').setView([latitude, longitude], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: 'Map data &copy; OpenStreetMap contributors',
      maxZoom: 18,
    }).addTo(map);

    L.marker([latitude, longitude]).addTo(map);
  }, [latitude, longitude]);

  return <div id="map" style={{ height: '300px' }} />;
};

export default MapComponent;
