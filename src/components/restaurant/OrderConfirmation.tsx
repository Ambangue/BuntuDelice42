import { Dialog, DialogContent, DialogHeader, DialogTitle } from "@/components/ui/dialog";
import MobilePayment from "@/components/MobilePayment";

interface OrderConfirmationProps {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  onPaymentComplete: () => void;
  amount: number;
}

const OrderConfirmation = ({ open, onOpenChange, onPaymentComplete, amount }: OrderConfirmationProps) => {
  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent>
        <DialogHeader>
          <DialogTitle>Paiement mobile</DialogTitle>
        </DialogHeader>
        <MobilePayment amount={amount} onPaymentComplete={onPaymentComplete} />
      </DialogContent>
    </Dialog>
  );
};

export default OrderConfirmation;