import React from "react";

const Background = ({
  background = "/img/landing/global-bg-one.png" // Only one background image
}) => {
  return (
    <div
      className="fixed inset-0 w-full h-full bg-cover bg-center"
      style={{ backgroundImage: `url(${background})` }}
    />
  );
};

export default Background;