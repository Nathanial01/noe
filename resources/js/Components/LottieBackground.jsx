// src/components/LottieBackground.jsx
import React, { useEffect, useState } from "react";
import Lottie from "lottie-react";

const LottieBackground = () => {
  const [animationData, setAnimationData] = useState(null);

  useEffect(() => {
    fetch("/GIF/noe.json")
      .then((res) => res.json())
      .then((data) => setAnimationData(data))
      .catch((err) => console.error("Error loading Lottie JSON:", err));
  }, []);

  if (!animationData) {
    return (
      <div className="w-full sm:w-1/2 h-64 sm:h-[213px] bg-gray-300 flex items-center justify-center">
        Loading GIF...
      </div>
    );
  }

  return (
    <div className="w-full sm:w-1/2 h-64 sm:h-[213px]">
      <Lottie animationData={animationData} loop={true} />
    </div>
  );
};

export default LottieBackground;
