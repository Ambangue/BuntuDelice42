import HeroSection from "@/components/home/HeroSection";
import EssentialServices from "@/components/home/EssentialServices";
import AdditionalServices from "@/components/home/AdditionalServices";
import ProfessionalServices from "@/components/home/ProfessionalServices";
import SpecializedServices from "@/components/home/SpecializedServices";
import CulturalServices from "@/components/home/CulturalServices";
import Testimonials from "@/components/home/Testimonials";
import Newsletter from "@/components/home/Newsletter";
import Footer from "@/components/Footer";

const Index = () => {
  return (
    <div className="min-h-screen">
      <HeroSection />
      <EssentialServices />
      <AdditionalServices />
      <ProfessionalServices />
      <SpecializedServices />
      <CulturalServices />
      <Testimonials />
      <Newsletter />
      <Footer />
    </div>
  );
};

export default Index;