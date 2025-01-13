import React, { useState } from 'react';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { toast } from "@/components/ui/use-toast";
import { supabase } from "@/integrations/supabase/client";

interface MobilePaymentProps {
  amount: number;
  onPaymentComplete: () => void;
  driverId?: string;
  orderId?: string;
  description?: string;
}

const MobilePayment: React.FC<MobilePaymentProps> = ({ 
  amount, 
  onPaymentComplete,
  driverId,
  orderId,
  description 
}) => {
  const [phoneNumber, setPhoneNumber] = useState('');
  const [provider, setProvider] = useState('mtn');
  const [loading, setLoading] = useState(false);

  const handlePayment = async () => {
    setLoading(true);
    try {
      // Simuler un paiement pour la démonstration
      await new Promise(resolve => setTimeout(resolve, 2000));
      
      // Si c'est un paiement de livreur, créer l'enregistrement
      if (driverId) {
        const { error } = await supabase
          .from('driver_payments')
          .insert({
            driver_id: driverId,
            amount,
            payment_method: provider,
            description,
            order_id: orderId,
            status: 'completed',
            paid_at: new Date().toISOString()
          });

        if (error) throw error;
      }
      
      toast({
        title: "Paiement initié",
        description: "Veuillez confirmer le paiement sur votre téléphone",
      });
      
      // Simuler la confirmation du paiement
      await new Promise(resolve => setTimeout(resolve, 3000));
      
      toast({
        title: "Paiement réussi",
        description: "Votre paiement a été confirmé",
      });
      
      onPaymentComplete();
    } catch (error) {
      console.error("Erreur de paiement:", error);
      toast({
        title: "Erreur de paiement",
        description: "Une erreur est survenue lors du paiement",
        variant: "destructive",
      });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      <div className="space-y-4">
        <Label>Choisissez votre opérateur</Label>
        <RadioGroup
          defaultValue={provider}
          onValueChange={setProvider}
          className="grid grid-cols-2 gap-4"
        >
          <div className="flex items-center space-x-2">
            <RadioGroupItem value="mtn" id="mtn" />
            <Label htmlFor="mtn">MTN Mobile Money</Label>
          </div>
          <div className="flex items-center space-x-2">
            <RadioGroupItem value="airtel" id="airtel" />
            <Label htmlFor="airtel">Airtel Money</Label>
          </div>
        </RadioGroup>
      </div>

      <div className="space-y-2">
        <Label htmlFor="phone">Numéro de téléphone</Label>
        <Input
          id="phone"
          type="tel"
          placeholder="Ex: +243..."
          value={phoneNumber}
          onChange={(e) => setPhoneNumber(e.target.value)}
        />
      </div>

      <div className="space-y-2">
        <Label>Montant à payer</Label>
        <div className="text-2xl font-bold">{amount.toLocaleString()} FCFA</div>
      </div>

      <Button
        className="w-full"
        onClick={handlePayment}
        disabled={!phoneNumber || loading}
      >
        {loading ? "Traitement en cours..." : "Payer maintenant"}
      </Button>
    </div>
  );
};

export default MobilePayment;