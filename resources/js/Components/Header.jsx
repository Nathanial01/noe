import React from "react";

export default function Header() {
  return (
    <>
      {/* Right-Side Info at top-right */}
      <div
        className="
          absolute top-[25%] right-4
          sm:top-[23%] sm:right-[10%]
          text-left
          p-2
          max-w-[400px] sm:max-w-[500px] md:max-w-[600px] 
        "
      >
        <h3 className="text-yellow-400 text-xl sm:text-2xl font-bold ">
          #1 TOP INVEST 2025
        </h3>
        <h2 className="mt-2  text-gray-50 lg:text-8xl font-extrabold leading-tight">
          Noé Investment <br />
          <span className="text-gray-50 lg:text-5xl">CONSULTANCY</span>
        </h2>
        <p className="text-gray-50 mt-4 text-base sm:text-lg md:text-xl opacity-80 ">
          Noé is a leading global investment firm. We aim to deliver strong returns
          and shared success to those we serve and the world at large.
        </p>

        {/* Buttons Container */}
        <div className="flex space-x-3 sm:space-x-44 mt-8 sm:mt- items-center">
          {/* Original Button */}
          <button
            className="flrxx relative flex items-center justify-center w-[144.115px] h-[70.435px] flex-shrink-0"
          >
            {/* SVG Background */}
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="144.115px"
              height="70.435px"
              viewBox="0 0 138 69"
              fill="none"
              className="absolute inset-0"
              style={{
                fill: "rgba(111, 9, 121, 0)",
                strokeWidth: "1px",
                stroke: "#F8B147",
              }}
            >
              <path
                d="M18.7063 7.20381L113.63 1.1496C118.975 0.808729 123.902 4.03882 125.721 9.07583L136.292 38.3446C138.92 45.6224 134.1 53.4545 126.419 54.3873L14.6419 67.961C6.6425 68.9324 -0.0348595 61.9246 1.32159 53.9814L7.6039 17.1931C8.54313 11.6931 13.138 7.55895 18.7063 7.20381Z"
              />
            </svg>

            {/* Button Text */}
            <span
              className="relative text-white text-center font-[Poppins] font-semibold"
              style={{
                fontSize: "12.729px",
                width: "83.405px",
                height: "19px",
                lineHeight: "normal",
              }}
            >
              Learn more
            </span>
          </button>

          {/* Added Element: To Dashboard with SVG Arrow */}
          <div className="flex items-center ">
            <a
              href="/dashboard"
              className="flex items-center space-x-2"
              style={{ textDecoration: "none" }}
            >
              <span
                className="text-white text-right font-[Poppins] font-semibold"
                style={{
                  width: "126.103px",
                  height: "21.482px",
                  fontSize: "12.729px",
                  lineHeight: "normal",
                }}
              >
                To Dashboard
              </span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 32 11"
                fill="none"
                style={{
                  width: "29.788px",
                  height: "9.34px",
                  flexShrink: 0,
                  strokeWidth: "0.849px",
                  stroke: "#FF5B79",
                }}
              >
                <path d="M25.5062 0.604004L30.4709 5.274M30.4709 5.274L25.5062 9.944M30.4709 5.274H0.682861" />
              </svg>
            </a>
          </div>
        </div>
      </div>

      {/* Scroll Indicator at bottom-center */}
      <div className="absolute bottom-4 sm:bottom-2 left-1/2 transform -translate-x-1/2 flex flex-col items-center">
        <img
          src="/img/landing/scroll.svg"
          alt="Scroll Down"
          className="h-16 sm:h-10 mb-2"
        />
     
      </div>
    </>
  );
}
