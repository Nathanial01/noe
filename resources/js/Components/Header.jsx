import React from "react";

export default function Header() {
    return (
        <header className="w-full bg-none">
            <div className="relative z-10 px-4 text-center">
                <h3 className="text-yellow-400 text-2xl sm:text-3xl font-bold uppercase tracking-wide">
                    #1 TOP INVEST 2025
                </h3>
                <div
                    className="w-full text-center sm:text-center text-white font-poppins font-semibold leading-normal"
                    style={{
                        textShadow: "0px 4px 4px rgba(0, 0, 0, 0.25)",
                        WebkitTextStrokeWidth: "4px",
                        WebkitTextStrokeColor: "#FFF",
                    }}
                >
                    <h1 className="mt-4 text-4xl sm:text-8xl font-light sm:font-extrabold text-white leading-tight">
                        Noé Capital <br />
                        <span className="text-4xl sm:text-6xl">CONSULTANCY</span>
                    </h1></div>
                <p className="mt-6 text-xl sm:text-2xl text-white opacity-90">
                    Noé is a leading global investment firm. We aim to deliver strong returns
                    and shared success to those we serve and the world at large.
                </p>
                <div className="mt-10 flex flex-col sm:flex-row items-center justify-center gap-8">

                    {/* Buttons Section */}


                    <button className="relative flex items-center justify-center w-[144.115px] h-[70.435px] flex-shrink-0">
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
                        <span className="relative text-white text-center font-[Poppins] font-semibold text-sm">
              Learn more
            </span>
                    </button>


                    <a
                        href="/dashboard"
                        className="flex items-center space-x-2 text-white font-semibold uppercase hover:underline"
                    >
                        <span>To Dashboard</span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 32 11"
                            fill="none"
                            width="30"
                            height="10"
                            stroke="#FF5B79"
                            strokeWidth="0.8"
                        >
                            <path d="M25.5062 0.604004L30.4709 5.274M30.4709 5.274L25.5 6.2949 9.944 5.274M30.4709 5.274H0.682861" />
                        </svg>
                    </a>
                </div>

            </div>
        </header>
    );
}

