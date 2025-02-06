import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { supabase } from "@/integrations/supabase/client";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import DeliveryMap from "@/components/DeliveryMap";
import { Clock, MapPin, Car, CreditCard, Star, Phone, MessageSquare, Shield } from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";
import { Button } from '@/components/ui/button';
import { useToast } from '@/hooks/use-toast';
import RatingDialog from './RatingDialog';
import { TaxiRide } from '@/integrations/supabase/types';

export default function RideStatus() {
  const { rideId } = useParams<{ rideId: string }>();
  const [ride, setRide] = useState<TaxiRide | null>(null);
  const [driverLocation, setDriverLocation] = useState<{lat: number, lng: number} | null>(null);
  const [error, setError] = useState<string | null>(null);
  const { toast } = useToast();
  const [showRatingDialog, setShowRatingDialog] = useState(false);

  useEffect(() => {
    const fetchRide = async () => {
      if (!rideId) {
        setError('Identifiant de course invalide');
        return;
      }

      try {
        const { data, error } = await supabase
          .from('taxi_rides')
          .select(`
            *,
            driver:delivery_drivers(
              id,
              current_latitude,
              current_longitude,
              user_id,
              profiles:user_id(
                first_name,
                last_name,
                avatar_url
              )
            )
          `)
          .eq('id', rideId)
          .single();

        if (error) {
          console.error('Error fetching ride:', error);
          setError('Erreur lors du chargement de la course');
          return;
        }

        if (!data) {
          console.error('No ride found');
          setError('Course non trouvée');
          return;
        }

        setRide(data as TaxiRide);
        
        if (data.driver) {
          setDriverLocation({
            lat: data.driver.current_latitude,
            lng: data.driver.current_longitude
          });
        }
      } catch (err) {
        console.error('Unexpected error:', err);
        setError('Une erreur inattendue est survenue');
      }
    };

    fetchRide();

    // Subscribe to changes
    const channel = supabase
      .channel('taxi-ride-updates')
      .on(
        'postgres_changes',
        {
          event: '*',
          schema: 'public',
          table: 'taxi_rides',
          filter: `id=eq.${rideId}`
        },
        (payload) => {
          console.log('Ride update received:', payload);
          const updatedRide = payload.new as TaxiRide;
          setRide(updatedRide);
        }
      )
      .subscribe();

    // Subscribe to driver location updates if driver is assigned
    if (ride?.driver_id) {
      const driverChannel = supabase
        .channel('driver-location')
        .on(
          'postgres_changes',
          {
            event: 'UPDATE',
            schema: 'public',
            table: 'delivery_drivers',
            filter: `id=eq.${ride.driver_id}`
          },
          (payload) => {
            console.log('Driver location update:', payload);
            setDriverLocation({
              lat: payload.new.current_latitude,
              lng: payload.new.current_longitude
            });
          }
        )
        .subscribe();

      return () => {
        supabase.removeChannel(driverChannel);
      };
    }

    return () => {
      supabase.removeChannel(channel);
    };
  }, [rideId, ride?.driver_id]);

  const getStatusBadge = (status: string) => {
    const variants: Record<string, { variant: "default" | "secondary" | "destructive", label: string, icon: React.ReactNode }> = {
      'pending': { variant: "secondary", label: "En attente d'un chauffeur", icon: <Clock className="w-4 h-4" /> },
      'accepted': { variant: "default", label: "Chauffeur en route", icon: <Car className="w-4 h-4" /> },
      'in_progress': { variant: "default", label: "En course", icon: <MapPin className="w-4 h-4" /> },
      'completed': { variant: "default", label: "Terminée", icon: <Shield className="w-4 h-4" /> },
      'cancelled': { variant: "destructive", label: "Annulée", icon: <Shield className="w-4 h-4" /> }
    };

    const statusInfo = variants[status] || variants['pending'];
    
    return (
      <Badge variant={statusInfo.variant} className="flex items-center gap-2">
        {statusInfo.icon}
        {statusInfo.label}
      </Badge>
    );
  };

  const handleContactDriver = () => {
    toast({
      title: "Contact chauffeur",
      description: "Le chauffeur sera notifié de votre demande de contact.",
    });
  };

  if (error) {
    return (
      <Card className="p-6 max-w-2xl mx-auto">
        <div className="text-red-500">{error}</div>
      </Card>
    );
  }

  if (!ride) {
    return (
      <Card className="p-6 max-w-2xl mx-auto">
        <div className="animate-pulse space-y-4">
          <div className="h-4 bg-secondary rounded w-3/4"></div>
          <div className="h-4 bg-secondary rounded w-1/2"></div>
          <div className="h-32 bg-secondary rounded"></div>
        </div>
      </Card>
    );
  }

  return (
    <div className="max-w-4xl mx-auto p-6 space-y-6">
      <motion.div
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="space-y-6"
      >
        <Card className="p-6 space-y-6 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 border-gray-700">
          <div className="flex justify-between items-start">
            <h2 className="text-2xl font-bold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
              Suivi de votre course
            </h2>
            <AnimatePresence mode="wait">
              <motion.div
                key={ride.status}
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -20 }}
              >
                {getStatusBadge(ride.status)}
              </motion.div>
            </AnimatePresence>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="space-y-4">
              <div className="bg-gray-800/50 p-4 rounded-lg backdrop-blur-sm">
                <div className="flex items-center space-x-2 text-sm text-gray-400">
                  <MapPin className="h-4 w-4" />
                  <span>Point de départ</span>
                </div>
                <p className="font-medium mt-1">{ride.pickup_address}</p>
              </div>
              
              <div className="bg-gray-800/50 p-4 rounded-lg backdrop-blur-sm">
                <div className="flex items-center space-x-2 text-sm text-gray-400">
                  <MapPin className="h-4 w-4" />
                  <span>Destination</span>
                </div>
                <p className="font-medium mt-1">{ride.destination_address}</p>
              </div>
            </div>

            <div className="space-y-4">
              <div className="bg-gray-800/50 p-4 rounded-lg backdrop-blur-sm">
                <div className="flex items-center space-x-2 text-sm text-gray-400">
                  <Clock className="h-4 w-4" />
                  <span>Heure de prise en charge</span>
                </div>
                <p className="font-medium mt-1">
                  {new Date(ride.pickup_time).toLocaleString()}
                </p>
              </div>
              
              <div className="bg-gray-800/50 p-4 rounded-lg backdrop-blur-sm">
                <div className="flex items-center space-x-2 text-sm text-gray-400">
                  <CreditCard className="h-4 w-4" />
                  <span>Prix estimé</span>
                </div>
                <p className="font-medium mt-1">
                  {ride.estimated_price?.toLocaleString()} FCFA
                </p>
              </div>
            </div>
          </div>

          {ride.driver && (
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="mt-6 p-4 bg-gray-800/50 rounded-lg backdrop-blur-sm"
            >
              <div className="flex items-center justify-between">
                <div className="flex items-center space-x-4">
                  <div className="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center">
                    <Car className="h-6 w-6 text-white" />
                  </div>
                  <div>
                    <h3 className="font-medium">Votre chauffeur</h3>
                    <p className="text-sm text-gray-400">
                      {ride.driver.profiles?.first_name ?? ''} {ride.driver.profiles?.last_name ?? ''}
                    </p>
                  </div>
                </div>
                <div className="flex gap-2">
                  <Button
                    variant="outline"
                    size="sm"
                    className="flex items-center gap-2"
                    onClick={handleContactDriver}
                  >
                    <Phone className="h-4 w-4" />
                    Appeler
                  </Button>
                  <Button
                    variant="outline"
                    size="sm"
                    className="flex items-center gap-2"
                    onClick={handleContactDriver}
                  >
                    <MessageSquare className="h-4 w-4" />
                    Message
                  </Button>
                </div>
              </div>
            </motion.div>
          )}

          {(ride.pickup_latitude && ride.pickup_longitude) && (
            <div className="h-64 mt-6 rounded-lg overflow-hidden border border-gray-700">
              <DeliveryMap
                latitude={driverLocation?.lat || ride.pickup_latitude}
                longitude={driverLocation?.lng || ride.pickup_longitude}
                orderId={ride.id}
              />
            </div>
          )}

          {ride.status === 'completed' && (
            <Button
              onClick={() => setShowRatingDialog(true)}
              className="mt-4 w-full"
            >
              Évaluer la course
            </Button>
          )}

          {ride.status === 'completed' && (
            <RatingDialog
              open={showRatingDialog}
              onOpenChange={setShowRatingDialog}
              rideId={ride.id}
            />
          )}
        </Card>
      </motion.div>
    </div>
  );
}
