// src/Components/Avatar.jsx
import PropTypes from "prop-types";
import React from "react";

export function Avatar({ className }) {
  return (
    // "women-2.png" is set as a background image. Adjust size/position to match your design.
    <div
      className={`bg-cover bg-center ${className}`}
      style={{ backgroundImage: "url('/img/landing/women-2.png')" }}
    />
  );
}

Avatar.propTypes = {
  className: PropTypes.string,
};
