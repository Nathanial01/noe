// src/components/Background.jsx
import React from "react";

const bg = "/img/landing/bg.png"; // Ensure this path is correct

const Background = () => {
  return (
    <div
      className="absolute inset-0 w-full h-full bg-cover bg-center "
      style={{ backgroundImage: `url(${bg})` }}
    />
  );
};

export default Background;
