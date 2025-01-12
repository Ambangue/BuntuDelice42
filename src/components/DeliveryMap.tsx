import { useEffect, useRef } from 'react';
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import { supabase } from '@/integrations/supabase/client';

interface DeliveryMapProps {
  latitude?: number;
  longitude?: number;
  zoom?: number;
}

const DeliveryMap = ({ 
  latitude = 48.8566, 
  longitude = 2.3522, 
  zoom = 13 
}: DeliveryMapProps) => {
  const mapContainer = useRef<HTMLDivElement>(null);
  const map = useRef<mapboxgl.Map | null>(null);

  useEffect(() => {
    const initializeMap = async () => {
      const { data: { token }, error } = await supabase.rpc('get_secret', {
        name: 'MAPBOX_PUBLIC_TOKEN'
      });

      if (error) {
        console.error('Error fetching Mapbox token:', error);
        return;
      }

      if (!token || typeof token !== 'string') {
        console.error('Invalid Mapbox token');
        return;
      }

      mapboxgl.accessToken = token;

      if (mapContainer.current) {
        map.current = new mapboxgl.Map({
          container: mapContainer.current,
          style: 'mapbox://styles/mapbox/streets-v11',
          center: [longitude, latitude],
          zoom: zoom
        });

        new mapboxgl.Marker()
          .setLngLat([longitude, latitude])
          .addTo(map.current);
      }
    };

    initializeMap();

    return () => {
      if (map.current) {
        map.current.remove();
      }
    };
  }, [latitude, longitude, zoom]);

  return (
    <div ref={mapContainer} className="w-full h-[400px] rounded-lg" />
  );
};

export default DeliveryMap;