import React from "react";

export default function HeroSection() {
    return (
        <section className="container mx-auto relative h-screen right-96 bottom-64">
            {/* "Make your" positioned at the top */}
            <div className="relative h-full flex items-center justify-center">
                <div className="absolute top-96 left-4 z-30">
                    <h1
                        className="
            text-4xl sm:text-6xl md:text-7xl lg:text-[64px]
            font-semibold leading-tight m-0
            bg-clip-text text-transparent drop-shadow-md font-[Poppins]
            bg-[linear-gradient(90deg,#FFF_58%,#7344B8_100%)]
          "
                    >
                        Make your
                    </h1>
                </div>

                {/* Main hero content container */}

                {/* "Dre" Element */}
                <div className="absolute left-2 z-10">
                    <h1
                        className="
              text-[120px] sm:text-[200px] lg:text-[350px]
              font-black leading-[109%] font-[Poppins]
              bg-clip-text text-transparent
              bg-[linear-gradient(287deg,#581CAF_22.12%,#BEB0D1_44.63%,#FFF_66.82%)]
            "
                    >
                        Dre
                    </h1>
                </div>

                {/* Avatar Element */}
                <div className="absolute z-20 mx-4 mr-64 mt-[480px] ">
                    <div
                        className="
              w-[300px] h-[375px]
              sm:w-[500px] sm:h-[600px]
              lg:w-[807px] lg:h-[959px]
              bg-cover bg-no-repeat bg-center
              bg-[url('/img/landing/women-2.png')]
            "
                    />
                </div>

                {/* "am" Element */}
                <div className="absolute right-64 mt-52 z-30">
                    <h1
                        className="
              text-[120px] sm:text-[200px] lg:text-[350px]
              font-black leading-[109%] font-[Poppins]
              bg-clip-text text-transparent
              bg-[linear-gradient(282deg,#F1AB4F_-0.07%,#581CAF_85.35%)]
            "
                    >
                        am
                    </h1>
                </div>

                {/* "Come true!" Element */}
                <div className=" mt-[1000px] -mr-[1500px] z-40 sm:hidden">
                    <h2
                        className="
              text-4xl sm:text-6xl md:text-7xl lg:text-[180px]
              font-semibold text-right m-0 font-[Poppins]
              bg-clip-text text-transparent
              bg-[linear-gradient(90deg,#5B1FAD_0%,#FC0_100%)]
            "
                    >
                        Come true!
                    </h2>
                </div>
            </div>
        </section>
    );
}

